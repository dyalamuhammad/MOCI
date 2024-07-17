@extends('layouts/main')
@section('script')
    <script src="assets/js/vendor-all.min.js"></script>
    <script src="assets/js/plugins/bootstrap.min.js"></script>
    <script src="assets/js/pcoded.min.js"></script>
    <script>
        // Set waktu timeout sesi dalam milidetik (misal: 15 menit)
        const sessionTimeout = 5 * 60 * 10000; // 15 menit dalam milidetik

        // Fungsi untuk logout otomatis
        function autoLogout() {
            window.location.href = '{{ route('doLogout') }}'; // Ganti dengan URL halaman logout Anda
        }
        setTimeout(autoLogout, sessionTimeout);
    </script>


    <script>
        $(document).on('click', '.kontak', function(e) {
            e.preventDefault();
            $("#modal-edit").modal('show');
            $.post('../proses/dashboard/ajax/info.php', {
                    id: $(this).attr('data-id'), //id prop                
                },
                function(html) {
                    $("#data-edit").html(html);
                }
            );
        });
    </script>

    <script>
        $(document).on('click', '.reason', function() {
            var reason = $(this).attr('data-reason');
            var noia = $(this).attr('data-noia');
            Swal.fire({
                title: '<strong></strong>' + noia,
                icon: 'info',
                html: '' + reason,
                showCloseButton: true,
                focusConfirm: false,
                confirmButtonText: '<i">Laporan Diterima !!</i>',
                cancelButtonAriaLabel: 'Close'
            })
        })
        $(document).on('click', '.noedit', function() {
            $(this).removeAttr('href');
            Swal.fire({
                title: '<strong>NOTULEN SUDAH UPLOAD</strong>',
                icon: 'warning',
                html: 'Silahkan Upload langkah berikutnya',
                showCloseButton: true,
                focusConfirm: false,
                confirmButtonText: '<i">Laporan Diterima !!</i>',
                cancelButtonAriaLabel: 'Close'
            })
        })
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
                                <h5 class="m-b-10">Absensi CBI</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="bi bi-house"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('absensiCbi') }}">Absensi CBI</a></li>
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
                        ->where('category', 'CBI')
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
                                            <h5 class="text-white">Absensi Kehadiran CBI</h5>
                                            <span class="d-block m-t-5">Hello Sahabat Silahkan Pilih Langkah CBI dibawah ini
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

                                                <h6 class="card-title">Langkah CBI</h6>
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
                                                            ? 'formAbsensiCbi'
                                                            : 'formAbsensiCbi' . $loop->iteration;
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
                                            <button onclick="window.location.href='{{ route('formAbsensiCbi9') }}'"
                                                class="btn {{ $isDisabledNQI ? 'btn-secondary' : 'btn-green' }} col-md-1 col-2"
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
        @endsection
