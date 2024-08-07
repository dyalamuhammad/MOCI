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
                                <h5 class="m-b-10">Notulen Langkah 3</h5>
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
                                    <th colspan="5">Analisa 4M1E</th>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <table class="table">
                                            <tr class="table-success">
                                                <th class="col-1">ITEM</th>
                                                <th>WHY 1</th>
                                                <th>WHY 2</th>
                                                <th>WHY 3</th>
                                                <th>WHY 4</th>
                                                <th>WHY 5</th>
                                                <th class="col-1">FOTO</th>
                                            </tr>
                                            @foreach ($analisa4m1es as $analisa)
                                                <tr>
                                                    <td class="bg-green">{{ $analisa->category }}</td>
                                                    <td>{{ $analisa->why1 ?: '-' }}</td>
                                                    <td>{{ $analisa->why2 ?: '-' }}</td>
                                                    <td>{{ $analisa->why3 ?: '-' }}</td>
                                                    <td>{{ $analisa->why4 ?: '-' }}</td>
                                                    <td>{{ $analisa->why5 ?: '-' }}</td>
                                                    <td>
                                                        @if ($analisa->foto)
                                                            <img src="{{ asset('notulen3/' . $analisa->foto) }}"
                                                                alt="Foto" class="w-100">
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="5">Uji Penyebab</th>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <table class="table">
                                            <tr class="table-success">
                                                <th>Akar Masalah</th>
                                                <th>Standar</th>
                                                <th>Metode Validasi</th>
                                                <th>Actual</th>
                                                <th>Judge</th>
                                            </tr>
                                            @foreach ($ujiPenyebabs as $ujiPenyebab)
                                                <tr>
                                                    <td>{{ $ujiPenyebab->akar_masalah ?: '-' }}</td>
                                                    <td>{{ $ujiPenyebab->standar ?: '-' }}</td>
                                                    <td>{{ $ujiPenyebab->metode_validasi ?: '-' }}</td>
                                                    <td>{{ $ujiPenyebab->actual ?: '-' }}</td>
                                                    <td>{{ $ujiPenyebab->judge ?: '-' }}</td>
                                                </tr>
                                            @endforeach
                                        </table>

                                    </td>
                                </tr>




                            </table>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    @endsection
