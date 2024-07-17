@extends('layouts.main')
@section('script')
    <script>
        $('#summernote').summernote({
            placeholder: 'Silahkan Isi Notulen',
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
                    url: '{{ route('addNotulen') }}',
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
                        url: '{{ route('addNotulen') }}',
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Menangani perubahan status checkbox
            document.getElementById('tambah-baris').addEventListener('click', function() {
                event.preventDefault();
                // Dapatkan tabel
                var table = document.querySelector('.table-5w');

                // Buat elemen baris baru
                var newRow = document.createElement('tr');

                // Definisikan konten untuk setiap kolom
                var cellContent = [
                    '<textarea type="text" class="form-control border-0" placeholder="Isi Disini..." name="what[]"></textarea>',
                    '<textarea type="text" class="form-control border-0" placeholder="Isi Disini..." name="how[]"></textarea>',
                    '<textarea type="text" class="form-control border-0" placeholder="Isi Disini..." name="why[]"></textarea>',
                    '<textarea type="text" class="form-control border-0" placeholder="Isi Disini..." name="where[]"></textarea>',
                    '<textarea type="text" class="form-control border-0" placeholder="Isi Disini..." name="who[]"></textarea>',
                    '<textarea type="text" class="form-control border-0" placeholder="Isi Disini..." name="when[]"></textarea>',
                ];

                // Tambahkan sel untuk setiap kolom
                cellContent.forEach(function(content) {
                    var newCell = document.createElement('td');
                    newCell.innerHTML = content;
                    newRow.appendChild(newCell);
                });

                // Tambahkan baris baru ke tabel
                table.appendChild(newRow);
            });
        });
    </script>
@endsection
@section('content')
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            @if (!empty($error))
                <div class="alert alert-danger d-flex justify-content-between">
                    {{ $error }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        @include('alert')
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10"></h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="bi bi-house"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('absensiQcc') }}">Absensi QCC</a></li>
                                <li class="breadcrumb-item"><a href="#!">Form Absensi</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <form action="{{ route('addNotulen7') }}" method="POST" class="" enctype="multipart/form-data">
                @csrf
                <div class="card card-primary">
                    <div class="card-header bg-green d-flex justify-content-between">
                        <h1 class="fs-5 card-title text-white mt-1">Langkah 7 <br> <span
                                class="fw-light fs-4">Standarisasi</span> </h1>
                        <div class="d-flex py-1">
                            <a href="{{ route('formAbsensi6') }}" class="text-white">Langkah 6</a>

                            <p class="fs-6 mx-2 text-white">></p>
                            <a href="{{ route('formAbsensi8') }}" class="text-white">Langkah 8</a>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="row justify-content-end p-3">
                            <div class="col-12 mb-3">
                                <label for="nama">Nama Circle</label>
                                <input type="text" class="form-control" name="name" value="{{ $circleName ?? '' }}"
                                    readonly>
                                <input type="hidden" name="circle_id" value="{{ $circleId }}">
                                <input type="hidden" name="periode_id" value="{{ $periodeId }}">
                            </div>
                            <div class="col-12 mb-3">
                                <label for="nama">Judul Improvement</label>
                                <input type="text" class="form-control" name="judul" value="{{ $judul }}"
                                    readonly>
                            </div>
                            <div class="col-4 mb-3">
                                <label for="nama">Divisi/Departemen</label>
                                <input type="text" class="form-control text-uppercase" name="tema"
                                    value="{{ $deptName }}" readonly>
                            </div>
                            <div class="col-4">
                                <label for="nama">Tema Leader</label>
                                <input type="text" class="form-control" name="tema" value="{{ $leaderName }}"
                                    readonly>
                            </div>
                            <div class="col-4 mb-3">
                                <label for="nama">Fasilitator</label>
                                <input type="text" class="form-control" name="tema" value="{{ $nama_cord }}"
                                    readonly>
                            </div>

                            <div class="col-12">
                                <label for="">Absensi Anggota</label>
                                <table class="table table-bordered rounded-3 border-2">
                                    <tr class="table-primary">
                                        <th>NPK</th>
                                        <th>Nama</th>
                                        <th>Keterangan</th>
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
                            <div class="col-12">
                                <label for="">Standarisasi 5W + 1H</label>
                                <div class="d-flex mb-3">
                                    <button id="tambah-baris" class="btn btn-outline-success">Tambah Baris</button>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-5w">
                                        <tr>
                                            <th class="table-success px-6">What</th>
                                            <th class="table-success px-6">How</th>
                                            <th class="table-success px-6">Why</th>
                                            <th class="table-success px-6">Where</th>
                                            <th class="table-success px-6">Who</th>
                                            <th class="table-success px-6">When</th>
                                        </tr>
                                        <tr>
                                            <td class="">
                                                <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." rows="5" name="what[]"></textarea>
                                            </td>
                                            <td class="">
                                                <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." rows="5" name="how[]"></textarea>
                                            </td>
                                            <td class="">
                                                <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." rows="5" name="why[]"></textarea>
                                            </td>
                                            <td class="">
                                                <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." rows="5" name="where[]"></textarea>
                                            </td>

                                            <td class="">
                                                <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." rows="5" name="who[]"></textarea>
                                            </td>
                                            <td class="">
                                                <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." rows="5" name="when[]"></textarea>
                                            </td>

                                        </tr>

                                    </table>
                                </div>
                            </div>




                            <div class="col-12 text-end">
                                <button class="btn btn-green col-3 mt-5" type="submit">Submit</button>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
