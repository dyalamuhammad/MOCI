@extends('layouts/main')

@section('content')
    <!-- [ Main Content ] start -->
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            @include('alert')
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">Dashboard Analytics</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/"><i class="bi bi-house"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('controlPeriod') }}">Register Periode</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header bg-darkBlue text-white">
                            <h5 class="text-white">Registrasi Periode QCC</h5>
                            <span class="d-block">Halo sahabat admin, silahkan registrasi periode</span>
                        </div>
                        <div class="card-body">
                            <form method="POST" id="tambah-baris-form"
                                action="{{ $forms['id'] ?? null ? route('ubah-periode', $forms['id']) : route('tambah-baris') }}"
                                class="form-horizontal" enctype="multipart/form-data">
                                @csrf
                                @method($forms['id'] ?? null ? 'put' : 'post')
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class="floating-label" for="number">Periode</label>
                                            <input type="number" class="form-control" id="periode" name="periode"
                                                value="{{ old('periode') ?? ($forms['periode'] ?? '') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class="floating-label" for="Text">Tema Konvensi</label>
                                            <input type="text" class="form-control" id ="tema" name="tema"
                                                value="{{ old('tema') ?? ($forms['tema'] ?? '') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class="floating-label" for="password">Mulai</label>
                                            <input type="date" class="form-control" id="tanggal_mulai"
                                                value="{{ old('tanggal_mulai') ?? ($forms['tanggal_mulai'] ?? '') }}"
                                                name="tanggal_mulai" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class="floating-label" for="password">Sampai</label>
                                            <input type="date" class="form-control" id="tanggal_akhir"
                                                value="{{ old('tanggal_akhir') ?? ($forms['tanggal_akhir'] ?? '') }}"
                                                name="tanggal_akhir" required>
                                        </div>
                                    </div>

                                    @for ($i = 1; $i <= 8; $i++)
                                        <div class="col-sm-6 row">
                                            <label class="floating-label fw-bold" for="password">Langkah
                                                {{ $i }}</label>
                                            <div class="form-group col-6">
                                                <label class="floating-label" for="password">Mulai</label>
                                                <input type="date" class="form-control"
                                                    value="{{ old('mulai') ?? ($langkah['mulai'] ?? '') }}"
                                                    name="langkah[{{ $i - 1 }}][mulai]">
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="floating-label" for="password">Sampai</label>
                                                <input type="date" class="form-control"
                                                    value="{{ old('sampai') ?? ($langkah['sampai'] ?? '') }}"
                                                    name="langkah[{{ $i - 1 }}][sampai]">
                                            </div>
                                        </div>
                                    @endfor
                                    <div class="col-sm-6 row">
                                        <label class="floating-label fw-bold" for="password">NQI</label>
                                        <div class="form-group col-6">
                                            <label class="floating-label" for="password">Mulai</label>
                                            <input type="date" class="form-control" name="langkah[9][mulai]">
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="floating-label" for="password">Sampai</label>
                                            <input type="date" class="form-control" name="langkah[9][sampai]">
                                        </div>
                                    </div>



                                </div>

                                <div class="row">
                                    <div class="col-lg-12 text-center">
                                        <span class="box pull-center">
                                            <button type="submit" class="btn btn-primary col-2"
                                                id="tambah-baris-btn">Save</button>
                                        </span>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endsection
