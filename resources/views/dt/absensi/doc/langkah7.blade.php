@extends('layouts.main')

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

    <script>
        function downloadPDF2() {
            const element = document.querySelector('.card-body');
            const opt = {
                margin: 0,
                filename: 'notulen_dt_l7.pdf', // Nama file PDF yang diunduh
                image: {
                    type: 'jpeg',
                    quality: 1
                },
                html2canvas: {
                    scale: 5
                },
                jsPDF: {
                    unit: 'in',
                    format: 'letter',
                    orientation: 'portrait'
                }
            };
            html2pdf().set(opt).from(element).save();
        }
    </script>
    <script>
        $(document).ready(function() {
            // Mengambil CSRF token dari meta tag
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $('.approve-btn').click(function() {
                // Mendapatkan ID dari tombol yang diklik
                var circleId = $(this).data('id');
                console.log("Circle ID:", circleId);

                // Konfirmasi tindakan
                if (confirm('Anda yakin ingin approve?')) {
                    // Lakukan permintaan AJAX untuk mengubah nilai di server
                    $.ajax({
                        url: '{{ route('approveDt7', ['id' => $circle->id]) }}',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken // Menambahkan CSRF token ke header
                        },
                        data: {
                            circleId: circleId,
                        },
                        success: function(response) {
                            console.log(response);
                            // Handle respons sesuai kebutuhan
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            // Handle error jika diperlukan
                        }
                    });
                }
            });
        });
    </script>
    <script>
        // Menangani klik tombol approve
        document.querySelector('.approve-btn').addEventListener('click', function() {
            var memberId = this.getAttribute('data-id');
            console.log(memberId);

            // Kirim permintaan Ajax untuk menyetujui circle
            $.ajax({
                url: '{{ route('approveDt7', ['id' => $circle->id]) }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken // Menambahkan CSRF token ke header
                },
                data: {
                    memberId: memberId,

                },
                success: function(response) {
                    console.log(response);
                    // Tambahkan logika atau tindakan tambahan di sini jika diperlukan
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    </script>
    <script>
        // Ambil elemen yang akan dipindahkan ke halaman berikutnya
        var element = document.querySelector('.');

        // Fungsi untuk memeriksa apakah ada ruang yang cukup pada halaman saat ini
        function isSpaceAvailable() {
            var currentHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
            var bodyHeight = document.body.clientHeight;
            var scrollPosition = window.scrollY || window.pageYOffset || document.documentElement.scrollTop;
            var remainingSpace = bodyHeight - scrollPosition - currentHeight;
            return remainingSpace > 500; // Sesuaikan angka 100 dengan margin yang diinginkan
        }

        // Fungsi untuk memindahkan elemen ke halaman berikutnya jika tidak ada ruang yang cukup
        function moveToNextPageIfNeeded() {
            if (!isSpaceAvailable()) {
                var newPage = document.createElement('div');
                newPage.style.pageBreakBefore = 'always';
                document.body.appendChild(newPage);
                newPage.appendChild(element);
            }
        }

        // Panggil fungsi untuk memindahkan elemen jika diperlukan saat halaman dimuat
        window.onload = moveToNextPageIfNeeded;
    </script>
@endsection
@section('content')
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            @include('alert')
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">Notulen Langkah 5</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="bi bi-house"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('monitorDt') }}">Monitor DT</a></li>
                                <li class="breadcrumb-item"><a href="">Detail Circle</a></li>
                                <li class="breadcrumb-item"><a href="#">Notulen</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="card">
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-success col-4 col-lg-2 text-center my-3 mb-md-3 px-0"
                            onclick="downloadPDF2()"><i class="bi bi-download me-2"></i>Download</button>
                    </div>

                    <div class="card-body p-1 p-md-3">
                        <div class="d-flex justify-content-between">
                            <img src="{{ asset('assets/images/adm.png') }}" alt="" height="40px">
                            <p class="text-end fw-bold text-dark">2024 <br>PT ASTRA DAIHATSU MOTOR</p>
                        </div>
                        <div class="d-flex justify-content-between border border-dark border-start-0 border-end-0 mb-2 p-2">
                            <h4 class="my-auto">NOTULEN DT</h4>
                            <h6 class="text-end text-dark my-auto">LANGKAH 4 - PROTOTYPE</h6>
                        </div>
                        <div class="mb-2 ">
                            <label for="nama">Nama Circle</label>
                            <input type="text" class="form-control" name="circle_name" value="{{ $circleName ?? '' }}"
                                readonly>
                        </div>
                        <div class="mb-2 ">
                            <label for="nama">Judul DT</label>
                            <input type="text" class="form-control" name="circle_name" value="{{ $judulNotulen ?? '' }}"
                                readonly>
                        </div>
                        <div class="row mb-2 ">
                            <div class="col-4">
                                <label for="nama">Departemen</label>
                                <input type="text" class="form-control" name="circle_name" value="{{ $deptName }}"
                                    readonly>
                            </div>
                            <div class="col-4">
                                <label for="nama">Tema Leader</label>
                                <input type="text" class="form-control" name="circle_name"
                                    value="{{ $leaderName ?? '' }}" readonly>
                            </div>
                            <div class="col-4">
                                <label for="nama">Fasilitator</label>
                                <input type="text" class="form-control text-capitalize" name="circle_name"
                                    value="{{ $nama_cord ?? '' }}" readonly>
                            </div>
                        </div>
                        <div class="mb-2 ">
                            <label for="nama">Absensi Anggota</label>
                            <table class="table table-borderless">
                                <tr class="text-light">
                                    <th class="col-1 bg-green text-light fs-7">NPK</th>
                                    <th class="bg-green text-light fs-7">NAMA</th>
                                    <th class="text-center col-2 bg-green text-light fs-7">KETERANGAN</th>
                                </tr>
                                @foreach ($members as $item)
                                    <tr class="table-success">
                                        <td colspan="1" class="fs-7">{{ $item->npk_anggota }}</td>
                                        <td colspan="1" class="text-capitalize fs-7">@php
                                            $user = \App\Models\User::where('npk', $item->npk_anggota)->first();
                                        @endphp
                                            {{ $user->name ?? '' }}</td>
                                        <td colspan="1" class="text-center fs-7">
                                            @if ($item->l7 == 1)
                                                HADIR
                                            @else
                                                TIDAK HADIR
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>

                        <div class="mb-2 ">
                            <label for="">Customer Feedback</label>
                            <table class="table table-bordered border-light rounded-3 border-2">
                                <tr>
                                    <th class="table-success col-1">Item</th>
                                    <th class="table-success">Detail</th>
                                </tr>
                                <tr>
                                    <td>Hal Yang Disukai</td>
                                    <td class="">
                                        <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." rows="2">{{ $suka }}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Hal Yang Dapat Ditingkatkan</td>
                                    <td class="">
                                        <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." rows="2"> {{ $tingkatkan }}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Ide Baru Yang Dapat Dipertimbangkan</td>
                                    <td class="">
                                        <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." rows="2">{{ $pertimbangkan }}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Hal Yang Tidak Dimengerti</td>
                                    <td class="">
                                        <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." rows="2">{{ $tidak_mengerti }}</textarea>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="mb-2 ">
                            <label for="">Learning Card</label>
                            <div class="mb-3">
                                <label for="">Nama Improvement</label>
                                <textarea type="text" class="form-control" placeholder="Isi Disini..." rows="2" readonly>{{ $nama_improve }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="">Nama Persona</label>
                                <textarea type="text" class="form-control" placeholder="Isi Disini..." rows="2" readonly>{{ $nama_persona }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="">Tanggal Uji</label>
                                <textarea type="text" class="form-control" placeholder="Isi Disini..." rows="2" readonly>{{ $tanggal_uji }}</textarea>
                            </div>
                            <table class="table table-bordered border-light rounded-3 border-2">
                                <tr>
                                    <th class="table-success col-1">Item</th>
                                    <th class="table-success">Detail</th>
                                </tr>
                                <tr>
                                    <td>Hypotesis</td>
                                    <td class="">
                                        <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." rows="2">{{ $hypotesis }}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Observation</td>
                                    <td class="">
                                        <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." rows="2">{{ $observation }}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Learning & Insights</td>
                                    <td class="">
                                        <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." rows="2">{{ $learning }}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Decisions & Actions</td>
                                    <td class="">
                                        <textarea type="text" class="form-control border-0" placeholder="Isi Disini..." rows="2">{{ $decision }}</textarea>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        @if ($iterasi == 'Tidak Mengisi')
                            <p>Tidak Mengisi Iterasi</p>
                        @else
                            <div class="mb-2 ">
                                <label for="nama">Story Before</label>
                                <table class="table table-borderless">
                                    <tr class="text-light">
                                        <th class="col-1 bg-green text-light fs-7">STEP</th>
                                        <th class="bg-green text-light fs-7">DETAIL</th>
                                    </tr>
                                    @foreach ($storyBefores as $item)
                                        <tr class="table-success">
                                            <td>{{ $item->step }}</td>
                                            <td>{{ $item->detail }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                            <div class="mb-2 ">
                                <label for="nama">Story After</label>
                                <table class="table table-borderless">
                                    <tr class="text-light">
                                        <th class="col-1 bg-green text-light fs-7">STEP</th>
                                        <th class="bg-green text-light fs-7">DETAIL</th>
                                    </tr>
                                    @foreach ($storyAfters as $item)
                                        <tr class="table-success">
                                            <td>{{ $item->step }}</td>
                                            <td>{{ $item->detail }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                            <div class="mb-2 ">
                                <label for="nama">Foto Improvement</label>
                                <img src="{{ asset($foto) }}" alt="" width="350px" class="d-block rounded-1">
                            </div>
                        @endif
                        @if ($comment)
                            <div class="mb-2 ">
                                <label for="nama">Feedback Fasilitator</label>
                                <textarea id="comment" class="form-control text-wrap" name="comment" readonly>{{ $comment ?? '' }}</textarea>

                            </div>
                        @endif
                    </div>
                    @if (auth()->user()->jabatan == 'FRM')
                        <div class="d-flex justify-content-center gap-2">
                            <button
                                class="btn btn-outline-primary col-4 col-lg-1 text-center my-3 mb-md-3 px-0 approve-btn"
                                data-id="{{ $circle->id }}"><i class="bi bi-check-circle me-2"
                                    onclick="window.location.href='{{ route('monitorQcc') }}'"></i>Approve</button>
                            <button class="btn btn-outline-primary col-4 col-lg-auto text-center my-3 mb-md-3 px-2"
                                data-bs-target="#exampleModal" data-bs-toggle="modal" data-id="{{ $circle->id }}"><i
                                    class="bi
                                bi-check-circle me-2"></i>Approve With
                                Comment</button>
                        </div>
                    @endif
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Approve With Comment</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <form method="POST" action="{{ route('approveCommentDt7') }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="circle_id" value="{{ $circleId }}">
                                        <input type="hidden" name="notulen_id" value="{{ $notulenId }}">
                                        <textarea name="comment" id="" cols="30" rows="10" class="form-control mb-3"
                                            placeholder="Isi Comment Disini..." required></textarea>

                                        <button type="submit" class="btn btn-primary col-12">SUBMIT</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    @endsection