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
@endsection
@section('content')
    <div class="pcoded-main-container">
        <div class="pcoded-content">

            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        @include('alert')
                        @if (!empty($error))
                            <div class="alert alert-danger d-flex justify-content-between">
                                {{ $error }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
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
            <form action="{{ route('addNotulen2') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card card-primary">
                    <div class="card-header bg-green d-flex justify-content-between">
                        <h4 class="card-title text-white mt-1">Langkah 2 <br> <span class="fw-light">Menentukan
                                Target</span> </h4>
                        <div class="d-flex py-1">
                            <a href="{{ route('formAbsensi') }}" class="text-white">Langkah 1</a>

                            <p class="fs-6 mx-2 text-white">></p>
                            <a href="{{ route('formAbsensi3') }}" class="text-white">Langkah 3</a>
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
                                <label for="">Target Aspek Mutu</label>
                                <table class="table table-bordered rounded-3 border-2">
                                    <tr>
                                        <th class="table-green-2 col-2">Item</th>
                                        <th class="table-secondary">Detail</th>
                                    </tr>
                                    <tr>
                                        <td class="table-green-2"><input type="hidden"
                                                class="form-control border-0 text-center" name="categoryAspek[]"
                                                value="SAFETY" readonly />Safety</td>
                                        <td class="">
                                            <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." required name="detailAspek[]"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table-green-2"><input type="hidden"
                                                class="form-control border-0 text-center" name="categoryAspek[]"
                                                value="QUALITY" readonly />Quality</td>
                                        <td class="">
                                            <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." required name="detailAspek[]"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table-green-2"><input type="hidden"
                                                class="form-control border-0 text-center" name="categoryAspek[]"
                                                value="COST" readonly />Cost</td>
                                        <td class="">
                                            <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." required name="detailAspek[]"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table-green-2"><input type="hidden"
                                                class="form-control border-0 text-center" name="categoryAspek[]"
                                                value="DELIVERY" readonly />Delivery</td>
                                        <td class="">
                                            <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." required name="detailAspek[]"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table-green-2"><input type="hidden"
                                                class="form-control border-0 text-center" name="categoryAspek[]"
                                                value="PEOPLE" readonly />People</td>
                                        <td class="">
                                            <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." required name="detailAspek[]"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table-green-2"><input type="hidden"
                                                class="form-control border-0 text-center" name="categoryAspek[]"
                                                value="LAIN-LAIN" readonly />Lain - lain</td>
                                        <td class="">
                                            <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." required name="detailAspek[]"></textarea>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            {{-- analisa kondisi --}}
                            <div class="col-12 mb-3">
                                <label for="nama">Dasar Penetapan Target SMART+C</label>
                                <table class="table table-bordered rounded-3 border-2">
                                    <tr>
                                        <th class="table-green-2 col-2">Item</th>
                                        <th class="table-secondary">Detail</th>
                                    </tr>
                                    <tr>
                                        <td class="table-green-2"><input type="hidden"
                                                class="form-control border-0 text-center" name="categorySmart[]"
                                                value="SPECIFIC" readonly />Specific</td>
                                        <td class="">
                                            <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." required name="detailSmart[]"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table-green-2"><input type="hidden"
                                                class="form-control border-0 text-center" name="categorySmart[]"
                                                value="MEASURABLE" readonly />Measurable</td>
                                        <td class="">
                                            <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." required name="detailSmart[]"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table-green-2"><input type="hidden"
                                                class="form-control border-0 text-center" name="categorySmart[]"
                                                value="ACHIEVABLE" readonly />Achievable</td>
                                        <td class="">
                                            <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." required name="detailSmart[]"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table-green-2"><input type="hidden"
                                                class="form-control border-0 text-center" name="categorySmart[]"
                                                value="REASONABLE" readonly />Reasonable</td>
                                        <td class="">
                                            <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." required name="detailSmart[]"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table-green-2"><input type="hidden"
                                                class="form-control border-0 text-center" name="categorySmart[]"
                                                value="TIMEABLE" readonly />Timeable</td>
                                        <td class="">
                                            <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." required name="detailSmart[]"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table-green-2"><input type="hidden"
                                                class="form-control border-0 text-center" name="categorySmart[]"
                                                value="CHALLENGE" readonly />Challenge</td>
                                        <td class="">
                                            <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." required name="detailSmart[]"></textarea>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            {{-- notulen --}}
                            <div class="col-12">
                                <label for="nama">Dampak Positif & Harapan</label>
                                <table class="table table-bordered rounded-3 border-2">
                                    <tr>
                                        <th class="table-green-2 col-2">Item</th>
                                        <th class="table-secondary">Detail</th>
                                    </tr>
                                    <tr>
                                        <td class="table-green-2"><input type="hidden"
                                                class="form-control border-0 text-center" name="categoryDampak[]"
                                                value="PERUSAHAAN" readonly />Perusahaan</td>
                                        <td class="">
                                            <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." required name="detailDampak[]"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table-green-2"><input type="hidden"
                                                class="form-control border-0 text-center" name="categoryDampak[]"
                                                value="KARYAWAN" readonly />Karyawan</td>
                                        <td class="">
                                            <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." required name="detailDampak[]"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table-green-2"><input type="hidden"
                                                class="form-control border-0 text-center" name="categoryDampak[]"
                                                value="SUPPLIER" readonly />Supplier</td>
                                        <td class="">
                                            <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." required name="detailDampak[]"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table-green-2"><input type="hidden"
                                                class="form-control border-0 text-center" name="categoryDampak[]"
                                                value="CUSTOMER" readonly />Customer</td>
                                        <td class="">
                                            <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." required name="detailDampak[]"></textarea>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="table-green-2"><input type="hidden"
                                                class="form-control border-0 text-center" name="categoryDampak[]"
                                                value="PEMERINTAH" readonly />Pemerintah</td>
                                        <td class="">
                                            <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." required name="detailDampak[]"></textarea>
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
