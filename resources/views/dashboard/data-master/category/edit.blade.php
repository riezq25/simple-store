@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-4">{{ $title }}</h5>

            @include('layouts.partials.alert-message')

            <form action="{{ route('category.update', $category->category_id) }}" method="post">
                @csrf
                @method('put')

                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="mb-3">
                            <label for="category_name" class="form-label">Nama Kategori</label>
                            <input required type="text" class="form-control" id="category_name" name="category_name"
                                placeholder="Masukkan nama Kategori"
                                value="{{ old('category_name', $category->category_name) }}">

                            @error('category_name')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save fa-fw me-2"></i>
                    <span>Simpan</span>
                </button>

            </form>

        </div>
    </div>
@endsection
