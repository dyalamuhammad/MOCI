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
            <form action="{{ route('addNotulen8') }}" method="POST" class="" enctype="multipart/form-data">
                @csrf
                <div class="card card-danger">
                    <div class="card-header bg-green d-flex justify-content-between">
                        <h1 class="fs-4 card-title text-white mt-1">Langkah 8 <br> <span class="fw-light">Rencana
                                Berikut</span> </h1>
                        <div class="d-flex py-1">
                            <a href="{{ route('formAbsensi7') }}" class="text-white">Langkah 7</a>

                            <p class="fs-6 mx-2 text-white">></p>
                            <a href="{{ route('formAbsensi9') }}" class="text-white">NQI</a>
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
                                <label for="">Background/Problem</label>
                                <div class="d-flex gap-1">
                                    <input type="checkbox" class="btn-check" id="icare" autocomplete="off">
                                    <label class="btn btn-outline-success" for="icare">ICARE</label><br>
                                    <input type="checkbox" class="btn-check" id="safety" autocomplete="off">
                                    <label class="btn btn-outline-success" for="safety">SAFETY</label><br>
                                    <input type="checkbox" class="btn-check" id="limas" autocomplete="off">
                                    <label class="btn btn-outline-success" for="limas">5S</label><br>
                                    <input type="checkbox" class="btn-check" id="infrastructure" autocomplete="off">
                                    <label class="btn btn-outline-success" for="infrastructure">INFRASTRUCTURE</label><br>
                                    <input type="checkbox" class="btn-check" id="product" autocomplete="off">
                                    <label class="btn btn-outline-success" for="product">PRODUCT</label><br>
                                    <input type="checkbox" class="btn-check" id="process" autocomplete="off">
                                    <label class="btn btn-outline-success" for="process">PROCESS</label><br>
                                    <input type="checkbox" class="btn-check" id="people" autocomplete="off">
                                    <label class="btn btn-outline-success" for="people">PEOPLE</label><br>
                                </div>
                                <table class="table table-bordered border-light rounded-3 border-2">
                                    <tr>
                                        <th class="table-green-2 col-1 col-md-3 text-truncate">Key Performance Indicator
                                            (KPI)</th>
                                        <th class="table-green-2 col-2 col-md-2">Sub Item</th>
                                        <th class="col-3 col-md-2 table-secondary">Target</th>
                                        <th class="col-3 col-md-2 table-secondary">Actual</th>
                                        <th class="col-3 col-md-2 table-secondary">Judge</th>
                                    </tr>
                                    <tr class="icare" style="display: none;">
                                        <td class="table-green-2"><input type="hidden"
                                                class="form-control border-0 text-center" name="category[]"
                                                value="ICARE" readonly />ICARE</td>
                                        <td class="table-green-2">Icare Index</td>
                                        <td><input type="number" class="form-control border-0 text-center"
                                                placeholder="Isi disini..." name="target[]" /></td>
                                        <td><input type="number" class="form-control border-0 text-center"
                                                placeholder="Isi disini..." name="actual[]" /></td>
                                        <td>
                                            {{-- <input type="number" class="form-control border-0 text-center" placeholder="Isi disini..." name="judge[]"/> --}}
                                            <select class="form-select border-0 text-center" style="width: 100%;"
                                                name="judge[]">
                                                <option value="">-- Pilih --</option>
                                                <option value="OK">OK</option>
                                                <option value="NG">NG</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="safety" style="display: none;">
                                        <td class="table-green-2"><input type="hidden"
                                                class="form-control border-0 text-center" name="category[]"
                                                value="SAFETY" readonly />SAFETY</td>
                                        <td class="table-green-2">Zero accident & Incident</td>
                                        <td><input type="number" class="form-control border-0 text-center"
                                                placeholder="Isi disini..." name="target[]" /></td>
                                        <td><input type="number" class="form-control border-0 text-center"
                                                placeholder="Isi disini..." name="actual[]" /></td>
                                        <td>
                                            <select class="form-select border-0 text-center" style="width: 100%;"
                                                name="judge[]">
                                                <option value="">-- Pilih --</option>
                                                <option value="OK">OK</option>
                                                <option value="NG">NG</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="limas" style="display: none;">
                                        <td class="table-green-2"><input type="hidden"
                                                class="form-control border-0 text-center" name="category[]"
                                                value="5S" readonly />5S</td>
                                        <td class="table-green-2">Grade A</td>
                                        <td><input type="number" class="form-control border-0 text-center"
                                                placeholder="Isi disini..." name="target[]" /></td>
                                        <td><input type="number" class="form-control border-0 text-center"
                                                placeholder="Isi disini..." name="actual[]" /></td>
                                        <td>
                                            <select class="form-select border-0 text-center" style="width: 100%;"
                                                name="judge[]">
                                                <option value="">-- Pilih --</option>
                                                <option value="OK">OK</option>
                                                <option value="NG">NG</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="infrastructure" style="display: none;">
                                        <td class="table-green-2"><input type="hidden"
                                                class="form-control border-0 text-center" name="category[]"
                                                value="INFRASTRUCTURE" readonly />INFRASTRUCTURE</td>
                                        <td class="table-green-2">Energy Reduction</td>
                                        <td><input type="number" class="form-control border-0 text-center"
                                                placeholder="Isi disini..." name="target[]" /></td>
                                        <td><input type="number" class="form-control border-0 text-center"
                                                placeholder="Isi disini..." name="actual[]" /></td>
                                        <td>
                                            <select class="form-select border-0 text-center" style="width: 100%;"
                                                name="judge[]">
                                                <option value="">-- Pilih --</option>
                                                <option value="OK">OK</option>
                                                <option value="NG">NG</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="product" style="display: none;">
                                        <td class="table-green-2"><input type="hidden"
                                                class="form-control border-0 text-center" name="category[]"
                                                value="PRODUCT-QUALITY" readonly />PRODUCT-QUALITY</td>
                                        <td class="table-green-2">DPU</td>
                                        <td><input type="number" class="form-control border-0 text-center"
                                                placeholder="Isi disini..." name="target[]" /></td>
                                        <td><input type="number" class="form-control border-0 text-center"
                                                placeholder="Isi disini..." name="actual[]" /></td>
                                        <td>
                                            <select class="form-select border-0 text-center" style="width: 100%;"
                                                name="judge[]">
                                                <option value="">-- Pilih --</option>
                                                <option value="OK">OK</option>
                                                <option value="NG">NG</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="product" style="display: none;">
                                        <td class="table-green-2"><input type="hidden"
                                                class="form-control border-0 text-center" name="category[]"
                                                value="PRODUCT-COST" readonly />PRODUCT-COST</td>
                                        <td class="table-green-2">Labor Cost</td>
                                        <td><input type="number" class="form-control border-0 text-center"
                                                placeholder="Isi disini..." name="target[]" /></td>
                                        <td><input type="number" class="form-control border-0 text-center"
                                                placeholder="Isi disini..." name="actual[]" /></td>
                                        <td>
                                            <select class="form-select border-0 text-center" style="width: 100%;"
                                                name="judge[]">
                                                <option value="">-- Pilih --</option>
                                                <option value="OK">OK</option>
                                                <option value="NG">NG</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="process" style="display: none;">
                                        <td class="table-green-2"><input type="hidden"
                                                class="form-control border-0 text-center" name="category[]"
                                                value="PROCESS" readonly />PROCESS</td>
                                        <td class="table-green-2">Efficiency Production</td>
                                        <td><input type="number" class="form-control border-0 text-center"
                                                placeholder="Isi disini..." name="target[]" /></td>
                                        <td><input type="number" class="form-control border-0 text-center"
                                                placeholder="Isi disini..." name="actual[]" /></td>
                                        <td>
                                            <select class="form-select border-0 text-center" style="width: 100%;"
                                                name="judge[]">
                                                <option value="">-- Pilih --</option>
                                                <option value="OK">OK</option>
                                                <option value="NG">NG</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="people" style="display: none;">
                                        <td class="table-green-2"><input type="hidden"
                                                class="form-control border-0 text-center" name="category[]"
                                                value="PEOPLE" readonly />PEOPLE</td>
                                        <td class="table-green-2">People Development Implemented</td>
                                        <td><input type="number" class="form-control border-0 text-center"
                                                placeholder="Isi disini..." name="target[]" /></td>
                                        <td><input type="number" class="form-control border-0 text-center"
                                                placeholder="Isi disini..." name="actual[]" /></td>
                                        <td>
                                            <select class="form-select border-0 text-center" style="width: 100%;"
                                                name="judge[]">
                                                <option value="">-- Pilih --</option>
                                                <option value="OK">OK</option>
                                                <option value="NG">NG</option>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
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
