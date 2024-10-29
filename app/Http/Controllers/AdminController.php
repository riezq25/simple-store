<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
            'name' => [
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
            'name' => 'Nama',
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
