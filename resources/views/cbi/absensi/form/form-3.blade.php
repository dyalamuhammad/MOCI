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
        var tambahButton = document.getElementById('tambah-kolom');
        var tbody = document.getElementById('tabel-body');
        var thead = document.querySelector('thead tr');
        var names = ['stage[]', 'touch_point[]', 'doing[]', 'expect[]', 'thinking[]', 'pain_point[]'];

        tambahButton.addEventListener('click', function() {
            var rows = tbody.querySelectorAll('tr');
            rows.forEach(function(row, rowIndex) {
                // Buat elemen kolom baru
                var td = document.createElement('td');
                var textarea = document.createElement('textarea');
                textarea.placeholder = 'Isi Disini...';
                textarea.name = names[rowIndex]; // Set nama textarea sesuai urutan
                textarea.className = 'form-control border-0'; // Tambahkan class jika diperlukan
                if (names[rowIndex] === 'pain_point') {
                    td.classList.add('bg-orange'); // Tambahkan class khusus untuk pain_point
                    textarea.classList.add('bg-orange'); // Tambahkan class khusus untuk pain_point
                }
                td.appendChild(textarea);
                row.appendChild(td);
            });

            // Menambahkan judul kolom baru ke dalam baris judul
            var th = document.createElement('th');
            th.classList.add('px-6');
            th.textContent = 'DETAIL'; // Mengambil jumlah kolom saat ini dan menambahkan 1
            thead.appendChild(th);
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
                                <li class="breadcrumb-item"><a href="{{ route('absensiCbi') }}">Absensi CBI</a></li>
                                <li class="breadcrumb-item"><a href="#!">Form Absensi</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <form action="{{ route('addNotulenCbi3') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card card-danger">
                    <div class="card-header bg-green">

                        <h1 class="fs-4 card-title text-white mt-1">Langkah 1 - Empathy<br> <span class="fw-light">Customer
                                Journey</span>
                        </h1>
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
                                    placeholder="Isi judul improvement..." value="{{ $judul }}" readonly>
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
                                <label for="">Customer Journey</label>
                                <div class="d-flex mb-3">
                                    <button type="button" id="tambah-kolom" class="btn btn-outline-success">Tambah
                                        Kolom</button>
                                </div>
                                <div class="table-responsive">
                                    <table class="table rounded-3">
                                        <thead>
                                            <tr>
                                                <th class="table-green-2 col-2">ITEM</th>
                                                <th class="table-secondary">DETAIL</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tabel-body">
                                            <tr>
                                                <td class="table-green-2">Stage</td>
                                                <td>
                                                    <textarea placeholder="Isi Disini..." name="stage[]" class="form-control border-0"></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="table-green-2">Touch Point</td>
                                                <td>
                                                    <textarea placeholder="Isi Disini..." name="touch_point[]" class="form-control border-0"></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="table-green-2">Doing</td>
                                                <td>
                                                    <textarea placeholder="Isi Disini..." name="doing[]" class="form-control border-0"></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="table-green-2">Expect</td>
                                                <td>
                                                    <textarea placeholder="Isi Disini..." name="expect[]" class="form-control border-0"></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-wrap table-green-2">Thinking</td>
                                                <td>
                                                    <textarea placeholder="Isi Disini..." name="thinking[]" class="form-control border-0"></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-wrap bg-orange">Pain Points</td>
                                                <td class="bg-orange">
                                                    <textarea placeholder="Isi Disini..." name="pain_point[]" class="form-control border-0 bg-orange"></textarea>
                                                </td>
                                            </tr>
                                        </tbody>

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
