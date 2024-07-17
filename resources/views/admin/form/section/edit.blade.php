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
            <form action="{{ route('update-section', $forms['id'] ?? null) }}" method="post" class=""
                enctype="multipart/form-data">
                @csrf
                @if (isset($forms['id']))
                    @method('put')
                @endif
                <div class="card card-danger">
                    <div class="card-body">
                        <div class="row justify-content-end p-3">
                            <div class="col-6 mb-3">
                                <label for="nama">ID Section</label>
                                <input type="text" class="form-control" name="id_section"
                                    value="{{ old('id_section') ?? ($forms['id_section'] ?? '') }}" required>
                            </div>
                            <div class="col-6">
                                <label for="nama">Nama Section</label>
                                <input type="text" class="form-control" name="section"
                                    value="{{ old('section') ?? ($forms['section'] ?? '') }}" required>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label>NPK Koordinator</label>
                                    <input type="text" class="form-control" name="npk_cord"
                                        value="{{ old('npk_cord') ?? ($forms['npk_cord'] ?? '') }}" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <label>ID Department</label>
                                <select class="form-control select2" style="width: 100%;" name="id_dept" required>
                                    <option value="{{ $section->id_dept }}" selected>{{ $deptName }}</option>
                                    @foreach ($department as $item)
                                        <option value="{{ $item->id_dept }}">{{ $item->dept }}</option>
                                    @endforeach
                                </select>
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
