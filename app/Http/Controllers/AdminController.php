<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    function index()
    {
        $data = [];

        // judul halaman
        $data['title'] = 'Data Admin';

        // mengambil data kota
        $data['cities'] = City::orderBy('city_name', 'asc')
            ->get([
                'city_code',
                'city_name'
            ]);

        // mengambil data customer dengan kondisi pencarian dan filter kota
        $users = User::whereHas('roles', function ($q) {
            $q->where('name', 'admin');
        })
            ->orderBy(request()->get('sort_column', 'name'), request()->get('sort_direction', 'asc'))
            ->when(request()->search, function ($q) {
                $q->orWhere('name', 'like', '%' . request()->search . '%')
                    ->orWhere('email', 'like', '%' . request()->search . '%');
            })
            ->paginate(10)
            ->withQueryString();

        $data['users'] = $users;

        // sorted column
        $data['sortColumns'] = [
            'name' => 'Nama',
            'email' => 'Email',
        ];

        // menampilkan ke view
        return view('dashboard.pengguna.admin.index', $data);
    }


    function create()
    {
        $data = [];
        // judul halaman
        $data['title'] = 'Tambah Admin';

        // menampilkan ke view
        return view('dashboard.pengguna.admin.create', $data);
    }

    function store(Request $request)
    {
        // membuat rule validasi
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];

        // menvalidasi input
        $validated = $request->validate(
            $rules
        );

        // transaction
        DB::beginTransaction();

        // insert ke user
        $user = User::create([
            'name'  => $request['name'],
            'email' => $request['email'],
            'password'  => Hash::make($request['password'])
        ]);

        // tandai email sebagai teverifikasi
        $user->markEmailAsVerified();

        $user->assignRole('admin');

        DB::commit();
        return redirect(route('admin.index'))
            ->with([
                'success'  => 'Berhasil menambahkan data admin.'
            ]);
    }
}
