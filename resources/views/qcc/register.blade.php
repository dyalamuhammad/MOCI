@extends('layouts/main')
@section('script')
    <script>
        $(document).ready(function() {
            $('#npk').on('input', function() {
                var npk = $(this).val();
                if (npk) {
                    $.ajax({
                        url: '/karyawan/' + npk,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            if (data) {
                                $('#name_leader').val(data
                                    .name); // Assuming the field ID is 'nama_karyawan'
                            } else
                            if (data) {
                                $('#name_leader').val(data
                                    .name); // Assuming the field ID is 'nama_karyawan'
                            } else {
                                $('#name_leader').val(
                                    'Tidak ditemukan...'); // Clear the field if no data found
                            }
                        }
                    });
                } else {
                    $('#name_leader').val(''); // Clear the field if NPK field is empty
                }
            });
        });
    </script>


    <!-- Add this to your blade/view file -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>



    <script>
        $(document).ready(function() {
            var maxMembers = 16; // Jumlah maksimal anggota, termasuk leader
            var minMembers = 3; // Jumlah minimal anggota, tidak termasuk leader
            var memberCount = 1; // Jumlah anggota awal, sudah termasuk leader

            // Kemudian gunakan variabel memberCount di sini

            // Fungsi untuk menambahkan input field anggota baru
            function addMemberField() {
                if (memberCount < maxMembers) {

                    var html = '<div class="form-group col-6">';
                    html += '<label for="member' + memberCount + '">Anggota ' + (memberCount) + '</label>';
                    html += '<div class="input-group">';
                    html += '<input type="text" class="form-control" id="member' + memberCount +
                        '" name="npkMembers[]" required placeholder="NPK Anggota">';
                    html += '<input type="text" class="form-control col-6" id="name_anggota' + memberCount +
                        '" name="members[]" readonly>';
                    html += '<button type="button" class="btn btn-outline-danger btn-remove" data-member="' +
                        memberCount + '"><i class="bi bi-x-lg"></i></button>';
                    html += '</div>';
                    html += '</div>';


                    $('#members').append(html);
                    memberCount++;
                }
            }

            // Tambahkan input field anggota secara otomatis saat halaman dimuat
            addMemberField();
            addMemberField();
            addMemberField();

            // Handler saat tombol tambah anggota diklik
            $('#add-member-btn').click(function() {
                addMemberField();
            });

            // Handler saat tombol remove anggota diklik
            $(document).on('click', '.btn-remove', function() {
                var memberIndex = $(this).data('member');
                $('#member' + memberIndex).closest('.form-group').remove();
                memberCount--;
            });

            // Validasi jumlah anggota sebelum form disubmit
            $('form').submit(function(e) {
                var totalMembers = memberCount + 1; // Total anggota termasuk leader
                if (totalMembers < minMembers) {
                    alert('Minimum ' + minMembers + ' members required.');
                    e.preventDefault(); // Menghentikan pengiriman form
                }
            });

            $(document).on('keyup', '[id^="member"]', function() {
                var memberId = $(this).attr('id').replace('member', '');
                var npkValue = $(this).val();
                $.ajax({
                    url: '/karyawan/' + npkValue,
                    method: 'GET',
                    success: function(response) {
                        if (response.name) {
                            $('#name_anggota' + memberId).val(response.name);
                        } else {
                            // NPK tidak ditemukan, kosongkan input nama
                            $('#name_anggota' + memberId).val('');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        // Handle error
                    }
                });
            });
        });
    </script>
@endsection
@section('content')


    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>


    <!-- [ Main Content ] start -->
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            @include('alert')
            <!-- Tampilkan konten lainnya -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">Register QCC</h5>
                                @php
                                    $activePeriode = \App\Models\Periode::where('status', 1)->first();
                                @endphp
                            </div>
                            {{-- @if (isset($periodes))
    <h5 class="m-b-10">Selamat datang di QCC periode {{ $activePeriode->periode }} , dengan tema {{ $activePeriode->tema }}</h5>
@else
    <h5 class="m-b-10">Selamat datang di QCC, tetapi tidak ada periode yang aktif saat ini.</h5>
@endif                         --}}
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="bi bi-house"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('registerQcc') }}">Register QCC</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            @if ($periode->count() > 0)
                @php
                    $activePeriode = \App\Models\Periode::where('status', 1)->first();
                @endphp


                @if (
                    $activePeriode &&
                        ($activePeriode->tanggal_akhir >= \Carbon\Carbon::now()->toDateString() &&
                            $activePeriode->tanggal_mulai <= \Carbon\Carbon::now()->toDateString()))
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-darkBlue text-white">
                                    <h5 class="text-white">Registrasi Circle QCC</h5>
                                    <span class="d-block">Halo sahabat silahkan lakukan registrasi circle</span>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('circles.store') }}">
                                        @csrf
                                        <div class="row">
                                            <div class="form-group col-6">
                                                <label for="name">Periode</label>
                                                <input type="text" class="form-control" id="periode" name="periode"
                                                    readonly value="{{ $activePeriode->periode }}">
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="name">Circle Name</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="row px-0">
                                            <label for="leader">Leader</label>
                                            <div class="input-group mb-3 col-6">
                                                <input type="text" class="form-control col-3" id="npk"
                                                    name="npk_leader" placeholder="NPK Leader"
                                                    value="{{ $npkLeader ?? '' }}" readonly>
                                                <input type="text" class="form-control col-3" id="name_leader"
                                                    name="leader" placeholder="Nama Leader" value="{{ $nameLeader ?? '' }}"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div id="members" class="row">
                                            <i class="text-danger" style="font-size: .8rem">minimal jumlah anggota 3 orang
                                                dan maksimal 9 orang</i>
                                            <!-- Input field for the leader already exists here -->
                                        </div>
                                        <button type="button" id="add-member-btn" class="btn btn-outline-primary">Add
                                            Member</button>
                                        <button type="submit" class="btn btn-success">Create Circle</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <i class="text-danger">Periode sudah berakhir, tunggu periode berikutnya...</i>
                @endif
            @else
                <i class="text-danger">Periode belum dibuat...</i>
            @endif <!-- [ breadcrumb ] start -->

        </div>
    </div>
@endsection
