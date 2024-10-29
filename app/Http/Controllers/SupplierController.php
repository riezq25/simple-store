<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SupplierController extends Controller
{
    function index()
    {
        $data = [];

        // judul halaman
        $data['title'] = 'Data Suppier';

        // mengambil data kota
        $data['cities'] = City::orderBy('city_name', 'asc')
            ->get([
                'city_code',
                'city_name'
            ]);

        // mengambil data customer dengan kondisi pencarian dan filter kota
        $suppliers = Supplier::orderBy(request()->get('sort_column', 'supplier_name'), request()->get('sort_direction', 'asc'))
            ->when(request()->search, function ($q) {
                $q->where(function ($q) {
                    $q->orWhere('supplier_name', 'like', '%' . request()->search . '%')
                        ->orWhere('email', 'like', '%' . request()->search . '%')
                        ->orWhere('contact_name', 'like', '%' . request()->search . '%')
                        ->orWhere('phone_number', 'like', '%' . request()->search . '%');
                });
            })
            ->when(request()->city && request()->city != 'all', function ($q) {
                $q->where('city_code', request()->city);
            })
            ->with(['city'])
            ->paginate(10)
            ->withQueryString();

        $data['suppliers'] = $suppliers;

        // sorted column
        $data['sortColumns'] = [
            'supplier_name' => 'Nama Supplier',
            'contact_name' => 'Nama Kontak',
            'email' => 'Email',
            'phone_number'  => 'No HP',
        ];

        // menampilkan ke view
        return view('dashboard.data-master.supplier.index', $data);
    }

    function create()
    {
        $data = [];
        // judul halaman
        $data['title'] = 'Tambah Supplier';

        $data['cities'] = City::orderBy('city_name', 'asc')
            ->get([
                'city_code',
                'city_name'
            ]);

        // menampilkan ke view
        return view('dashboard.data-master.supplier.create', $data);
    }

    function store(Request $request)
    {
        // membuat rule validasi
        $rules = [
            'supplier_name' => ['required', 'string', 'max:255'],
            'contact_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:suppliers,email'],
            'phone_number' => ['required', 'string', 'min:8', 'max:15'],
            'city_code' => ['required', 'exists:cities,city_code'],
            'address' => ['nullable', 'string', 'min:3'],
        ];

        $atributes = [
            'supplier_name' => 'Nama Supplier',
            'contact_name'  => 'Nama Kontak',
            'phone_number'  => 'No HP',
            'city_code' => 'Kota',
            'address'   => 'Alamat',
        ];

        // menvalidasi input
        $validated = $request->validate(
            $rules,
            [],
            $atributes
        );

        // transaction
        DB::beginTransaction();

        // insert ke Supplier
        $supplier = Supplier::create($validated);

        DB::commit();
        return redirect(route('supplier.index'))
            ->with([
                'success'  => 'Berhasil menambahkan ' . $supplier->supplier_name . ' (' . $supplier->email . ')'
            ]);
    }

    function edit($id)
    {
        // mengambil data berdasarkan id
        $user = User::findOrFail($id);

        $data = [];
        // judul halaman
        $data['title'] = 'Ubah Supplier';

        $data['user'] = $user;

        // menampilkan ke view
        return view('dashboard.pengguna.admin.edit', $data);
    }

    function update(Request $request, $id)
    {
        // mengambil data berdasarkan id
        $user = User::findOrFail($id);

        // membuat rule validasi
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:users,email,' . $user->id
            ],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ];

        // menvalidasi input
        $validated = $request->validate(
            $rules
        );

        // transaction
        DB::beginTransaction();

        // update user
        $updateData = [
            'name'  => $request['name'],
            'email' => $request['email']
        ];

        if ($validated['password']) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        DB::commit();
        return redirect(route('admin.index'))
            ->with([
                'success'  => 'Berhasil mengubah ' . $user->name . ' (' . $user->email . ')'
            ]);
    }

    function destroy($id)
    {
        // mengambil data berdasarkan id
        $user = User::findOrFail($id);

        DB::beginTransaction();

        // menghapus data
        $user->delete();

        DB::commit();
        return redirect(route('admin.index'))
            ->with([
                'success'  => 'Berhasil menghapus ' . $user->name . ' (' . $user->email . ')'
            ]);
    }
}
