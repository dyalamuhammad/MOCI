@extends('layouts/main')
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
                                <h5 class="m-b-10">Resume Absensi</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="bi bi-house"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('resumeQcc') }}">Resume Absensi</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            @if ($periode->count() > 0 and $circles->count() > 0)
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header bg-darkBlue text-white">
                                <h5 class="text-white">Monitoring Keaktifan Circle</h5>
                                <span class="d-block m-t-5">Hallo sahabat berikut monitoring absensi anggota setiap
                                    circle</span>
                            </div>
                            <div class="card-body table-border-style">
                                <div class="table-responsive">

                                    <table class="table table-borderes rounded-3">

                                        <tr class="table-danger">
                                            <th class="col-1">No</th>
                                            <th class="col-1">Periode</th>
                                            <th class="col-1">Circle</th>
                                            <th class="col-1">NPK</th>
                                            <th class="col-1">Nama</th>
                                            <th>L1</th>
                                            <th>L2</th>
                                            <th>L3</th>
                                            <th>L4</th>
                                            <th>L5</th>
                                            <th>L6</th>
                                            <th>L7</th>
                                            <th>L8</th>
                                            <th>NQI</th>
                                        </tr>

                                        @foreach ($members as $item)
                                            <tr class="align-middle">
                                                <td class="align-middle">{{ $loop->iteration }}</td>
                                                <td class="align-middle">
                                                    @php
                                                        // Temukan data circle berdasarkan circle_id
                                                        $circle = \App\Models\Circle::find($item->circle_id);
                                                        // Periksa apakah circle ditemukan
                                                        if ($circle) {
                                                            // Jika ya, ambil periode dari circle
                                                            $periodeMember = $circle->periode;
                                                            $circleMember = $circle->name;
                                                        } else {
                                                            // Jika tidak ditemukan, atur periodeMember ke default atau sesuai kebutuhan aplikasi Anda
                                                            $periodeMember = 'Periode Tidak Ditemukan';
                                                        }
                                                    @endphp
                                                    {{ $periodeMember }}
                                                </td>
                                                <td class="align-middle">{{ $circleMember }}</td>
                                                <td class="align-middle">{{ $item->npk_anggota }}</td>
                                                <td class="align-middle">@php
                                                    $user = \App\Models\User::where('npk', $item->npk_anggota)->first();
                                                @endphp
                                                    {{ $user->name ?? '' }}
                                                </td>
                                                <td>
                                                    @if ($item->l1 >= 1)
                                                        <i class="bi bi-check2-all fs-3 text-success"></i>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    @if ($item->l2 >= 1)
                                                        <i class="bi bi-check2-all fs-3 text-success"></i>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    @if ($item->l3 >= 1)
                                                        <i class="bi bi-check2-all fs-3 text-success"></i>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    @if ($item->l4 >= 1)
                                                        <i class="bi bi-check2-all fs-3 text-success"></i>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    @if ($item->l5 >= 1)
                                                        <i class="bi bi-check2-all fs-3 text-success"></i>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    @if ($item->l6 >= 1)
                                                        <i class="bi bi-check2-all fs-3 text-success"></i>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    @if ($item->l7 >= 1)
                                                        <i class="bi bi-check2-all fs-3 text-success"></i>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    @if ($item->l8 >= 1)
                                                        <i class="bi bi-check2-all fs-3 text-success"></i>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    @if ($item->nqi >= 1)
                                                        <i class="bi bi-check2-all fs-3 text-success"></i>
                                                    @else
                                                        -
                                                    @endif
                                                </td>


                                            </tr>
                                        @endforeach

                                    </table>
                                </div>
                            </div>
                            {{-- <div class="row">
                        <div class="col-md-4">
                            <div class="card-body">
                                <a href ="dashboard.php" type="button" class="btn btn-danger"><i class="feather mr-2 icon-slash"></i>Batal </a>
                                <a href = "cetak_qcc.php" class="btn btn-primary"><i class="feather mr-2 icon-thumbs-up"></i>Download</a>
                            </div>
                        </div>
                    </div> --}}
                        </div>
                    @else
                        <i class="text-danger">Periode atau circle belum dibuat...</i>
            @endif
        </div>
    </div>

@endsection
