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
                                <h5 class="m-b-10">Register Periode</h5>
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
                                action="{{ $forms['id'] ?? null ? route('update-periode', $forms['id']) : route('tambah-baris') }}"
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
                                    <div class="col-sm-6 row mt-5">
                                        <label class="floating-label fw-bold">Registrasi</label>
                                        <div class="form-group col-6">
                                            <label class="floating-label">Mulai</label>
                                            <input type="date" class="form-control" name="langkah[0][mulai]"
                                                value="{{ old('langkah.' . 0 . '.mulai') ?? ($langkah[0]['mulai'] ?? '') }}">
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="floating-label">Sampai</label>
                                            <input type="date" class="form-control" name="langkah[0][sampai]"
                                                value="{{ old('langkah.' . 0 . '.sampai') ?? ($langkah[0]['sampai'] ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 row mt-5">
                                        <label class="floating-label fw-bold" for="password">Langkah 1</label>
                                        <div class="form-group col-6">
                                            <label class="floating-label" for="password">Mulai</label>
                                            <input type="date" class="form-control" name="langkah[1][mulai]"
                                                value="{{ old('langkah.' . 1 . '.mulai') ?? ($langkah[1]['mulai'] ?? '') }}">
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="floating-label" for="password">Sampai</label>
                                            <input type="date" class="form-control" name="langkah[1][sampai]"
                                                value="{{ old('langkah.' . 1 . '.sampai') ?? ($langkah[1]['sampai'] ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 row mt-5">
                                        <label class="floating-label fw-bold" for="password">Langkah 2</label>
                                        <div class="form-group col-6">
                                            <label class="floating-label" for="password">Mulai</label>
                                            <input type="date" class="form-control" name="langkah[2][mulai]"
                                                value="{{ old('langkah.' . 2 . '.mulai') ?? ($langkah[2]['mulai'] ?? '') }}">
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="floating-label" for="password">Sampai</label>
                                            <input type="date" class="form-control" name="langkah[2][sampai]"
                                                value="{{ old('langkah.' . 2 . '.sampai') ?? ($langkah[2]['sampai'] ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 row mt-5">
                                        <label class="floating-label fw-bold" for="password">Langkah 3</label>
                                        <div class="form-group col-6">
                                            <label class="floating-label" for="password">Mulai</label>
                                            <input type="date" class="form-control" name="langkah[3][mulai]"
                                                value="{{ old('langkah.' . 3 . '.mulai') ?? ($langkah[3]['mulai'] ?? '') }}">
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="floating-label" for="password">Sampai</label>
                                            <input type="date" class="form-control" name="langkah[3][sampai]"
                                                value="{{ old('langkah.' . 3 . '.sampai') ?? ($langkah[3]['sampai'] ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 row mt-5">
                                        <label class="floating-label fw-bold" for="password">Langkah 4</label>
                                        <div class="form-group col-6">
                                            <label class="floating-label" for="password">Mulai</label>
                                            <input type="date" class="form-control" name="langkah[4][mulai]"
                                                value="{{ old('langkah.' . 4 . '.mulai') ?? ($langkah[4]['mulai'] ?? '') }}">
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="floating-label" for="password">Sampai</label>
                                            <input type="date" class="form-control" name="langkah[4][sampai]"
                                                value="{{ old('langkah.' . 4 . '.sampai') ?? ($langkah[4]['sampai'] ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 row mt-5">
                                        <label class="floating-label fw-bold" for="password">Langkah 5</label>
                                        <div class="form-group col-6">
                                            <label class="floating-label" for="password">Mulai</label>
                                            <input type="date" class="form-control" name="langkah[5][mulai]"
                                                value="{{ old('langkah.' . 5 . '.mulai') ?? ($langkah[5]['mulai'] ?? '') }}">
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="floating-label" for="password">Sampai</label>
                                            <input type="date" class="form-control" name="langkah[5][sampai]"
                                                value="{{ old('langkah.' . 5 . '.sampai') ?? ($langkah[5]['sampai'] ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 row mt-5">
                                        <label class="floating-label fw-bold" for="password">Langkah 6</label>
                                        <div class="form-group col-6">
                                            <label class="floating-label" for="password">Mulai</label>
                                            <input type="date" class="form-control" name="langkah[6][mulai]"
                                                value="{{ old('langkah.' . 6 . '.mulai') ?? ($langkah[6]['mulai'] ?? '') }}">
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="floating-label" for="password">Sampai</label>
                                            <input type="date" class="form-control" name="langkah[6][sampai]"
                                                value="{{ old('langkah.' . 6 . '.sampai') ?? ($langkah[6]['sampai'] ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 row mt-5">
                                        <label class="floating-label fw-bold" for="password">Langkah 7</label>
                                        <div class="form-group col-6">
                                            <label class="floating-label" for="password">Mulai</label>
                                            <input type="date" class="form-control" name="langkah[7][mulai]"
                                                value="{{ old('langkah.' . 7 . '.mulai') ?? ($langkah[7]['mulai'] ?? '') }}">
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="floating-label" for="password">Sampai</label>
                                            <input type="date" class="form-control" name="langkah[7][sampai]"
                                                value="{{ old('langkah.' . 7 . '.sampai') ?? ($langkah[7]['sampai'] ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 row mt-5">
                                        <label class="floating-label fw-bold" for="password">Langkah 8</label>
                                        <div class="form-group col-6">
                                            <label class="floating-label" for="password">Mulai</label>
                                            <input type="date" class="form-control" name="langkah[8][mulai]"
                                                value="{{ old('langkah.' . 8 . '.mulai') ?? ($langkah[8]['mulai'] ?? '') }}">
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="floating-label" for="password">Sampai</label>
                                            <input type="date" class="form-control" name="langkah[8][sampai]"
                                                value="{{ old('langkah.' . 8 . '.sampai') ?? ($langkah[8]['sampai'] ?? '') }}">
                                        </div>
                                    </div>


                                    <div class="col-sm-6 row mt-5">
                                        <label class="floating-label fw-bold" for="password">NQI</label>
                                        <div class="form-group col-6">
                                            <label class="floating-label" for="password">Mulai</label>
                                            <input type="date" class="form-control" name="langkah[10][mulai]"
                                                value="{{ old('langkah.' . 9 . '.mulai') ?? ($langkah[9]['mulai'] ?? '') }}">
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="floating-label" for="password">Sampai</label>
                                            <input type="date" class="form-control" name="langkah[10][sampai]"
                                                value="{{ old('langkah.' . 9 . '.sampai') ?? ($langkah[9]['sampai'] ?? '') }}">
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
