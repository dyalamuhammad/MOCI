@extends('layouts.main')
@section('script')
    <script>
        function confirm() {
            confirm("Apakah data yang anda masukkan sudah benar sahabat?");
        }
    </script>

    <script>
        $('#summernote').summernote({
            placeholder: 'Silahkan Isi Disini...',
            tabsize: 2,
            height: 100
        });
    </script>
    <script>
        $('#summernote-2').summernote({
            placeholder: 'Silahkah analisa kondisi',
            tabsize: 2,
            height: 100
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.btn-check').change(function() {
                if ($(this).prop('checked')) {
                    // Jika tombol diperiksa (active), tampilkan baris tabel yang sesuai
                    var targetRow = '.' + $(this).attr('id')
                        .toLowerCase(); // Gunakan ID tombol untuk menentukan kelas target
                    $(targetRow).show();
                } else {
                    // Jika tombol tidak diperiksa (non-active), sembunyikan baris tabel yang sesuai
                    var targetRow = '.' + $(this).attr('id')
                        .toLowerCase(); // Gunakan ID tombol untuk menentukan kelas target
                    $(targetRow).hide();
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Mengambil CSRF token dari meta tag
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $('.checkbox-toggle').change(function() {
                var memberId = $(this).data('id');
                console.log("Data ID:", memberId);
                var isChecked = 1;
                $.ajax({
                    url: '{{ route('addNotulenDt') }}',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken // Menambahkan CSRF token ke header
                    },
                    data: {
                        memberId: memberId,
                        isChecked: isChecked
                    },
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Menangani perubahan status checkbox
            document.querySelectorAll('.checkbox-toggle').forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    var memberId = this.getAttribute('data-id');
                    console.log(memberId);
                    // var memberId = this.data('id');
                    var isChecked = this.checked ? 1 : 0;

                    // Kirim permintaan Ajax untuk menyimpan perubahan nilai l1
                    $.ajax({
                        url: '{{ route('addNotulenDt') }}',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken // Menambahkan CSRF token ke header
                        },
                        data: {
                            memberId: memberId,
                            isChecked: isChecked
                        },
                        success: function(response) {
                            console.log(response);
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                });
            });
        });
    </script>
@endsection
@section('content')
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            @include('alert')
            @if (!empty($error))
                <div class="alert alert-danger d-flex justify-content-between">
                    {{ $error }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10"></h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="bi bi-house"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('absensiDt') }}">Absensi DT</a></li>
                                <li class="breadcrumb-item"><a href="#!">Form Absensi</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <form action="{{ route('addNotulenDt') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card card-danger">
                    <div class="card-header bg-green d-flex justify-content-between">
                        <h1 class="fs-4 card-title text-white mt-1">Langkah 1 - Empathy<br> <span class="fw-light">Empathy :
                                Background</span>
                        </h1>
                        <div class="d-flex py-1">
                            <p class="fs-6 mx-2 text-white">></p>
                            <a href="{{ route('formAbsensiDt2') }}" class="text-white">Langkah 2</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-end p-3">
                            <div class="col-12 mb-3">
                                <label for="nama">Nama Circle</label>
                                <input type="text" class="form-control" name="circle_name"
                                    value="{{ $circleName ?? '' }}" readonly>
                                <input type="hidden" name="circle_id" value="{{ $circleId }}">
                                <input type="hidden" name="periode_id" value="{{ $periodeId }}">
                            </div>
                            <div class="col-12 mb-3">
                                <label for="nama">Judul Improvement</label>
                                <input type="text" class="form-control" name="judul"
                                    placeholder="Isi judul improvement..." value="" required>
                            </div>
                            <div class="col-4 mb-3">
                                <label for="nama">Divisi/Departemen</label>
                                <input type="text" class="form-control text-uppercase" name="section"
                                    value="{{ $deptName }}" readonly>
                            </div>
                            <div class="col-4">
                                <label for="nama">Tema Leader</label>
                                <input type="text" class="form-control" name="leader" value="{{ $leaderName }}"
                                    readonly>
                            </div>
                            <div class="col-4 mb-3">
                                <label for="nama">Fasilitator</label>
                                <input type="text" class="form-control" name="fasilitator" value="{{ $nama_cord }}"
                                    readonly>
                            </div>

                            <div class="col-12">
                                <label for="">Absensi Anggota</label>
                                <table class="table table-bordered rounded-3 border-2">
                                    <tr class="table-primary">
                                        <th>NPK</th>
                                        <th>Nama</th>
                                        <th>Hadir & Aktif</th>
                                    </tr>
                                    @foreach ($members as $item)
                                        <tr>
                                            <td class="align-middle">{{ $item->npk_anggota }}</td>
                                            <td class="align-middle">
                                                @php
                                                    $user = \App\Models\User::where('npk', $item->npk_anggota)->first();
                                                @endphp
                                                {{ $user->name ?? '' }}
                                            </td>
                                            <td class="text-center col-1 align-middle">
                                                <div class="form-check form-checkbox form-switch-xl">
                                                    <input class="form-check-input checkbox-toggle" type="checkbox"
                                                        id="flexSwitchCheckDefault" value="{{ $item->id }}"
                                                        data-id="{{ $item->id }}" name="memberId[]">
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                </table>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="">Background/Problem</label>
                                <textarea name="background" class="form-control" rows="5" placeholder="Isi Disini..."></textarea>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="">Demografi Customer</label>
                                <textarea name="demo_customer" class="form-control" rows="5" placeholder="Isi Disini..."></textarea>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="">Pemilihan Persona</label>
                                <table class="table table-bordered rounded-3">
                                    <tr>
                                        <th class="table-green-2 col-2">ITEM</th>
                                        <th class="table-secondary">DETAIL</th>
                                    </tr>
                                    <tr>
                                        <td class="table-green-2">Nama</td>
                                        <td>
                                            <textarea placeholder="Isi Disini..." name="nama" class="form-control border-0"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table-green-2">Usia</td>
                                        <td>
                                            <textarea placeholder="Isi Disini..." name="usia" class="form-control border-0"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table-green-2">Asal</td>
                                        <td>
                                            <textarea placeholder="Isi Disini..." name="asal" class="form-control border-0"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table-green-2">Motivasi</td>
                                        <td>
                                            <textarea placeholder="Isi Disini..." name="motivasi" class="form-control border-0"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-wrap table-green-2">Apa Yang Membuat Frustasi</td>
                                        <td>
                                            <textarea placeholder="Isi Disini..." name="apa" class="form-control border-0"></textarea>
                                        </td>
                                    </tr>

                                </table>
                            </div>


                            <div class="col-12 text-end">
                                <button class="btn btn-green col-3 mt-5" type="submit">Submit</button>
                            </div>

                        </div>
                    </div>
            </form>
        </div>
    </div>
@endsection
