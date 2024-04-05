@extends('layouts.main')
@section('content')
    <!-- [ Main Content ] start -->
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">User Profile</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="bi bi-house"></i></a></li>
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
                    <img src="{{ asset('images/profile.jpg') }}" alt="" class="rounded-circle" width="150px" height="150px">
                    <h3 class="pt-3 fw-light">{{ $user->name }} <br> <span class="fw-semibold fs-5">{{ $user->npk }}</span></h3>
                </div>
                
            </div>
            <div class="card col-6">
                <div class="card-body">
                    <label for="">NPK</label>
                    <input type="text" class="form-control" value="{{ $user->npk }}" readonly>
                    <label for="">Nama</label>
                    <input type="text" class="form-control" value="{{ $user->name }}" readonly>
                    <label for="">Section</label>
                    <input type="text" class="form-control text-capitalize" value="{{ $user->section }}" readonly>
                    <label for="">Jabatan</label>
                    <input type="text" class="form-control" value="{{ $user->jabatan }}" readonly>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection