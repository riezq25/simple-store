<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    function index()
    {
        $data = [];

        // judul halaman
        $data['title'] = 'Data Customer';

        // mengambil data kota
        $data['cities'] = City::orderBy('city_name', 'asc')
            ->get([
                'city_code',
                'city_name'
            ]);

        // mengambil data customer dengan kondisi pencarian dan filter kota
        $customers = Customer::query()
             ->orderBy(request()->get('sort_column', 'customer_name'), request()->get('sort_order', 'asc'))
            ->when(request()->search, function ($q) {
                $q->orWhere('customer_name', 'like', '%' . request()->search . '%')
                    ->orWhere('email', 'like', '%' . request()->search . '%')
                    ->orWhere('phone_number', 'like', '%' . request()->search . '%');
            })
            ->when(request()->city && request()->city != 'all', function ($q) {
                $q->where('city_code', request()->city);
            })
            ->with(['city'])
            ->paginate(10)
            ->withQueryString();

        $data['customers'] = $customers;

        // sorted column
        $data['sortColumns'] = [
            'customer_name' => 'Nama',
            'birth_date'    => 'Tanggal Lahir',
            'email' => 'Email',
            'phone_number'  => 'No HP',
        ];

        // menampilkan ke view
        return view('dashboard.pengguna.customer.index', $data);
    }



    function create()
    {
        $data = [];

        // judul halaman
        $data['title'] = 'Tambah Customer';

        // mengambil data kota
        $data['cities'] = City::orderBy('city_name', 'asc')
            ->get([
                'city_code',
                'city_name'
            ]);

        // menampilkan ke view
        return view('dashboard.pengguna.customer.create', $data);
    }

    function store(Request $request)
    {
        // membuat rule validasi
        $rules = [
            'customer_name' => [
                'required',
                'min:3',
                'max:255'
            ],
            'phone_number'  => [
                'required',
                'min:10',
                'max:15'
            ],
            'email' => [
                'required',
                'email',
                'unique:users,email'
            ],
            'birth_date'    => [
                'required',
                'date'
            ],
            'city_code' => [
                'required',
                'exists:cities,city_code'
            ],
            'address'   => [
                'nullabled',
                'min:3'
            ]
        ];

        // membuat nama atribute
        $atributes = [
            'customer_name' => 'Nama',
            'phone_number'  => 'No HP',
            'email' => 'Email',
            'birth_date'    => 'Tanggal Lahir',
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

        // insert ke user
        $user = User::create([
            'name'  => 'Admin',
            'email' => 'admin@amdacademy.id',
            'password'  => Hash::make('password')
        ]);

        // tandai email sebagai teverifikasi
        $user->markEmailAsVerified();

        $user->assignRole('admin');
        // insewrt ke customer


    }
}
