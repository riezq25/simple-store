<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    function index()
    {
        $data = [];

        // judul halaman
        $data['title'] = 'Data Kategori Barang';

        // mengambil data katagori dengan kondisi pencarian dan filter kota
        $categories = Category::orderBy(request()->get('sort_column', 'category_name'), request()->get('sort_direction', 'asc'))
            ->when(request()->search, function ($q) {
                $q->where(function ($q) {
                    $q->orWhere('category_name', 'like', '%' . request()->search . '%');
                });
            })
            ->paginate(10)
            ->withQueryString();

        $data['categories'] = $categories;

        // sorted column
        $data['sortColumns'] = [
            'category_name' => 'Nama',
        ];

        // menampilkan ke view
        return view('dashboard.data-master.category.index', $data);
    }

    function create()
    {
        $data = [];
        // judul halaman
        $data['title'] = 'Tambah Kategori';

        // menampilkan ke view
        return view('dashboard.data-master.category.create', $data);
    }

    function store(Request $request)
    {
        // membuat rule validasi
        $rules = [
            'category_name' => [
                'required',
                'string',
                'max:255'
            ],
        ];

        $atributes = [
            'category_name' => 'Nama Kategori',
        ];

        // menvalidasi input
        $validated = $request->validate(
            $rules,
            [],
            $atributes
        );

        // transaction
        DB::beginTransaction();

        // insert ke kategori
        $category = Category::create($validated);

        DB::commit();
        return redirect(route('category.index'))
            ->with([
                'success'  => 'Berhasil menambahkan ' . $category->category_name
            ]);
    }

    function edit($id)
    {
        // mengambil data berdasarkan id
        $category = Category::findOrFail($id);

        $data = [];
        // judul halaman
        $data['title'] = 'Ubah Kategori';

        $data['category'] = $category;

        // menampilkan ke view
        return view('dashboard.data-master.category.edit', $data);
    }

    function update(Request $request, $id)
    {
        // mengambil data berdasarkan id
        $category = Category::findOrFail($id);
        // membuat rule validasi
        $rules = [
            'category_name' => ['required', 'string', 'max:255']
        ];

        $atributes = [
            'category_name' => 'Nama Kategori',
        ];

        // menvalidasi input
        $validated = $request->validate(
            $rules,
            [],
            $atributes
        );

        // transaction
        DB::beginTransaction();

        // update kategori
        $category->update($validated);

        DB::commit();
        return redirect(route('category.index'))
            ->with([
                'success'  => 'Berhasil mengubah ' . $category->category_name
            ]);
    }

    function destroy($id)
    {
        // mengambil data berdasarkan id
        $category = Category::findOrFail($id);

        DB::beginTransaction();

        // menghapus data
        $category->delete();

        DB::commit();
        return redirect(route('supplier.index'))
            ->with([
                'success'  => 'Berhasil menghapus ' . $category->category_name
            ]);
    }
}
