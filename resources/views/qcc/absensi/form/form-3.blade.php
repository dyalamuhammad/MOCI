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


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#input-machine-1, #input-machine-2, #input-machine-3, #input-machine-4, #input-machine-5').on(
                'input',
                function() {
                    var lastValue = null;

                    // Loop melalui setiap textarea dengan id input-machine
                    for (var i = 5; i >= 1; i--) {
                        var currentValue = $('#input-machine-' + i).val().trim();

                        // Jika textarea tidak kosong, atur nilai sebagai nilai yang diambil
                        if (currentValue !== '') {
                            lastValue = currentValue;
                            break; // Hentikan loop jika nilai ditemukan
                        }
                    }

                    // Jika ada nilai terakhir yang ditemukan, atur nilai textarea output-machine
                    if (lastValue !== null) {
                        $('#output-machine').val(lastValue);
                    }
                });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#input-material-1, #input-material-2, #input-material-3, #input-material-4, #input-material-5').on(
                'input',
                function() {
                    var lastValue = null;

                    // Loop melalui setiap textarea dengan id input-material
                    for (var i = 5; i >= 1; i--) {
                        var currentValue = $('#input-material-' + i).val().trim();

                        // Jika textarea tidak kosong, atur nilai sebagai nilai yang diambil
                        if (currentValue !== '') {
                            lastValue = currentValue;
                            break; // Hentikan loop jika nilai ditemukan
                        }
                    }

                    // Jika ada nilai terakhir yang ditemukan, atur nilai textarea output-material
                    if (lastValue !== null) {
                        $('#output-material').val(lastValue);
                    }
                });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#input-metode-1, #input-metode-2, #input-metode-3, #input-metode-4, #input-metode-5').on(
                'input',
                function() {
                    var lastValue = null;

                    // Loop melalui setiap textarea dengan id input-metode
                    for (var i = 5; i >= 1; i--) {
                        var currentValue = $('#input-metode-' + i).val().trim();

                        // Jika textarea tidak kosong, atur nilai sebagai nilai yang diambil
                        if (currentValue !== '') {
                            lastValue = currentValue;
                            break; // Hentikan loop jika nilai ditemukan
                        }
                    }

                    // Jika ada nilai terakhir yang ditemukan, atur nilai textarea output-metode
                    if (lastValue !== null) {
                        $('#output-metode').val(lastValue);
                    }
                });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#input-environment-1, #input-environment-2, #input-environment-3, #input-environment-4, #input-environment-5')
                .on(
                    'input',
                    function() {
                        var lastValue = null;

                        // Loop melalui setiap textarea dengan id input-environment
                        for (var i = 5; i >= 1; i--) {
                            var currentValue = $('#input-environment-' + i).val().trim();

                            // Jika textarea tidak kosong, atur nilai sebagai nilai yang diambil
                            if (currentValue !== '') {
                                lastValue = currentValue;
                                break; // Hentikan loop jika nilai ditemukan
                            }
                        }

                        // Jika ada nilai terakhir yang ditemukan, atur nilai textarea output-environment
                        if (lastValue !== null) {
                            $('#output-environment').val(lastValue);
                        }
                    });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#input-man-1, #input-man-2, #input-man-3, #input-man-4, #input-man-5').on('input', function() {
                var lastValue = null;

                // Loop melalui setiap textarea dengan id input-man
                for (var i = 5; i >= 1; i--) {
                    var currentValue = $('#input-man-' + i).val().trim();

                    // Jika textarea tidak kosong, atur nilai sebagai nilai yang diambil
                    if (currentValue !== '') {
                        lastValue = currentValue;
                        break; // Hentikan loop jika nilai ditemukan
                    }
                }

                // Jika ada nilai terakhir yang ditemukan, atur nilai textarea output-man
                if (lastValue !== null) {
                    $('#output-man').val(lastValue);
                }
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
            <form action="{{ route('addNotulen3') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card card-primary">
                    <div class="card-header bg-green d-flex justify-content-between">
                        <h1 class="fs-5 card-title text-white mt-1">Langkah 3 <br> <span class="fw-light fs-4">Analisa
                                Masalah</span> </h1>
                        <div class="d-flex py-1">
                            <a href="{{ route('formAbsensi2') }}" class="text-white">Langkah 2</a>

                            <p class="fs-6 mx-2 text-white">></p>
                            <a href="{{ route('formAbsensi4') }}" class="text-white">Langkah 4</a>
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
                            <div class="col-12 mb-3">
                                <label for="">Analisa Penyebab 4M + 1E</label>
                                <div class="d-flex gap-1">
                                    <input type="checkbox" class="btn-check" id="machine" autocomplete="off">
                                    <label class="btn btn-outline-success" for="machine">Machine</label><br>
                                    <input type="checkbox" class="btn-check" id="material" autocomplete="off">
                                    <label class="btn btn-outline-success" for="material">Material</label><br>
                                    <input type="checkbox" class="btn-check" id="metode" autocomplete="off">
                                    <label class="btn btn-outline-success" for="metode">Metode</label><br>
                                    <input type="checkbox" class="btn-check" id="environment" autocomplete="off">
                                    <label class="btn btn-outline-success" for="environment">Environment</label><br>
                                    <input type="checkbox" class="btn-check" id="man" autocomplete="off">
                                    <label class="btn btn-outline-success" for="man">Man</label><br>
                                </div>
                                <div class="overflow-auto">
                                    <table class="table table-bordered border-light rounded-3 border-2">
                                        <tr>
                                            <th class="table-green-2 col-2">Item</th>
                                            <th class="px-6 col-auto table-secondary">WHY 1</th>
                                            <th class="px-6 col-auto table-secondary">WHY 2</th>
                                            <th class="px-6 col-auto table-secondary">WHY 3</th>
                                            <th class="px-6 col-auto table-secondary">WHY 4</th>
                                            <th class="px-6 col-auto table-secondary">WHY 5</th>
                                            <th class="px-6 col-auto table-secondary">Upload Foto</th>
                                        </tr>
                                        <tr class="machine" style="display: none;">
                                            <td class="table-green-2"><input type="hidden"
                                                    class="form-control border-0  text-center" name="category4m1e[]"
                                                    value="MACHINE" readonly />Machine</td>
                                            <td class="">
                                                <textarea id="input-machine-1" type="text" class="form-control border-0" placeholder="Isi Disini..."
                                                    rows="5" name="why1_4m1e[]"></textarea>
                                            </td>
                                            <td class="">
                                                <textarea id="input-machine-2" type="text" class="form-control border-0" placeholder="Isi Disini..."
                                                    rows="5" name="why2_4m1e[]"></textarea>
                                            </td>
                                            <td class="">
                                                <textarea id="input-machine-3" type="text" class="form-control border-0" placeholder="Isi Disini..."
                                                    rows="5" name="why3_4m1e[]"></textarea>
                                            </td>
                                            <td class="">
                                                <textarea id="input-machine-4" type="text" class="form-control border-0" placeholder="Isi Disini..."
                                                    rows="5" name="why4_4m1e[]"></textarea>
                                            </td>
                                            <td class="">
                                                <textarea id="input-machine-5" type="text" class="form-control border-0" placeholder="Isi Disini..5"
                                                    rows="5" name="why5_4m1e[]"></textarea>
                                            </td>
                                            <td class="align-middle">
                                                <input type="file" class="form-control form-control-sm"
                                                    name="foto_4m1e[]">
                                            </td>

                                        </tr>
                                        <tr class="material" style="display: none;">
                                            <td class="table-green-2"><input type="hidden"
                                                    class="form-control border-0 text-center" name="category4m1e[]"
                                                    value="MATERIAL" readonly />Material</td>
                                            <td class="">
                                                <textarea id="input-material-1" type="text" class="form-control border-0" placeholder="Isi Disini..."
                                                    rows="5" name="why1_4m1e[]"></textarea>
                                            </td>
                                            <td class="">
                                                <textarea id="input-material-2" type="text" class="form-control border-0" placeholder="Isi Disini..."
                                                    rows="5" name="why2_4m1e[]"></textarea>
                                            </td>
                                            <td class="">
                                                <textarea id="input-material-3" type="text" class="form-control border-0" placeholder="Isi Disini..."
                                                    rows="5" name="why3_4m1e[]"></textarea>
                                            </td>
                                            <td class="">
                                                <textarea id="input-material-4" type="text" class="form-control border-0" placeholder="Isi Disini..."
                                                    rows="5" name="why4_4m1e[]"></textarea>
                                            </td>
                                            <td class="">
                                                <textarea id="input-material-5" type="text" class="form-control border-0" placeholder="Isi Disini..."
                                                    rows="5" name="why5_4m1e[]"></textarea>
                                            </td>
                                            <td class="align-middle">
                                                <input type="file" class="form-control form-control-sm"
                                                    name="foto_4m1e[]">
                                            </td>
                                        </tr>
                                        <tr class="metode" style="display: none;">
                                            <td class="table-green-2"><input type="hidden"
                                                    class="form-control border-0 text-center" name="category4m1e[]"
                                                    value="METODE" readonly />Metode</td>
                                            <td class="">
                                                <textarea id="input-metode-1" type="text" class="form-control border-0" placeholder="Isi Disini..."
                                                    rows="5" name="why1_4m1e[]"></textarea>
                                            </td>
                                            <td class="">
                                                <textarea id="input-metode-2" type="text" class="form-control border-0" placeholder="Isi Disini..."
                                                    rows="5" name="why2_4m1e[]"></textarea>
                                            </td>
                                            <td class="">
                                                <textarea id="input-metode-3" type="text" class="form-control border-0" placeholder="Isi Disini..."
                                                    rows="5" name="why3_4m1e[]"></textarea>
                                            </td>
                                            <td class="">
                                                <textarea id="input-metode-4" type="text" class="form-control border-0" placeholder="Isi Disini..."
                                                    rows="5" name="why4_4m1e[]"></textarea>
                                            </td>
                                            <td class="">
                                                <textarea id="input-metode-5" type="text" class="form-control border-0" placeholder="Isi Disini..."
                                                    rows="5" name="why5_4m1e[]"></textarea>
                                            </td>
                                            <td class="align-middle">
                                                <input type="file" class="form-control form-control-sm"
                                                    name="foto_4m1e[]">
                                            </td>
                                        </tr>
                                        <tr class="environment" style="display: none;">
                                            <td class="table-green-2"><input type="hidden"
                                                    class="form-control border-0 text-center" name="category4m1e[]"
                                                    value="ENVIRONMENT" readonly />Environment</td>
                                            <td class="">
                                                <textarea id="input-environment-1" type="text" class="form-control border-0" placeholder="Isi Disini..."
                                                    rows="5" name="why1_4m1e[]"></textarea>
                                            </td>
                                            <td class="">
                                                <textarea id="input-environment-2" type="text" class="form-control border-0" placeholder="Isi Disini..."
                                                    rows="5" name="why2_4m1e[]"></textarea>
                                            </td>
                                            <td class="">
                                                <textarea id="input-environment-3" type="text" class="form-control border-0" placeholder="Isi Disini..."
                                                    rows="5" name="why3_4m1e[]"></textarea>
                                            </td>
                                            <td class="">
                                                <textarea id="input-environment-4" type="text" class="form-control border-0" placeholder="Isi Disini..."
                                                    rows="5" name="why4_4m1e[]"></textarea>
                                            </td>
                                            <td class="">
                                                <textarea id="input-environment-5" type="text" class="form-control border-0" placeholder="Isi Disini..."
                                                    rows="5" name="why5_4m1e[]"></textarea>
                                            </td>
                                            <td class="align-middle">
                                                <input type="file" class="form-control form-control-sm"
                                                    name="foto_4m1e[]">
                                            </td>
                                        </tr>
                                        <tr class="man" style="display: none;">
                                            <td class="table-green-2"><input type="hidden"
                                                    class="form-control border-0 text-center" name="category4m1e[]"
                                                    value="MAN" readonly />Man</td>
                                            <td class="">
                                                <textarea id="input-man-1" class="form-control border-0" placeholder="Isi Disini..." rows="5"
                                                    name="why1_4m1e[]"></textarea>
                                            </td>
                                            <td class="">
                                                <textarea id="input-man-2" class="form-control border-0" placeholder="Isi Disini..." rows="5"
                                                    name="why2_4m1e[]"></textarea>
                                            </td>
                                            <td class="">
                                                <textarea id="input-man-3" class="form-control border-0" placeholder="Isi Disini..." rows="5"
                                                    name="why3_4m1e[]"></textarea>
                                            </td>
                                            <td class="">
                                                <textarea id="input-man-4" class="form-control border-0" placeholder="Isi Disini..." rows="5"
                                                    name="why4_4m1e[]"></textarea>
                                            </td>
                                            <td class="">
                                                <textarea id="input-man-5" class="form-control border-0" placeholder="Isi Disini..." rows="5"
                                                    name="why5_4m1e[]"></textarea>
                                            </td>
                                            <td class="align-middle"><input type="file"
                                                    class="form-control form-control-sm" name="foto_4m1e[]"></td>
                                        </tr>


                                    </table>
                                </div>
                            </div>
                            {{-- analisa kondisi --}}
                            <div class="col-12 mb-3">
                                <label for="nama">Uji Penyebab</label>

                                <table class="table table-bordered rounded-3 border-2 table-uji">
                                    <tr>
                                        <th class="table-success">Akar Masalah</th>
                                        <th class="table-success">Standar</th>
                                        <th class="table-success">Metode Validasi</th>
                                        <th class="table-success">Actual</th>
                                        <th class="table-success">Judge</th>
                                    </tr>
                                    <tr class="machine" style="display: none;">
                                        <td class="p-0">
                                            <textarea id="output-machine" type="text" class="form-control border-0 rounded-0" cols="10" rows="5"
                                                name="akar_masalah[]" placeholder="Terisi Otomatis..." placeholder="Terisi Otomatis.." readonly></textarea>
                                        </td>
                                        <td class="p-0">
                                            <textarea type="text" class="form-control border-0" cols="10" rows="5" placeholder="Isi Disini..."
                                                name="standar[]"></textarea>
                                        </td>
                                        <td class="p-0">
                                            <textarea type="text" class="form-control border-0" cols="10" rows="5" placeholder="Isi Disini..."
                                                name="metode_validasi[]"></textarea>
                                        </td>
                                        <td class="p-0">
                                            <textarea type="text" class="form-control border-0" cols="10" rows="5" placeholder="Isi Disini..."
                                                name="actual[]"></textarea>
                                        </td>
                                        <td class="align-middle">
                                            <select class="form-select text-center border-1" style="width: 100%;"
                                                name="judge[]">
                                                <option value="">-- Pilih --</option>
                                                <option value="OK">OK</option>
                                                <option value="NG">NG</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="material" style="display: none;">
                                        <td class="p-0">
                                            <textarea id="output-material" type="text" class="form-control border-0" cols="10" rows="5"
                                                name="akar_masalah[]" placeholder="Terisi Otomatis..." readonly></textarea>
                                        </td>
                                        <td class="">
                                            <textarea type="text" class="form-control border-0" cols="10" rows="5" placeholder="Isi Disini..."
                                                name="standar[]"></textarea>
                                        </td>
                                        <td class="">
                                            <textarea type="text" class="form-control border-0" cols="10" rows="5" placeholder="Isi Disini..."
                                                name="metode_validasi[]"></textarea>
                                        </td>
                                        <td class="">
                                            <textarea type="text" class="form-control border-0" cols="10" rows="5" placeholder="Isi Disini..."
                                                name="actual[]"></textarea>
                                        </td>
                                        <td class="">
                                            <select class="form-select text-center border-1" style="width: 100%;"
                                                name="judge[]">
                                                <option value="">-- Pilih --</option>
                                                <option value="OK">OK</option>
                                                <option value="NG">NG</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="metode" style="display: none;">
                                        <td class="p-0">
                                            <textarea id="output-metode" type="text" class="form-control border-0" cols="10" rows="5"
                                                name="akar_masalah[]" placeholder="Terisi Otomatis..." readonly></textarea>
                                        </td>
                                        <td class="">
                                            <textarea type="text" class="form-control border-0" cols="10" rows="5" placeholder="Isi Disini..."
                                                name="standar[]"></textarea>
                                        </td>
                                        <td class="">
                                            <textarea type="text" class="form-control border-0" cols="10" rows="5" placeholder="Isi Disini..."
                                                name="metode_validasi[]"></textarea>
                                        </td>
                                        <td class="">
                                            <textarea type="text" class="form-control border-0" cols="10" rows="5" placeholder="Isi Disini..."
                                                name="actual[]"></textarea>
                                        </td>
                                        <td class="">
                                            <select class="form-select text-center border-1" style="width: 100%;"
                                                name="judge[]">
                                                <option value="">-- Pilih --</option>
                                                <option value="OK">OK</option>
                                                <option value="NG">NG</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="man" style="display: none;">
                                        <td class="p-0">
                                            <textarea id="output-man" type="text" class="form-control border-0" cols="10" rows="5"
                                                name="akar_masalah[]" placeholder="Terisi Otomatis..." readonly></textarea>
                                        </td>
                                        <td class="">
                                            <textarea type="text" class="form-control border-0" cols="10" rows="5" placeholder="Isi Disini..."
                                                name="standar[]"></textarea>
                                        </td>
                                        <td class="">
                                            <textarea type="text" class="form-control border-0" cols="10" rows="5" placeholder="Isi Disini..."
                                                name="metode_validasi[]"></textarea>
                                        </td>
                                        <td class="">
                                            <textarea type="text" class="form-control border-0" cols="10" rows="5" placeholder="Isi Disini..."
                                                name="actual[]"></textarea>
                                        </td>
                                        <td class="">
                                            <select class="form-select text-center border-1" style="width: 100%;"
                                                name="judge[]">
                                                <option value="">-- Pilih --</option>
                                                <option value="OK">OK</option>
                                                <option value="NG">NG</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="environment" style="display: none;">
                                        <td class="p-0">
                                            <textarea id="output-environment" type="text" class="form-control border-0" cols="10" rows="5"
                                                name="akar_masalah[]" placeholder="Terisi Otomatis..." readonly></textarea>
                                        </td>
                                        <td class="">
                                            <textarea type="text" class="form-control border-0" cols="10" rows="5" placeholder="Isi Disini..."
                                                name="standar[]"></textarea>
                                        </td>
                                        <td class="">
                                            <textarea type="text" class="form-control border-0" cols="10" rows="5" placeholder="Isi Disini..."
                                                name="metode_validasi[]"></textarea>
                                        </td>
                                        <td class="">
                                            <textarea type="text" class="form-control border-0" cols="10" rows="5" placeholder="Isi Disini..."
                                                name="actual[]"></textarea>
                                        </td>
                                        <td class="">
                                            <select class="form-select text-center border-1" style="width: 100%;"
                                                name="judge[]">
                                                <option value="">-- Pilih --</option>
                                                <option value="OK">OK</option>
                                                <option value="NG">NG</option>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            {{-- notulen --}}



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
