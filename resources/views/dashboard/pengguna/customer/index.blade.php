@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-4">{{ $title }}</h5>

            <form action="{{ route('customer.index') }}" method="get">
                <div class="row">
                    <div class="col-sm-12 col-md-5">
                        <div class="mb-3">
                            <input type="text" class="form-control" id="search" name="search"
                                placeholder="Masukkan nama, email atau no HP">
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-5">
                        <div class="mb-3">
                            <select id="city" name="city" class="form-select">
                                <option selected value="all">Semua Kota</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->city_code }}">{{ $city->city_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-2">
                        <button class="btn btn-primary">
                            <i class="fas fa-search fa-fw me-2"></i>
                            <span>Filter</span>
                        </button>
                    </div>
                </div>

            </form>

            <hr class="my-4">

            <div class="table-responsive">
                <table class="table table-sm table-hover">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th>Nama</th>
                            <th>Kota</th>
                            <th>Email</th>
                            <th>No HP</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection
