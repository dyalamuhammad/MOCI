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
        var tambahButton1 = document.getElementById('tambah-kolom-1');
        var tbody1 = document.getElementById('tabel-body-1');
        var thead1 = document.getElementById('tabel-head-1');

        tambahButton1.addEventListener('click', function() {
            tambahBaris(tbody1, 'before');
        });

        var tambahButton2 = document.getElementById('tambah-kolom-2');
        var tbody2 = document.getElementById('tabel-body-2');
        var thead2 = document.getElementById('tabel-head-2');

        tambahButton2.addEventListener('click', function() {
            tambahBaris(tbody2, 'after');
        });

        var fileInputCounter = 10;

        function tambahBaris(tbody, nameType) {
            // Membuat elemen baris baru
            var tr = document.createElement('tr');

            // Menambahkan kolom untuk nama anggota
            var tdNama = document.createElement('td');
            tdNama.textContent = 'Step ' + (tbody.childElementCount + 1); // Menambahkan label "Anggota" dan nomor urut

            // Buat elemen input
            var inputNama = document.createElement('input');
            inputNama.type = 'hidden';
            inputNama.classList.add('form-control', 'border-0');
            if (nameType === 'before') {
                inputNama.name = 'step_before[]';
            } else if (nameType === 'after') {
                inputNama.name = 'step_after[]';
            }
            inputNama.value = 'step ' + (tbody.childElementCount + 1); // Mengambil jumlah baris saat ini dan menambahkan 1
            inputNama.readOnly = true;

            // Masukkan input ke dalam tdNama
            tdNama.appendChild(inputNama);

            // Masukkan tdNama ke dalam tr
            tr.appendChild(tdNama);

            // Menambahkan kolom untuk ide
            var tdIde = document.createElement('td');
            var textareaIde = document.createElement('textarea');
            textareaIde.type = 'text';
            textareaIde.classList.add('form-control', 'border-0');
            textareaIde.placeholder = 'Isi Disini...';
            textareaIde.rows = '5';
            if (nameType === 'before') {
                textareaIde.name = 'detail_before[]';
            } else if (nameType === 'after') {
                textareaIde.name = 'detail_after[]';
            }
            tdIde.appendChild(textareaIde);
            tr.appendChild(tdIde);

            // Inisialisasi counter untuk ID input file

            // Menambahkan kolom untuk upload foto
            var tdFoto = document.createElement('td');

            var viewFoto = document.createElement('img');
            viewFoto.id = 'previewImage' + fileInputCounter;
            viewFoto.classList.add('w-100');
            viewFoto.setAttribute('src', '');
            viewFoto.setAttribute('style', 'display:none;');

            var labelFoto = document.createElement('label');
            tdFoto.classList.add('text-center');
            labelFoto.classList.add('btn', 'btn-light');
            labelFoto.setAttribute('for', 'input-file' + fileInputCounter);
            labelFoto.textContent = 'Choose File';

            var inputFoto = document.createElement('input');
            inputFoto.type = 'file';
            inputFoto.classList.add('form-control', 'border-0', 'd-none');
            inputFoto.name = 'foto_before[]';
            inputFoto.id = 'input-file' + fileInputCounter;
            inputFoto.setAttribute('onchange', "previewFile(this, 'previewImage" + fileInputCounter + "')");
            // Meningkatkan counter
            fileInputCounter++;

            tdFoto.appendChild(viewFoto);
            tdFoto.appendChild(inputFoto);
            tdFoto.appendChild(labelFoto);
            tr.appendChild(tdFoto);

            // Menambahkan baris ke dalam tabel
            tbody.appendChild(tr);

        }
    </script>
    <script>
        function previewFile(input, previewId) {
            const preview = document.getElementById(previewId);
            const file = input.files[0];
            const reader = new FileReader();

            reader.onloadend = function() {
                preview.src = reader.result;
                preview.style.display = 'block';
            };

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = '';
                preview.style.display = 'none';
            }
        }
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
            <form action="{{ route('addNotulenDt7') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card card-danger">
                    <div class="card-header bg-green d-flex justify-content-between">
                        <h1 class="fs-4 card-title text-white mt-1">Langkah 5<br> <span class="fw-light">5A. Testing</span>
                        </h1>
                        <div class="d-flex py-1">
                            <a href="{{ route('formAbsensiDt6') }}" class="text-white">Langkah 6</a>
                            <p class="fs-6 mx-2 text-white">></p>
                            <a href="{{ route('formAbsensiDt8') }}" class="text-white">Langkah 8</a>
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
                                <label for="">Customer Feedback</label>
                                <table class="table table-bordered border-light rounded-3 border-2">
                                    <tr>
                                        <th class="table-success col-1">Item</th>
                                        <th class="table-success">Detail</th>
                                    </tr>
                                    <tr>
                                        <td>Hal Yang Disukai</td>
                                        <td class="">
                                            <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." rows="2" name="suka"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Hal Yang Dapat Ditingkatkan</td>
                                        <td class="">
                                            <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." rows="2" name="tingkatkan"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Hal Yang Tidak Dimengerti</td>
                                        <td class="">
                                            <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." rows="2"
                                                name="tidak_mengerti"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Ide Baru Yang Dapat Dipertimbangkan</td>
                                        <td class="">
                                            <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." rows="2"
                                                name="pertimbangkan"></textarea>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="">Learning Card</label>

                                <div class="mb-3">
                                    <label for="">Nama Improvement</label>
                                    <textarea type="text" class="form-control" placeholder="Isi Disini..." rows="2" name="nama_improve"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="">Nama Persona</label>
                                    <textarea type="text" class="form-control" placeholder="Isi Disini..." rows="2" name="nama_persona"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="">Tanggal Uji</label>
                                    <textarea type="text" class="form-control" placeholder="Isi Disini..." rows="2" name="tanggal_uji"></textarea>
                                </div>
                                <table class="table table-bordered border-light rounded-3 border-2">
                                    <tr>
                                        <th class="table-success col-1">Item</th>
                                        <th class="table-success">Detail</th>
                                    </tr>
                                    <tr>
                                        <td>Hypotesis</td>
                                        <td class="">
                                            <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." rows="2" name="hypotesis"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Observation</td>
                                        <td class="">
                                            <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." rows="2"
                                                name="observation"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Learning & Insights</td>
                                        <td class="">
                                            <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." rows="2" name="learning"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Decisions & Actions</td>
                                        <td class="">
                                            <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." rows="2" name="decision"></textarea>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="nama">Iterasi (Tidak Wajib)</label>
                                <div class="d-flex">
                                    <input type="checkbox" class="btn-check" id="iterasi" autocomplete="off">
                                    <label class="btn btn-outline-success" for="iterasi">KLIK UNTUK MENAMPILKAN
                                        FORM</label><br>
                                </div>
                                <div class="iterasi" style="display: none;">
                                    <label for="">Story Before</label>
                                    <div class="d-flex mb-3">
                                        <button type="button" id="tambah-kolom-1" class="btn btn-outline-success">Tambah
                                            Step</button>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered border-light rounded-3 border-2">
                                            <thead>
                                                <tr id="tabel-head-1">
                                                    <th class="bg-green text-light col-1">Step</th>
                                                    <th class="bg-green text-light">Detail</th>
                                                    <th class="bg-green text-light col-2">Upload Foto</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tabel-body-1">
                                                <tr>
                                                    <td class="">
                                                        <input type="hidden" class="form-control border-0 text-center"
                                                            name="step_before[]" value="step 1" readonly />
                                                        Step 1
                                                    </td>
                                                    <td class="">
                                                        <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." rows="5"
                                                            name="detail_before[]"></textarea>
                                                    </td>
                                                    <td class="text-center">
                                                        <img id="previewImage1" src="" alt=""
                                                            style="display: none;" class="w-100">

                                                        <label for="input-file1" class="btn btn-light">Choose File</label>
                                                        <input type="file" class="form-control d-none"
                                                            name="foto_before[]" id="input-file1"
                                                            onchange="previewFile(this, 'previewImage1')">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class=""><input type="hidden"
                                                            class="form-control border-0 text-center" name="step_before[]"
                                                            value="step 2" readonly />
                                                        Step 2
                                                    </td>
                                                    <td class="">
                                                        <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." rows="5"
                                                            name="detail_before[]"></textarea>
                                                    </td>
                                                    <td class="text-center">
                                                        <img id="previewImage2" src="" alt=""
                                                            style="display: none;" class="w-100">
                                                        <label for="input-file-2" class="btn btn-light">Choose
                                                            File</label>
                                                        <input type="file" class="form-control d-none"
                                                            name="foto_before[]" id="input-file-2"
                                                            onchange="previewFile(this, 'previewImage2')">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class=""><input type="hidden"
                                                            class="form-control border-0 text-center" name="step_before[]"
                                                            value="step 3" readonly />
                                                        Step 3
                                                    </td>
                                                    <td class="">
                                                        <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." rows="5"
                                                            name="detail_before[]"></textarea>
                                                    </td>
                                                    <td class="text-center">
                                                        <img id="previewImage3" src="" alt=""
                                                            style="display: none;" class="w-100">
                                                        <label for="input-file-3" class="btn btn-light">Choose
                                                            File</label>
                                                        <input type="file" class="form-control d-none"
                                                            name="foto_before[]" id="input-file-3"
                                                            onchange="previewFile(this, 'previewImage3')">
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                    <label for="nama">Upload Sketsa</label>
                                    <input type="file" class="form-control mb-3" name="foto_sketsa">
                                    <label for="nama">Upload Design 3D</label>
                                    <input type="file" class="form-control mb-3" name="foto_3d">
                                    <label for="">Story After</label>
                                    <div class="d-flex mb-3">
                                        <button type="button" id="tambah-kolom-2" class="btn btn-outline-success">Tambah
                                            Step</button>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered border-light rounded-3 border-2">
                                            <thead>
                                                <tr id="tabel-head-2">
                                                    <th class="bg-green text-light col-1">Step</th>
                                                    <th class="bg-green text-light">Detail</th>
                                                    <th class="bg-green text-light col-2">Upload Foto</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tabel-body-2">
                                                <tr>
                                                    <td class="">
                                                        <input type="hidden" class="form-control border-0 text-center"
                                                            name="step_after[]" value="step 1" readonly />
                                                        Step 1
                                                    </td>
                                                    <td class="">
                                                        <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." rows="5"
                                                            name="detail_after[]"></textarea>
                                                    </td>
                                                    <td class="text-center">
                                                        <img id="previewImage4" src="" alt=""
                                                            style="display: none;" class="w-100">
                                                        <label for="input-file-4" class="btn btn-light">Choose
                                                            File</label>
                                                        <input type="file" class="form-control d-none"
                                                            name="foto_after[]" id="input-file-4"
                                                            onchange="previewFile(this, 'previewImage4')">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class=""><input type="hidden"
                                                            class="form-control border-0 text-center" name="step_after[]"
                                                            value="step 2" readonly />
                                                        Step 2
                                                    </td>
                                                    <td class="">
                                                        <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." rows="5"
                                                            name="detail_after[]"></textarea>
                                                    </td>
                                                    <td class="text-center">
                                                        <img id="previewImage5" src="" alt=""
                                                            style="display: none;" class="w-100">
                                                        <label for="input-file-5" class="btn btn-light">Choose
                                                            File</label>
                                                        <input type="file" class="form-control d-none"
                                                            name="foto_after[]" id="input-file-5"
                                                            onchange="previewFile(this, 'previewImage5')">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class=""><input type="hidden"
                                                            class="form-control border-0 text-center" name="step_after[]"
                                                            value="step 3" readonly />
                                                        Step 3
                                                    </td>
                                                    <td class="">
                                                        <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." rows="5"
                                                            name="detail_after[]"></textarea>
                                                    </td>
                                                    <td class="text-center">
                                                        <img id="previewImage6" src="" alt=""
                                                            style="display: none;" class="w-100">
                                                        <label for="input-file-6" class="btn btn-light">Choose
                                                            File</label>
                                                        <input type="file" class="form-control d-none"
                                                            name="foto_after[]" id="input-file-6"
                                                            onchange="previewFile(this, 'previewImage6')">
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                    <label for="nama">Upload Foto Kondisi Saat ini</label>
                                    <input type="file" class="form-control" name="foto">
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
