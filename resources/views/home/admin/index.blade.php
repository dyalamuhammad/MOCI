@extends('layouts.admin')
@section('content')
    <main id="main" class="main">
        @include('alert')
        <div class="pagetitle">
            <h1>Admin Dashboard</h1>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="bg-white row rounded-3">
                        <div class="col-6">
                            <h5 class="card-title">FY ADM</h5>
                            <!-- General Form Elements -->
                            <form action="{{ route('uploadAdmin') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row mb-3">
                                    <img src="{{ asset($fy_adm['foto'] ?? null) }}" alt="" class="w-50 mx-auto">
                                </div>
                                <div class="row mb-3">
                                    <label for="inputNumber" class="col-12 mb-2">Upload File Gambar</label>
                                    <div class="col-12 mb-3">
                                        <input class="form-control" type="file" name="fy_adm">
                                    </div>
                                </div>
                        </div>
                        <div class="col-6">
                            <h5 class="card-title">FY BODY</h5>
                            <!-- General Form Elements -->
                            <div class="row mb-3">
                                <img src="{{ asset($fy_body['foto'] ?? null) }}" alt="" class="w-50 mx-auto">
                            </div>
                            <div class="row mb-3">
                                <label for="inputNumber" class="col-12 mb-2">Upload File Gambar</label>
                                <div class="col-12 mb-3">
                                    <input class="form-control" type="file" name="fy_body">

                                </div>

                            </div>
                            <!-- End General Form Elements -->
                        </div>
                        <div class="col-6">
                            <h5 class="card-title">BODY MAPS</h5>
                            <div class="row mb-3">
                                <img src="{{ asset($body_maps['foto'] ?? null) }}" alt="" class="w-50 mx-auto">
                            </div>
                            <div class="row mb-3">
                                <label for="inputNumber" class="col-12 mb-2">Upload File Gambar</label>
                                <div class="col-12 mb-3">
                                    <input class="form-control" type="file" name="body_maps">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <h5 class="card-title">STRUCTURE BODY</h5>
                            <div class="row mb-3">
                                <img src="{{ asset($structure['foto'] ?? null) }}" alt="" class="w-50 mx-auto">
                            </div>
                            <div class="row mb-3">
                                <label for="inputNumber" class="col-12 mb-2">Upload File Gambar</label>
                                <div class="col-12 mb-3">
                                    <input class="form-control" type="file" name="structure">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mb-3">
                            <button type="submit" class="btn btn-purple col-2 mt-1"
                                onclick="this.form.submit(); this.disabled=true; this.value='Sending…';">Save</button>
                        </div>

                        </form>
                    </div>
                </div>
            </div>
        </section>

    </main><!-- End #main -->
@endsection
