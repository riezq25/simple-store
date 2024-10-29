@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-4">{{ $title }}</h5>

            <form class="mb-4" action="{{ route('admin.index') }}" method="get">
                <h6>Filter</h6>
                <div class="row mb-4">
                    <div class="col-sm-12">
                        <div class="mb-3">
                            <input type="text" class="form-control" id="search" name="search"
                                placeholder="Masukkan nama atau email" value='{{ request()->search }}'>
                        </div>
                    </div>
                </div>

                <h6>Sort</h6>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="mb-3">
                            <select id="sort_column" name="sort_column" class="form-select">
                                @foreach ($sortColumns as $i => $column)
                                    <option @selected(request()->sort_column == $i) value="{{ $i }}">{{ $column }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <div class="mb-3">
                            <select id="sort_direction" name="sort_direction" class="form-select">
                                <option @selected(request()->sort_direction == 'asc') value="asc">Ascending</option>
                                <option @selected(request()->sort_direction == 'desc') value="desc">Descending</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-2">
                        <button class="btn btn-primary me-2">
                            <i class="fas fa-search fa-fw me-2"></i>
                            <span>Tampilkan</span>
                        </button>
                    </div>
                </div>

            </form>

            <div class="table-responsive mb-4">
                <table class="table table-sm table-hover">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th>Nama</th>
                            <th>Email</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($users as $i => $user)
                            <tr>
                                <td>{{ ($users->currentPage() - 1) * $users->perPage() + $i + 1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

            {{ $users->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
