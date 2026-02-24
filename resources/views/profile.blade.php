@extends('layouts.main')
@section('script')
    <!-- Tambahkan SweetAlert jika belum -->
{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}

    <script>
        document.getElementById('faces').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('facePreview');
            const allowedTypes = ["image/jpeg", "image/png", "image/jpg"];

            if (file) {
                if (!allowedTypes.includes(file.type)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'File tidak valid!',
                        text: 'Hanya file gambar (JPG, JPEG, PNG) yang diperbolehkan.',
                        confirmButtonText: 'Oke'
                    });

                    // Reset file input dan sembunyikan preview jika ada
                    this.value = "";
                    if (preview) preview.style.display = 'none';

                    // Nonaktifkan tombol submit (opsional)
                    const submitBtn = this.closest('form').querySelector("button[type='submit']");
                    if (submitBtn) submitBtn.disabled = true;

                    return; // hentikan eksekusi lanjut
                }

                // Aktifkan tombol submit kembali
                const submitBtn = this.closest('form').querySelector("button[type='submit']");
                if (submitBtn) submitBtn.disabled = false;

                const reader = new FileReader();
                reader.onload = function(e) {
                    if (!preview) {
                        const img = document.createElement('img');
                        img.id = 'facePreview';
                        img.style.maxHeight = '350px';
                        img.style.maxWidth = '100%';
                        img.style.marginBottom = '10px';
                        event.target.parentElement.appendChild(img);
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
                    fetch(`http://127.0.0.1:5001/delete_face/${npk}`, {
                            method: "DELETE"
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.message) {
                                Swal.fire('Berhasil!', data.message, 'success');
                                // Jika perlu reload data atau sembunyikan preview:
                                document.getElementById('facePreview')?.remove();
                                window.location.reload();
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
    <!-- [ Main Content ] start -->
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            @include('alert')
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">User Profile</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="bi bi-house"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#!">Profile</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <div class="row gap-1 justify-content-between">
                <div class="card col-5">
                    <div class="card-body d-flex gap-3">
                        <img src="{{ asset('images/profile.jpg') }}" alt="" class="rounded-circle" width="150px"
                            height="150px">
                        <h3 class="pt-3 fw-light">{{ $user->name }} <br> <span class="fs-5">{{ $jabatan }}</span>
                            <br><span class="fw-semibold fs-5">{{ $user->npk }}</span>
                        </h3>
                    </div>
                    <form action="{{ route('editPassword') }}" method="post">
                        @csrf
                        <label for="">Password</label>
                        <input type="password" class="form-control mb-3" placeholder="Masukkan Password Baru..."
                            name="password" required>
                        <button class="btn btn-green mb-3" type="submit">Edit Password</button>
                    </form>

                </div>
                <div class="card col-6">
                    <div class="card-body">
                        <form action="{{ route('edit-profile') }}" method="post">
                            @csrf
                            <input type="hidden" name="npk" value="{{ $userNpk }}">
                            <label for="">Group</label>
                            {{-- <input type="text" class="form-control mb-3 text-capitalize" value="{{ $groupName }}"> --}}
                            <select class="form-control select2 mb-3" style="width: 100%;" name="grp" required>
                                <option value="{{ $groupId }}" selected>{{ $groupName }}</option>
                                @foreach ($group as $item)
                                    <option value="{{ $item->id_group }}">{{ $item->nama_group }}</option>
                                @endforeach
                            </select>
                            <label for="">Section</label>
                            {{-- <input type="text" class="form-control mb-3 text-capitalize" value="{{ $sectName }}"
                                readonly> --}}
                            <select class="form-control select2 mb-3" style="width: 100%;" name="sect" required>
                                <option value="{{ $sectionId }}" selected>{{ $sectName }}</option>
                                @foreach ($section as $item)
                                    <option value="{{ $item->id_section }}">{{ $item->section }}</option>
                                @endforeach
                            </select>
                            <label for="">Departemen</label>
                            {{-- <input type="text" class="form-control mb-3 text-capitalize" value="{{ $deptName }}"
                                readonly> --}}
                            <select class="form-control select2 mb-3" style="width: 100%;" name="dept" required>
                                <option value="{{ $deptId }}" selected>{{ $deptName }}</option>
                                @foreach ($department as $item)
                                    <option value="{{ $item->id_dept }}">{{ $item->dept }}</option>
                                @endforeach
                            </select>
                            {{-- <label for="">Jabatan</label>
                            <input type="text" class="form-control mb-3" value="{{ $jabatan }}" readonly> --}}
                            <button class="btn btn-green" type="submit">Edit Group</button>
                        </form>
                    </div>

                </div>
                <div class="card col-5">
                    <div class="card-body d-flex gap-3">

                        <h3 class="pt-3 fw-light">Data Wajah<span class="bg-warning rounded-pill px-2 text-white align-top"
                                style="font-size: 12px">Baru</span>
                        </h3>
                    </div>
                    <form action="{{ route('edit-face', $user->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="npk" value="{{ $user->npk }}">
                        <input type="hidden" name="name" value="{{ $user->name }}">
                        @if (!empty($faces))
                            <!-- Gambar preview akan muncul di sini -->
                            <img id="facePreview" src="http://localhost:5001/{{ $faces ?? '' }}" alt="Preview wajah"
                                style="max-height: 350px; max-width: 100%; display: block; margin-bottom: 10px;">
                        @endif
                        @if ($faces)
                            <button class="btn btn-danger d-block mb-3" onclick="deleteFace('{{ $user->npk }}')"
                                type="button">Delete
                                Face</button>
                        @else
                            <input type="file" class="form-control mb-3" id="faces" name="faces" accept="image/*">
                            <button class="btn btn-green mb-3" type="submit" disabled>Tambah Wajah</button>
                        @endif

                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
