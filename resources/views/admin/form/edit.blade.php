@extends('layouts.main')
@section('script')
    <script>
        document.getElementById('faces').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('facePreview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (!preview) {
                        // Buat img element kalau belum ada (untuk kasus user upload wajah baru)
                        const img = document.createElement('img');
                        img.id = 'facePreview';
                        img.style.maxHeight = '350px';
                        img.style.maxWidth = '100%';
                        img.style.marginBottom = '10px';
                        event.target.parentElement.appendChild(img); // simpan setelah input file
                        img.src = e.target.result;
                    } else {
                        preview.src = e.target.result;
                        preview.style.display = 'inline';
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    </script>

    <script>
        function deleteFace(npk) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`http://127.0.0.1:5000/delete_face/${npk}`, {
                            method: "DELETE"
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.message) {
                                Swal.fire('Berhasil!', data.message, 'success');
                                // Jika perlu reload data atau sembunyikan preview:
                                document.getElementById('facePreview')?.remove();
                            } else if (data.error) {
                                Swal.fire('Gagal!', data.error, 'error');
                            }
                        })
                        .catch(error => {
                            console.error("Error:", error);
                            Swal.fire('Error', 'Terjadi kesalahan saat menghapus data.', 'error');
                        });
                }
            });
        }
    </script>
@endsection
@section('content')
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            @include('alert')
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
                                <li class="breadcrumb-item"><a href="{{ route('karyawan') }}">Data Karyawan</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('form') }}">Form Karyawan</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <form action="{{ route('update-user', $forms['id'] ?? null) }}" method="post" id="userForm"
                enctype="multipart/form-data">
                @csrf
                @if (isset($forms['id']))
                    @method('put')
                @endif
                <div class="card card-danger">
                    <div class="card-body">
                        <div class="row justify-content-start p-3">
                            <div class="col-6 mb-3">
                                <label for="nama">NPK</label>
                                <input type="number" class="form-control" name="npk"
                                    value="{{ old('npk') ?? ($forms['npk'] ?? '') }}" required>
                            </div>
                            <div class="col-6">
                                <label for="nama">Name</label>
                                <input type="text" class="form-control" name="name"
                                    value="{{ old('name') ?? ($forms['name'] ?? '') }}" required>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Jabatan</label>
                                    <select class="form-control select2" style="width: 100%;" name="jabatan">
                                        <option value="TM"
                                            {{ (old('jabatan') ?? ($forms['jabatan'] ?? '')) == 'TM' ? 'selected' : '' }}>
                                            Team Member</option>
                                        <option value="TL"
                                            {{ (old('jabatan') ?? ($forms['jabatan'] ?? '')) == 'TL' ? 'selected' : '' }}>
                                            Team Leader</option>
                                        <option value="FRM"
                                            {{ (old('jabatan') ?? ($forms['jabatan'] ?? '')) == 'FRM' ? 'selected' : '' }}>
                                            Foreman</option>
                                        <option value="SPV"
                                            {{ (old('jabatan') ?? ($forms['jabatan'] ?? '')) == 'SPV' ? 'selected' : '' }}>
                                            Supervisor</option>
                                        <option value="AMNG"
                                            {{ (old('jabatan') ?? ($forms['jabatan'] ?? '')) == 'AMNG' ? 'selected' : '' }}>
                                            Manager</option>
                                        <option value="MNG"
                                            {{ (old('jabatan') ?? ($forms['jabatan'] ?? '')) == 'MNG' ? 'selected' : '' }}>
                                            Manager</option>
                                        <option value="DH"
                                            {{ (old('jabatan') ?? ($forms['jabatan'] ?? '')) == 'DH' ? 'selected' : '' }}>
                                            Division Head</option>
                                        <option value="Superadmin"
                                            {{ (old('jabatan') ?? ($forms['jabatan'] ?? '')) == 'Superadmin' ? 'selected' : '' }}>
                                            Superadmin</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Tanggal Masuk</label>
                                    <input type="date" class="form-control" name="tgl_masuk"
                                        value="{{ old('tgl_masuk') ?? ($forms['tgl_masuk'] ?? '') }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Group</label>
                                    {{-- <input type="text" class="form-control" name="password" value="{{ $groupName }}"> --}}
                                    <select class="form-control select2" style="width: 100%;" name="grp" required>
                                        <option value="{{ $groupId }}" selected>{{ $groupName }}</option>
                                        @foreach ($group as $item)
                                            <option value="{{ $item->id_group }}">{{ $item->nama_group }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Section</label>
                                    {{-- <input type="text" class="form-control" name="password" value="{{ $sectionName }}"> --}}
                                    <select class="form-control select2" style="width: 100%;" name="sect" required>
                                        <option value="{{ $sectionId }}" selected>{{ $sectionName }}</option>
                                        @foreach ($section as $item)
                                            <option value="{{ $item->id_section }}">{{ $item->section }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Departemen</label>
                                    {{-- <input type="text" class="form-control" name="password" value="{{ $deptName }}"> --}}
                                    <select class="form-control select2" style="width: 100%;" name="dept" required>
                                        <option value="{{ $deptId }}" selected>{{ $deptName }}</option>
                                        @foreach ($department as $item)
                                            <option value="{{ $item->id_dept }}">{{ $item->dept }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Shift</label>
                                    <select class="form-control select2" style="width: 100%;"
                                        value="{{ old('shift') ?? ($forms['shift'] ?? '') }}" name="shift">
                                        <option value="A"
                                            {{ (old('shift') ?? ($forms['shift'] ?? '')) == 'A' ? 'selected' : '' }}>
                                            Shift A</option>
                                        <option value="B"
                                            {{ (old('shift') ?? ($forms['shift'] ?? '')) == 'B' ? 'selected' : '' }}>
                                            Shift B</option>
                                        <option value="N"
                                            {{ (old('shift') ?? ($forms['shift'] ?? '')) == 'N' ? 'selected' : '' }}>
                                            Non Shift</option>
                                    </select>
                                </div>

                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control select2" style="width: 100%;"
                                        value="{{ old('status') ?? ($forms['status'] ?? '') }}" name="status">
                                        <option selected="selected" value="P">Permanen</option>
                                        <option value="C1">C1</option>
                                        <option value="C2">C2</option>
                                    </select>
                                </div>

                            </div>
                            <div class="col-6">
                                <label for="nama">Password</label>
                                <input type="password" class="form-control" id="password" name="password"
                                    value="{{ old('password') ?? ($forms['password'] ?? '') }}">
                            </div>
                            <div class="col-6">
                                <label for="faces">Data Wajah</label>

                                @if ($faces)
                                    <button class="btn btn-danger d-block" onclick="deleteFace('{{ $forms['npk'] }}')"
                                        type="button">Delete
                                        Face</button>
                                @else
                                    <input type="file" class="form-control mb-3" id="faces" name="faces"
                                        accept="image/*">
                                @endif
                            </div>

                            <div class="col-6">
                                @if (!empty($faces))
                                    <!-- Gambar preview akan muncul di sini -->
                                    <img id="facePreview" src="http://localhost:5000/{{ $faces ?? '' }}"
                                        alt="Preview wajah"
                                        style="max-height: 350px; max-width: 100%; display: block; margin-bottom: 10px;">
                                @endif
                            </div>





                            <div class="col-12 d-flex justify-content-between">

                                <button class="btn btn-secondary col-1 mt-5" onclick="javascript:history.back()"
                                    type="button"><i class="bi bi-arrow-left me-2"></i>Back</button>
                                <button class="btn btn-green col-1 mt-5" type="submit">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
