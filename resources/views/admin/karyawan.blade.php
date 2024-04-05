@extends('layouts/main')
@section('content')
    <div class="pcoded-main-container">
        <!-- [ Main Content ] start -->
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
                                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="bi bi-house"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('karyawan') }}">Data Karyawan</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <div class="row">

                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header bg-darkBlue text-white">
                            <h5 class="text-white">Data Karyawan</h5>
                            <span class="d-block m-t-5">Hallo sahabat Berikut data karyawan</span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table rounded-3">
                                    <tr class="table-primary">
                                        <th>No</th>
                                        <th>Npk</th>
                                        <th>Nama</th>
                                        <th>Dept</th>
                                        <th>Shift</th>
                                        <th>Jabatan</th>
                                        <th>Status</th>
                                        <th class="text-center">Preview</th>
                                    </tr>
                                    @foreach ($users as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->npk }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td class="text-uppercase">{{ $item->section }}</td>
                                            <td>{{ $item->shift }}</td>
                                            <td>{{ $item->jabatan }}</td>
                                            <td>{{ $item->status }}</td>
                                            <td class="text-center"><button class="btn btn-sm btn-green">Detail</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>

                                <div class="pagination justify-content-beetwen">
                                    <ul class="pagination button">
                                        <!-- Tombol Previous tidak ditampilkan -->
                                        <li class="page-item disabled me-2">
                                            <a class="btn btn-outline-primary"
                                                href="{{ $users->previousPageUrl() }}">Previous</a>
                                        </li>

                                        <!-- Tombol Next -->
                                        @if ($users->hasMorePages())
                                            <li class="page-item">
                                                <a class="btn btn-outline-primary" href="{{ $users->nextPageUrl() }}"
                                                    rel="next" aria-label="Next">Next</a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <span class="btn btn-outline-primary disabled" aria-disabled="true"
                                                    aria-label="Next">Next</span>
                                            </li>
                                        @endif
                                    </ul>
                                </div>




                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card-body">
                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">
                                        IMPORT
                                    </button>
                                    <div class="modal fade" id="exampleModal" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Import Karyawan</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">

                                                    <form method="POST" action="{{ route('importUsers') }}"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label for="file">Choose Excel File:</label>
                                                            <input type="file" class="form-control" name="file"
                                                                id="file" accept=".xlsx, .xls" required>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary w-25">IMPORT</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary w-25"
                                        onclick="window.location.href='{{ route('form') }}'">ADD</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endSection
