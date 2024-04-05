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
                                <h5 class="m-b-10">Monitor QCC</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href=""><i class="bi bi-house"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('monitorQcc') }}">Monitor QCC</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            @if ($circles->count() > 0)
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header bg-darkBlue text-white">
                                <h5 class="text-white">Monitoring Keaktifan Circle</h5>
                                <span class="d-block">Hallo sahabat Berikut data monitoring keaktifan circle</span>
                            </div>
                            <div class="card-body table-border-style">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr class="table-danger">
                                            <th>Periode</th>
                                            <th>Circle</th>
                                            <th>Npk Tema Leader</th>
                                            <th>Nama Tema Leader</th>
                                            <th>L1</th>
                                            <th>L2</th>
                                            <th>L3</th>
                                            <th>L4</th>
                                            <th>L5</th>
                                            <th>L6</th>
                                            <th>L7</th>
                                            <th>L8</th>
                                            <th>NQI</th>
                                            <th class="text-center">Preview</th>
                                        </tr>
                                        <tr>
                                            @foreach ($showCircle as $item)
                                        <tr>
                                            <td>{{ $item->periode }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->npk_leader }}</td>
                                            <td>{{ $item->leader }}</td>
                                            <td class="py-0 align-middle">
                                                @if ($item->l1 >= 1)
                                                    <i class="bi bi-check2-all fs-3 text-success"></i>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="py-0 align-middle">
                                                @if ($item->l2 >= 1)
                                                    <i class="bi bi-check2-all fs-3 text-success"></i>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="py-0 align-middle">
                                                @if ($item->l3 >= 1)
                                                    <i class="bi bi-check2-all fs-3 text-success"></i>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="py-0 align-middle">
                                                @if ($item->l4 >= 1)
                                                    <i class="bi bi-check2-all fs-3 text-success"></i>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="py-0 align-middle">
                                                @if ($item->l5 >= 1)
                                                    <i class="bi bi-check2-all fs-3 text-success"></i>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="py-0 align-middle">
                                                @if ($item->l6 >= 1)
                                                    <i class="bi bi-check2-all fs-3 text-success"></i>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="py-0 align-middle">
                                                @if ($item->l7 >= 1)
                                                    <i class="bi bi-check2-all fs-3 text-success"></i>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="py-0 align-middle">
                                                @if ($item->l8 >= 1)
                                                    <i class="bi bi-check2-all fs-3 text-success"></i>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="py-0 align-middle">
                                                @if ($item->nqi >= 1)
                                                    <i class="bi bi-check2-all fs-3 text-success"></i>
                                                @else
                                                    -
                                                @endif
                                            </td>

                                            <td class="text-center">
                                                <button class="btn btn-sm btn-success"
                                                    onclick="window.location='{{ route('detailCircle', ['circle_id' => $item->id]) }}'">Lihat</button>
                                            </td>
                                        </tr>
            @endforeach


            </table>
        </div>
    </div>

    </div>
    </div>
    </div>
@else
    <i class="text-danger">Circle belum dibuat...</i>
    @endif



@endsection
