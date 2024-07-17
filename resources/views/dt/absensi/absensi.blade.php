@extends('layouts.main')

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
                                <h5 class="m-b-10">Absensi Design Thinking</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="bi bi-house"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="">Absensi DT</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            @if ($periode->count() > 0)
                @php
                    $npkUser = auth()->user()->npk; // Mendapatkan NPK pengguna saat ini
                    $activePeriode = \App\Models\Periode::where('status', 1)->first();
                    $periode = \App\Models\Periode::where('status', 1)->value('periode');
                    $npkLeaderExists = \App\Models\CircleDt::where('npk_leader', $npkUser)
                        ->where('periode', $periode)
                        ->exists();
                    $npkLeaderCategory = \App\Models\CircleDt::where('npk_leader', $npkUser)
                        ->where('periode', $periode)
                        ->where('category', 'DT')
                        ->exists();

                @endphp
                @if (
                    $activePeriode &&
                        ($activePeriode->tanggal_akhir >= \Carbon\Carbon::now()->toDateString() &&
                            $activePeriode->tanggal_mulai <= \Carbon\Carbon::now()->toDateString()))
                    @if ($npkLeaderExists)
                        @if ($npkLeaderCategory)
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card card-dark">
                                        <div class="card-header bg-darkBlue text-white">
                                            <h5 class="text-white">Absensi Kehadiran DT</h5>
                                            <span class="d-block m-t-5">Hello Sahabat Silahkan Pilih Langkah DT dibawah ini
                                                ya</span>
                                        </div>
                                        <div class="card-body">
                                            @php
                                                $now = now()->toDateString();
                                                $periodeLangkah = '';
                                            @endphp

                                            @foreach ($langkahData->skip(1)->take(8) as $langkah)
                                                @php
                                                    $isInProgress = $now >= $langkah->mulai && $now <= $langkah->sampai;
                                                    if ($isInProgress) {
                                                        // Jika langkah sedang berlangsung, tambahkan informasi periode ke variabel $periodeLangkah
                                                        $periodeLangkah .=
                                                            ($periodeLangkah ? ', ' : '') .
                                                            \Carbon\Carbon::parse($langkah->mulai)->format('d F Y') .
                                                            ' - ' .
                                                            \Carbon\Carbon::parse($langkah->sampai)->format('d F Y');
                                                    }
                                                @endphp
                                            @endforeach

                                            @if ($periodeLangkah)
                                                <div class="alert alert-info d-flex justify-content-between">
                                                    <div>
                                                        <li class="list-group-item">
                                                            Masa Pengisian Langkah Yang Sedang Berjalan Saat Ini
                                                            :
                                                        </li>
                                                        <li class="list-group-item">
                                                            <b>{{ $periodeLangkah }}</b>
                                                        </li>
                                                    </div>
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                        aria-label="Close"></button>

                                                </div>
                                            @endif
                                            <div class="d-flex justify-content-between">

                                                <h6 class="card-title">Langkah Design Thinking</h6>
                                                <div class="d-flex gap-3 mb-3">
                                                    <div>
                                                        <button class="btn btn-green rounded-1"></button> : Sedang
                                                        Berlangsung
                                                    </div>
                                                    <div>
                                                        <button class="btn btn-danger rounded-1"></button> : Sudah Lewat
                                                    </div>
                                                    <div>
                                                        <button class="btn btn-secondary rounded-1"></button> : Belum Mulai
                                                    </div>
                                                </div>

                                            </div>
                                            @foreach ($langkahData->skip(1)->take(8) as $langkah)
                                                @php
                                                    $now = now()->toDateString();
                                                    $isDisabled = $now < $langkah->mulai;
                                                    $isInProgress = $now >= $langkah->mulai && $now <= $langkah->sampai;

                                                    if ($isDisabled) {
                                                        $buttonClass = 'btn-secondary'; // Tombol abu-abu dan disabled
                                                    } else {
                                                        $buttonClass = $isInProgress ? 'btn-green' : 'btn-danger'; // Tombol hijau atau merah
                                                    }

                                                    $routeName =
                                                        $loop->iteration == 1
                                                            ? 'formAbsensiDt'
                                                            : 'formAbsensiDt' . $loop->iteration;
                                                @endphp
                                                <button onclick="window.location.href='{{ route($routeName) }}'"
                                                    class="btn {{ $buttonClass }} col-1" type="button"
                                                    {{ $isDisabled ? 'disabled' : '' }}>L{{ $loop->iteration }}</button>
                                            @endforeach
                                            @php
                                                // Assuming $langkahData is ordered by "mulai" in ascending order
                                                $latestLangkah = $langkahData->last();
                                                $isDisabledNQI =
                                                    now()->toDateString() < $latestLangkah->mulai ||
                                                    now()->toDateString() > $latestLangkah->sampai;
                                            @endphp
                                            <button onclick="window.location.href='{{ route('formAbsensiDt9') }}'"
                                                class="btn {{ $isDisabledNQI ? 'btn-secondary' : 'btn-primary' }} col-md-1 col-2"
                                                {{ $isDisabledNQI ? 'disabled' : '' }}>NQI</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Tampilkan pesan atau konten yang sesuai jika NPK pengguna tidak terdaftar sebagai npk_leader -->
                            <i class="text-danger">Anda tidak memilih kategori ini...</i>
                        @endif
                    @else
                        <!-- Tampilkan pesan atau konten yang sesuai jika NPK pengguna tidak terdaftar sebagai npk_leader -->
                        <i class="text-danger">Anda belum registrasi circle untuk periode ini, Silahkan register terlebih
                            dahulu...</p>
                    @endif
                @else
                    <i class="text-danger">Periode sudah berakhir, tunggu periode berikutnya...</i>
                @endif
            @else
                <i class="text-danger">Periode belum dibuat...</i>
            @endif
        </div>
    </div>
@endsection
