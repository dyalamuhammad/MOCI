@extends('layouts.main')
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
            <form action="{{ $forms['id'] ?? null ? route('update-user', $forms['id']) : route('add') }}" method="post"
                class="" enctype="multipart/form-data">
                @csrf
                @method($forms['id'] ?? null ? 'put' : 'post')
                <div class="card card-danger">
                    <div class="card-body">

                        <div class="row justify-content-end p-3">
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
                                    <select class="form-control select2" style="width: 100%;" name="jabatan" required>
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

                                {{-- <label for="nama">Jabatan</label>
                            <input type="text" class="form-control" name="jabatan"
                                value="{{ old('jabatan') ?? ($forms['jabatan'] ?? '') }}" required> --}}
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Tanggal Masuk</label>
                                    <input type="date" class="form-control" name="tgl_masuk"
                                        value="{{ old('tgl_masuk') ?? ($forms['tgl_masuk'] ?? '') }}" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Group</label>
                                    {{-- <input type="text" class="form-control" name="password" value="{{ $groupName }}"> --}}
                                    <select class="form-control select2" style="width: 100%;" name="grp" required>
                                        <option value="" selected>Pilih Group</option>
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
                                        <option value="" selected>Pilih Section</option>
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
                                        <option value="" selected>Pilih Departemen</option>
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
                                        value="{{ old('shift') ?? ($forms['shift'] ?? '') }}" name="shift" required>
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
                                        value="{{ old('status') ?? ($forms['status'] ?? '') }}" name="status" required>
                                        <option selected="selected" value="P">Permanen</option>
                                        <option value="C1">C1</option>
                                        <option value="C2">C2</option>
                                    </select>
                                </div>

                            </div>
                            <div class="col-6">
                                <label for="nama">Password</label>
                                <input type="password" class="form-control" name="password"
                                    value="{{ old('password') ?? ($forms['password'] ?? '') }}" required>
                            </div>




                            <div class="col-12 d-flex justify-content-between">

                                <button class="btn btn-green col-auto mt-5" onclick="javascript:history.back()"
                                    type="button"><i class="bi bi-arrow-left me-2"></i>Back</button> <button
                                    class="btn btn-green col-3 mt-5" type="submit">Submit</button>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
