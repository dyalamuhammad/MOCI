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

        tambahButton.addEventListener('click', function() {
            // Membuat elemen baris baru
            var tr = document.createElement('tr');

            // Menambahkan kolom untuk nama anggota
            var tdNama = document.createElement('td');
            tdNama.textContent = 'Anggota ' + (tbody.childElementCount +
                1); // Menambahkan label "Anggota" dan nomor urut

            // Buat elemen input
            var inputNama = document.createElement('input');
            inputNama.type = 'hidden';
            inputNama.classList.add('form-control', 'border-0', 'text-center');
            inputNama.name = 'anggota[]';
            inputNama.value = 'anggota ' + (tbody.childElementCount +
                1); // Mengambil jumlah baris saat ini dan menambahkan 1
            inputNama.readOnly = true;

            // Masukkan input ke dalam tdNama
            tdNama.appendChild(inputNama);

            // Masukkan tdNama ke dalam tr
            tr.appendChild(tdNama);


            // Menambahkan kolom untuk ide
            for (var i = 0; i < 3; i++) {
                var tdIde = document.createElement('td');
                var textareaIde = document.createElement('textarea');
                textareaIde.type = 'text';
                textareaIde.classList.add('form-control', 'border-0');
                textareaIde.placeholder = 'Isi Disini...';
                textareaIde.rows = '5';
                textareaIde.name = 'ide_' + (i + 1) + '[]'; // Menambahkan nomor urut pada nama input
                tdIde.appendChild(textareaIde);
                tr.appendChild(tdIde);
            }

            // Menambahkan baris ke dalam tabel
            tbody.appendChild(tr);
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
            <form action="{{ route('addNotulenDt5') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card card-danger">
                    <div class="card-header bg-green d-flex justify-content-between">
                        <h1 class="fs-4 card-title text-white mt-1">Langkah 3<br> <span class="fw-light">Ideate</span>
                        </h1>
                        <div class="d-flex py-1">
                            <a href="{{ route('formAbsensiDt4') }}" class="text-white">Langkah 4</a>
                            <p class="fs-6 mx-2 text-white">></p>
                            <a href="{{ route('formAbsensiDt6') }}" class="text-white">Langkah 6</a>
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
                                    placeholder="Isi judul improvement..." value="{{ $judul ?? '' }}" readonly required>
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
                                <label for="">Brainstorming IDE</label>
                                <div class="d-flex mb-3">
                                    <button type="button" id="tambah-kolom" class="btn btn-outline-success">Tambah
                                        Anggota</button>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered border-light rounded-3 border-2">
                                        <tr class="table-success">
                                            <th class="col-1"></th>
                                            <th class="">IDE 1</th>
                                            <th class="">IDE 2</th>
                                            <th class="">IDE 3</th>
                                        </tr>
                                        <tbody id="tabel-body">
                                            <tr>
                                                <td class="">
                                                    <input type="hidden" class="form-control border-0 text-center"
                                                        name="anggota[]" value="anggota 1" readonly />
                                                    Anggota 1
                                                </td>
                                                <td class="">
                                                    <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." rows="5" name="ide_1[]"></textarea>
                                                </td>
                                                <td class="">
                                                    <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." rows="5" name="ide_2[]"></textarea>
                                                </td>
                                                <td class="">
                                                    <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." rows="5" name="ide_3[]"></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=""><input type="hidden"
                                                        class="form-control border-0 text-center" name="anggota[]"
                                                        value="anggota 2" readonly />
                                                    Anggota 2
                                                </td>
                                                <td class="">
                                                    <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." rows="5" name="ide_1[]"></textarea>
                                                </td>
                                                <td class="">
                                                    <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." rows="5" name="ide_2[]"></textarea>
                                                </td>
                                                <td class="">
                                                    <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." rows="5" name="ide_3[]"></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=""><input type="hidden"
                                                        class="form-control border-0 text-center" name="anggota[]"
                                                        value="anggota 3" readonly />
                                                    Anggota 3
                                                </td>
                                                <td class="">
                                                    <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." rows="5" name="ide_1[]"></textarea>
                                                </td>
                                                <td class="">
                                                    <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." rows="5" name="ide_2[]"></textarea>
                                                </td>
                                                <td class="">
                                                    <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." rows="5" name="ide_3[]"></textarea>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="">Rank Ide</label>
                                <table class="table rounded-3">
                                    <tr class="">
                                        <td class="table-success">
                                            RANK 1
                                        </td>
                                        <td class="">
                                            <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." rows="5" name="rank_1"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table-success">
                                            RANK 2
                                        </td>
                                        <td class="">
                                            <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." rows="5" name="rank_2"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table-success">
                                            RANK 3
                                        </td>
                                        <td class="">
                                            <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." rows="5" name="rank_3"></textarea>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="nama">Ide Terpilih</label>
                                <textarea type="text" class="form-control" placeholder="Isi Disini..." name="ide_terpilih" required></textarea>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="">Validasi Ide</label>
                                <div class="table-responsive">
                                    <table class="table rounded-3 border-2">
                                        <tr>
                                            <td class="table-success">
                                                DESIRABILTY
                                            </td>
                                            <td class="">
                                                <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." rows="5"
                                                    name="desirability"></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="table-success">
                                                VIABILITY
                                            </td>
                                            <td class="">
                                                <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." rows="5" name="viability"></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="table-success">
                                                FEASIBILITY
                                            </td>
                                            <td class="">
                                                <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." rows="5"
                                                    name="feasebility"></textarea>
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
