@extends('layouts.main')
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
            </div>
        </div>
    </div>
@endsection
