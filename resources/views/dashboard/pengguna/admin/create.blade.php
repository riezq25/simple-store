@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-4">{{ $title }}</h5>

            @include('layouts.partials.error-message')

            <form action="{{ route('customer.store') }}" method="post">
                @csrf

                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="mb-3">
                            <label for="customer_name" class="form-label">Nama</label>
                            <input required type="text" class="form-control" id="customer_name" name="customer_name"
                                placeholder="Masukkan nama lengkap" value="{{ old('customer_name') }}">

                            @error('customer_name')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="mb-3">
                            <label for="birth_date" class="form-label">Tanggal Lahir</label>
                            <input required type="date" class="form-control" id="birth_date" name="birth_date"
                                placeholder="Masukkan tanggal lahir" value="{{ old('birth_date') }}">

                            @error('birth_date')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input required type="email" class="form-control" id="email" name="email"
                                placeholder="Masukkan email" value="{{ old('email') }}">


                            @error('email')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">No Hp</label>
                            <input required type="text" class="form-control" id="phone_number" name="phone_number"
                                placeholder="Contoh format no HP: 0891234567" value="{{ old('phone_number') }}">

                            @error('phone_number')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="mb-3">
                            <label for="city_code" class="form-label">Kota</label>
                            <select required id="city_code" name="city_code" class="form-select">
                                <option selected disabled">Pilih Kota</option>
                                @foreach ($cities as $city)
                                    <option @selected(old('city_code') == $city->city_code) value="{{ $city->city_code }}">
                                        {{ $city->city_name }}</option>
                                @endforeach
                            </select>

                            @error('city_code')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat</label>
                            <textarea class="form-control" id="address" rows="3">{{ old('address') }}</textarea>

                            @error('address')
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
