@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-xxl-8 mb-6 order-0">
            <div class="card">
                <div class="d-flex align-items-start row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary mb-3">Selamat datang,
                                {{ auth()->user()->name }}! 🎉</h5>
                            <p class="mb-6">
                                Selamat datang di AMD Store by AMD Academy
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-6">
                            <img src="{{ asset('/') }}img/illustrations/man-with-laptop.png" height="153"
                                class="scaleX-n1-rtl" alt="View Badge User" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @hasanyrole(['admin'])
            <div class="col-lg-4 col-md-4 order-1">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-6 mb-6">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between mb-4">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('/') }}img/icons/unicons/chart-success.png" alt="chart success"
                                            class="rounded" />
                                    </div>
                                </div>
                                <p class="mb-1">Customer</p>
                                <h4 class="card-title mb-3">0</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-6 mb-6">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between mb-4">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('/') }}img/icons/unicons/wallet-info.png" alt="wallet info"
                                            class="rounded" />
                                    </div>
                                </div>
                                <p class="mb-1">Penjualan</p>
                                <h4 class="card-title mb-3">0</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endhasanyrole

    </div>
@endsection
