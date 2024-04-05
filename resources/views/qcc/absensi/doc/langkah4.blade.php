@extends('layouts.main')
@section('script')
    <script>
        function downloadPDF() {
            const element = document.querySelector('.card-body');
            html2pdf(element);
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.js"></script>
@endsection
@section('content')
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">Notulen Langkah 4</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="bi bi-house"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('monitorQcc') }}">Monitor QCC</a></li>
                                <li class="breadcrumb-item"><a href="">Detail Circle</a></li>
                                <li class="breadcrumb-item"><a href="#">Notulen</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="card">
                    <button class="btn btn-outline-success col-4 col-lg-2 text-center my-3" onclick="downloadPDF()"><i
                            class="bi bi-download me-2"></i>Download</button>
                    <div class="card-body p-1 p-md-3">
                        <div class="notulen">
                            <table class="table table-bordered border-dark w-100 border-3">
                                <tr>
                                    <td class="col-1 p-0" rowspan="2"> <img src="{{ asset('images/daihatsu-logo.jpg') }}"
                                            alt="" class="w-100"></td>
                                    <td class="col-1 py-0 align-middle text-center" rowspan="2">
                                        <b>{{ date('Y') }}</b>
                                    </td>
                                    <td class="col-6 text-center py-0 align-middle" colspan="3">
                                        <b>NOTULEN QCC</b>
                                        {{-- {{ isset($forms['created_at']) ? $forms['created_at']->format('d-m-Y H:i:s') : old('created_at') }} --}}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-center py-0 align-middle"><b>LANGKAH 4 RENCANA
                                            PERBAIKAN</b></td>
                                </tr>

                                <tr>
                                    <td colspan="2">Nama Circle :</td>
                                    <td colspan="3">{{ $circleName }}</td>

                                </tr>
                                <tr>
                                    <td colspan="2">Judul QCC</td>
                                    <td colspan="3" class="text-capitalize">{{ $judulNotulen }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2">Divisi Departemen</td>
                                    <td colspan="3" class="text-uppercase">{{ $sectionLeader }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2">Tema Leader (NPK)</td>
                                    <td colspan="1">{{ $npkLeader }}</td>
                                    <td colspan="1">{{ $leaderName }}</td>
                                    <td colspan="1"></td>
                                </tr>
                                <tr>
                                    <td colspan="2">Fasilitator</td>
                                    <td colspan="3">{{ $nama_cord }}</td>
                                </tr>
                                </tr>
                                <tr>
                                    <td colspan="2">Nama Anggota</td>
                                    <td colspan="1">NPK</td>
                                    <td colspan="1">NAMA</td>
                                    <td colspan="1"></td>
                                </tr>
                                @foreach ($members as $item)
                                    <tr>
                                        <td colspan="2"></td>
                                        <td colspan="1">{{ $item->npk_anggota }}</td>
                                        <td colspan="1">@php
                                            $user = \App\Models\User::where('npk', $item->npk_anggota)->first();
                                        @endphp
                                            {{ $user->name ?? '' }}</td>
                                        <td colspan="1"></td>
                                    </tr>
                                @endforeach

                                <tr>
                                    <th colspan="5">Rencana Perbaikan 5W + 1H</th>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <table class="table">
                                            <tr class="table-success">
                                                <th>WHAT</th>
                                                <th>HOW</th>
                                                <th>WHY</th>
                                                <th>WHERE</th>
                                                <th>WHEN</th>
                                                <th>HOW MUCH</th>
                                                <th>TARGET ANTARA</th>
                                            </tr>
                                            @foreach ($rencanas as $rencana)
                                                <tr>
                                                    <td>{{ $rencana->what }}</td>
                                                    <td>{{ $rencana->how ?: '-' }}</td>
                                                    <td>{{ $rencana->why ?: '-' }}</td>
                                                    <td>{{ $rencana->where ?: '-' }}</td>
                                                    <td>{{ $rencana->when ?: '-' }}</td>
                                                    <td>{{ $rencana->how_much ?: '-' }}</td>
                                                    <td>{{ $rencana->target_antara ?: '-' }}</td>
                                                </tr>
                                            @endforeach
                                        </table>

                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="5">Design Improvement</th>
                                </tr>
                                <tr>
                                    {{-- <td colspan="4">p</td> --}}
                                    <td colspan="1" class="col-3"><img src="{{ asset($designImprove) }}" alt=""
                                            class="w-100"></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    @endsection
