@extends('layouts.main')
@section('content')
    <div class="pcoded-main-container">
        <div class="pcoded-content">

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
            <form action="{{ $forms['id'] ?? null ? route('update', $forms['id']) : route('add') }}" method="post"
                class="" enctype="multipart/form-data">
                @csrf
                @method($forms['id'] ?? null ? 'put' : 'post')
                <div class="card card-danger">
                    <div class="card-body">

                        <div class="row justify-content-end p-3">
                            <div class="col-6">
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
                                    <select class="form-control select2" style="width: 100%;"
                                        value="{{ old('jabatan') ?? ($forms['jabatan'] ?? '') }}" name="jabatan">
                                        <option selected="selected" value="TM">Team Member</option>
                                        <option value="TL">Team Leader</option>
                                        <option value="FM">Foreman</option>
                                        <option value="SPV">Supervisor</option>
                                        <option value="superadmin">Superadmin</option>
                                    </select>
                                </div>
                                {{-- <label for="nama">Jabatan</label>
                            <input type="text" class="form-control" name="jabatan"
                                value="{{ old('jabatan') ?? ($forms['jabatan'] ?? '') }}" required> --}}
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Section</label>
                                    <select class="form-control select2" style="width: 100%;"
                                        value="{{ old('section') ?? ($forms['section'] ?? '') }}" name="section">
                                        <option selected="selected" value="BODY 1">BODY 1</option>
                                        <option value="BODY 2">BODY 2</option>
                                    </select>
                                </div>

                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Shift</label>
                                    <select class="form-control select2" style="width: 100%;"
                                        value="{{ old('shift') ?? ($forms['shift'] ?? '') }}" name="shift">
                                        <option selected="selected" value="pagi">Pagi</option>
                                        <option value="malam">Malam</option>
                                        <option value="non shift">Non Shift</option>
                                    </select>
                                </div>

                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control select2" style="width: 100%;"
                                        value="{{ old('status') ?? ($forms['status'] ?? '') }}" name="status">
                                        <option selected="selected" value="permanen">Permanen</option>
                                        <option value="ojt">OJT</option>
                                    </select>
                                </div>

                            </div>
                            <div class="col-6">
                                <label for="nama">Password</label>
                                <input type="password" class="form-control" name="password"
                                    value="{{ old('password') ?? ($forms['password'] ?? '') }}">
                            </div>




                            <div class="col-12 text-end">
                                <button class="btn btn-success col-3 mt-5" type="submit">Submit</button>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
