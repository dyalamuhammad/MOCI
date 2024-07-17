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
                                <h5 class="m-b-10">Monitor Circle Design Thinking</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="bi bi-house"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('monitorDt') }}">Monitor DT</a></li>
                                <li class="breadcrumb-item"><a href="#!">Detail Circle</a></li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header bg-darkBlue text-white">
                            <h5 class="text-white">Monitoring Keaktifan Circle</h5>
                            <span class="d-block m-t-5">Hallo sahabat Berikut lampiran notulen circle </span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">

                                <table class="table">

                                    <tr class="table-primary">
                                        <th class="col-1">NO</th>
                                        <th>Circle</th>
                                        <th>NPK Leader</th>
                                        <th>Nama Leader</th>
                                        <th>L1</th>
                                        <th>L2</th>
                                        <th>L3</th>
                                        <th>L4</th>
                                        <th>L5</th>
                                        <th>L6</th>
                                        <th>L7</th>
                                        <th>L8</th>
                                        <th>NQI</th>
                                        <!-- Tambahkan kolom lain sesuai kebutuhan -->
                                    </tr>

                                    <tr>
                                        <td>1</td>
                                        <td>{{ $circle->name }}</td>
                                        <td>{{ $circle->npk_leader }}</td>
                                        <td>{{ $circle->leader }}</td>
                                        @for ($i = 1; $i <= 8; $i++)
                                            @if ($circle->{'l' . $i} >= 1)
                                                <td>
                                                    <button class="btn btn-green btn-sm"
                                                        onclick="window.location.href='{{ route('docDt' . $i, ['id' => $circle->id]) }}'">
                                                        <i class="bi bi-file-earmark"></i>
                                                    </button>
                                                </td>
                                            @else
                                                <td>-</td>
                                            @endif
                                        @endfor

                                        @if ($circle->nqi == 1)
                                            <td>
                                                <button class="btn btn-green btn-sm"
                                                    onclick="window.location.href='{{ route('docDt9', ['id' => $circle->id]) }}'">
                                                    <i class="bi bi-file-earmark"></i>
                                                </button>
                                            </td>
                                        @else
                                            <td>-</td>
                                        @endif


                                    </tr>
                                </table>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        @endsection
