@extends('layouts/main')
@section('script')
    <script>
        function doDelete(id) {
            if (confirm('Yakin Hapus?')) {
                location.href = `control-step/${id}`;
            }
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
                                <h5 class="m-b-10">Control Periode</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="bi bi-house"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('controlStep') }}">Control Periode</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Control Periode</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <tr class="table-primary text-center">
                                        <th class="col-1">Periode</th>
                                        <th>Tema</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Akhir</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    @foreach ($periode->sortByDesc('id') as $item)
                                        @php
                                            $now = now()->toDateString();
                                            $isActive =
                                                $item->tanggal_akhir >= \Carbon\Carbon::now()->toDateString() &&
                                                $item->status == 1 &&
                                                $item->tanggal_mulai <= \Carbon\Carbon::now()->toDateString();
                                        @endphp
                                        <tr class="text-center {{ $isActive ? 'table-success' : '' }}">
                                            <td>{{ $item->periode }}</td>
                                            <td>{{ $item->tema }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d/m/Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal_akhir)->format('d/m/Y') }}</td>
                                            <td>
                                                @if (
                                                    $item->tanggal_akhir >= \Carbon\Carbon::now()->toDateString() &&
                                                        $item->status == 1 &&
                                                        $item->tanggal_mulai <= \Carbon\Carbon::now()->toDateString())
                                                    Aktif
                                                @elseif ($item->tanggal_mulai >= \Carbon\Carbon::now()->toDateString() && $item->status == 1)
                                                    Belum Aktif
                                                @else
                                                    Tidak Aktif
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('edit-periode', ['id' => $item->id]) }}"
                                                    class="btn btn-secondary btn-sm">Ubah</a>
                                                <button class="btn btn-danger btn-sm" button class="btn btn-danger w-100"
                                                    onclick="doDelete({{ $item->id }})">Hapus</button>
                                            </td>

                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endsection
