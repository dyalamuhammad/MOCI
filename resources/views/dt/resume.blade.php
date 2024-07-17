@extends('layouts/main')
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.2/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.2/FileSaver.min.js"></script>

    <script>
        function setFilter(value) {
            let filterInput = document.getElementById('filter-input');
            filterInput.value = value;

            let form = document.getElementById('search-form');
            form.submit();
        }

        function setSearch(value) {
            updateQueryString('search', value);
        }

        function updateQueryString(key, value) {
            let url = new URL(window.location.href);
            let params = new URLSearchParams(url.search);

            // Set or update the query parameter
            if (value) {
                params.set(key, value);
            } else {
                params.delete(key); // Remove the parameter if no value is provided
            }

            // Update the form action to include the new query parameters
            let form = document.getElementById('search-form');
            form.action = url.pathname + '?' + params.toString();
        }
    </script>

    <script>
        function exportTableToExcel(tableID, filename = '') {
            var table = document.getElementById(tableID);

            // Clone the table
            var clonedTable = table.cloneNode(true);

            // Remove "No" and "Preview" columns
            for (var i = 0; i < clonedTable.rows.length; i++) {
                clonedTable.rows[i].deleteCell(0); // Remove the first cell (No column)
            }

            // Convert the cloned table to a workbook
            var wb = XLSX.utils.table_to_book(clonedTable, {
                sheet: "Sheet JS"
            });
            var wbout = XLSX.write(wb, {
                bookType: 'xlsx',
                type: 'binary'
            });

            function s2ab(s) {
                var buf = new ArrayBuffer(s.length);
                var view = new Uint8Array(buf);
                for (var i = 0; i < s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
                return buf;
            }

            saveAs(new Blob([s2ab(wbout)], {
                type: "application/octet-stream"
            }), filename + '.xlsx');
        }
    </script>
@endsection
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
                                <h5 class="m-b-10">Resume Absensi Design Thinking</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="bi bi-house"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('resumeDt') }}">Resume Absensi</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            @if ($periodes->count() > 0 and $activePeriode)

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
                    $userRole != 'Superadmin' or
                        $userRole != 'frm' or
                        $activePeriode &&
                            ($activePeriode->tanggal_akhir >= \Carbon\Carbon::now()->toDateString() &&
                                $activePeriode->tanggal_mulai <= \Carbon\Carbon::now()->toDateString()))
                    @if ($userRole != 'Superadmin' or $userRole != 'frm' or $npkLeaderExists or $userRole === 'Superadmin')
                        @if ($userRole != 'Superadmin' or $userRole != 'frm' or $npkLeaderCategory)
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-header bg-darkBlue text-white">
                                            <h5 class="text-white">Monitoring Keaktifan Anggota</h5>
                                            <span class="d-block m-t-5">Hallo sahabat berikut resume absensi anggota
                                                setiap
                                                circle</span>
                                        </div>
                                        <div class="card-body table-border-style">
                                            <div class="d-flex justify-content-between gap-1 mb-3">
                                                <div class="">
                                                    <button class="btn btn-outline-green w-100"
                                                        onclick="exportTableToExcel('resume-dt-table', 'resume-dt-data')">Export</button>
                                                </div>
                                                <div class="d-flex gap-1 col-6">
                                                    <div class="dropdown">
                                                        <button
                                                            class="btn btn-light border-dark text-uppercase col-12 text-left"
                                                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            {{ $filter == '' ? $activePeriode->periode : ucfirst($filter) }}
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item px-0" href="#"
                                                                    onclick="setFilter('all')">All</a>
                                                            </li>
                                                            @foreach ($periodes as $item)
                                                                <li><a class="dropdown-item px-0" href="#"
                                                                        onclick="setFilter({{ $item->periode }})">{{ $item->periode }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    <form action="{{ route('resumeDt') }}" method="GET" class="w-100"
                                                        id="search-form">
                                                        <div class="input-group">
                                                            <input type="text" name="search" class="form-control"
                                                                placeholder="Cari Nama atau NPK"
                                                                value="{{ $search }}">
                                                            <input type="hidden" id="filter-input" name="filter"
                                                                value="{{ request()->query('filter', '') }}">
                                                            <button type="submit" class="btn btn-primary">Cari</button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="d-flex gap-3">
                                                    <div><i class="bi bi-check2-all fs-5 text-success me-1 align-top"></i>
                                                        <li class="list-group-item d-inline align-top">: Hadir</li>
                                                    </div>
                                                    <div><i class="bi bi-dash fs-5"></i>
                                                        <li class="list-group-item d-inline align-top">: Tidak Hadir</li>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="table-responsive">

                                                <table class="table table-hover rounded-3" id="resume-dt-table">

                                                    <tr class="table-primary">
                                                        <th class="col-1">No</th>
                                                        <th class="col-1">NPK</th>
                                                        <th class="col-1">Nama</th>
                                                        <th class="col-1">Circle</th>
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
                                                    @if ($members)
                                                        @php
                                                            $groupedMembers = $members->groupBy('circle_id');
                                                            $i = 1;
                                                        @endphp
                                                        @foreach ($groupedMembers as $circleId => $circleMembers)
                                                            @php
                                                                $circle = \App\Models\CircleDt::find($circleId);
                                                                $teamLeader = \App\Models\User::find($circle->leader);
                                                            @endphp

                                                            <!-- Display Team Leader -->
                                                            <tr class="align-middle">
                                                                <td class="align-middle">{{ $i }}</td>
                                                                <td class="align-middle">{{ $circle->npk_leader }}</td>
                                                                <td class="align-middle">
                                                                    {{ $circle->leader }}

                                                                </td>
                                                                <td class="align-middle">{{ $circle->name }}</td>
                                                                <td class="align-middle py-0">
                                                                    @if ($circle->l1 >= 1)
                                                                        <i class="bi bi-check2-all fs-4 text-success"></i>
                                                                    @else
                                                                        <i>-</i>
                                                                    @endif
                                                                </td>
                                                                <td class="align-middle py-0">
                                                                    @if ($circle->l2 >= 1)
                                                                        <i class="bi bi-check2-all fs-4 text-success"></i>
                                                                    @else
                                                                        <i>-</i>
                                                                    @endif
                                                                </td>
                                                                <td class="align-middle py-0">
                                                                    @if ($circle->l3 >= 1)
                                                                        <i class="bi bi-check2-all fs-4 text-success"></i>
                                                                    @else
                                                                        <i>-</i>
                                                                    @endif
                                                                </td>
                                                                <td class="align-middle py-0">
                                                                    @if ($circle->l4 >= 1)
                                                                        <i class="bi bi-check2-all fs-4 text-success"></i>
                                                                    @else
                                                                        <i>-</i>
                                                                    @endif
                                                                </td>
                                                                <td class="align-middle py-0">
                                                                    @if ($circle->l5 >= 1)
                                                                        <i class="bi bi-check2-all fs-4 text-success"></i>
                                                                    @else
                                                                        <i>-</i>
                                                                    @endif
                                                                </td>
                                                                <td class="align-middle py-0">
                                                                    @if ($circle->l6 >= 1)
                                                                        <i class="bi bi-check2-all fs-4 text-success"></i>
                                                                    @else
                                                                        <i>-</i>
                                                                    @endif
                                                                </td>
                                                                <td class="align-middle py-0">
                                                                    @if ($circle->l7 >= 1)
                                                                        <i class="bi bi-check2-all fs-4 text-success"></i>
                                                                    @else
                                                                        <i>-</i>
                                                                    @endif
                                                                </td>
                                                                <td class="align-middle py-0">
                                                                    @if ($circle->l8 >= 1)
                                                                        <i class="bi bi-check2-all fs-4 text-success"></i>
                                                                    @else
                                                                        <i>-</i>
                                                                    @endif
                                                                </td>
                                                                <td class="align-middle py-0">
                                                                    @if ($circle->nqi >= 1)
                                                                        <i class="bi bi-check2-all fs-4 text-success"></i>
                                                                    @else
                                                                        <i>-</i>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            @php
                                                                $i++;
                                                            @endphp
                                                            @foreach ($circleMembers as $item)
                                                                <tr class="align-middle">
                                                                    <td class="align-middle">{{ $i }}</td>
                                                                    @php
                                                                        $circle = \App\Models\CircleDt::find(
                                                                            $item->circle_id,
                                                                        );
                                                                        $circleMember = $circle->name;
                                                                    @endphp
                                                                    <td class="align-middle">{{ $item->npk_anggota }}</td>
                                                                    <td class="align-middle">@php
                                                                        $user = \App\Models\User::where(
                                                                            'npk',
                                                                            $item->npk_anggota,
                                                                        )->first();
                                                                    @endphp
                                                                        {{ $user->name ?? '' }}
                                                                    </td>
                                                                    <td class="align-middle">{{ $circleMember }}</td>

                                                                    <td class="align-middle py-0">
                                                                        @if ($item->l1 >= 1)
                                                                            <i
                                                                                class="bi bi-check2-all fs-4 text-success"></i>
                                                                            <p class="d-none">Sudah Approve</p>
                                                                        @else
                                                                            -
                                                                        @endif
                                                                    </td>
                                                                    <td class="align-middle py-0">
                                                                        @if ($item->l2 >= 1)
                                                                            <i
                                                                                class="bi bi-check2-all fs-4 text-success"></i>
                                                                            <p class="d-none">Sudah Approve</p>
                                                                        @else
                                                                            -
                                                                        @endif
                                                                    </td>
                                                                    <td class="align-middle py-0">
                                                                        @if ($item->l3 >= 1)
                                                                            <i
                                                                                class="bi bi-check2-all fs-4 text-success"></i>
                                                                            <p class="d-none">Sudah Approve</p>
                                                                        @else
                                                                            -
                                                                        @endif
                                                                    </td>
                                                                    <td class="align-middle py-0">
                                                                        @if ($item->l4 >= 1)
                                                                            <i
                                                                                class="bi bi-check2-all fs-4 text-success"></i>
                                                                            <p class="d-none">Sudah Approve</p>
                                                                        @else
                                                                            -
                                                                        @endif
                                                                    </td>
                                                                    <td class="align-middle py-0">
                                                                        @if ($item->l5 >= 1)
                                                                            <i
                                                                                class="bi bi-check2-all fs-4 text-success"></i>
                                                                            <p class="d-none">Sudah Approve</p>
                                                                        @else
                                                                            -
                                                                        @endif
                                                                    </td>
                                                                    <td class="align-middle py-0">
                                                                        @if ($item->l6 >= 1)
                                                                            <i
                                                                                class="bi bi-check2-all fs-4 text-success"></i>
                                                                            <p class="d-none">Sudah Approve</p>
                                                                        @else
                                                                            -
                                                                        @endif
                                                                    </td>
                                                                    <td class="align-middle py-0">
                                                                        @if ($item->l7 >= 1)
                                                                            <i
                                                                                class="bi bi-check2-all fs-4 text-success"></i>
                                                                            <p class="d-none">Sudah Approve</p>
                                                                        @else
                                                                            -
                                                                        @endif
                                                                    </td>
                                                                    <td class="align-middle py-0">
                                                                        @if ($item->l8 >= 1)
                                                                            <i
                                                                                class="bi bi-check2-all fs-4 text-success"></i>
                                                                            <p class="d-none">Sudah Approve</p>
                                                                        @else
                                                                            -
                                                                        @endif
                                                                    </td>
                                                                    <td class="align-middle py-0">
                                                                        @if ($item->nqi >= 1)
                                                                            <i
                                                                                class="bi bi-check2-all fs-4 text-success"></i>
                                                                            <p class="d-none">Sudah Approve</p>
                                                                        @else
                                                                            -
                                                                        @endif
                                                                    </td>


                                                                </tr>
                                                                @php
                                                                    $i++;
                                                                @endphp
                                                            @endforeach
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td>Tidak ada member</td>
                                                        </tr>
                                                    @endif

                                                </table>
                                                @if ($userRole != 'TL')
                                                    <div class="pagination justify-content-between">
                                                        <ul class="pagination button w-100">
                                                            <!-- Tombol Previous tidak ditampilkan -->
                                                            <li class="page-item disabled mx-1">
                                                                <a class="btn btn-outline-primary"
                                                                    href="{{ $members->appends(['search' => $search, 'filter' => $filter])->previousPageUrl() }}">Previous</a>
                                                            </li>

                                                            <!-- Tombol Next -->
                                                            @if ($members->hasMorePages())
                                                                <li class="page-item">
                                                                    <a class="btn btn-outline-primary"
                                                                        href="{{ $members->appends(['search' => $search, 'filter' => $filter])->nextPageUrl() }}"
                                                                        rel="next" aria-label="Next">Next</a>
                                                                </li>
                                                            @else
                                                                <li class="page-item disabled">
                                                                    <span class="btn btn-outline-primary disabled"
                                                                        aria-disabled="true" aria-label="Next">Next</span>
                                                                </li>
                                                            @endif
                                                            <li class="mx-5 align-content-center me-1 ms-5">
                                                                Showing {{ $members->count() }} of
                                                                {{ $totalDisplayedRows }}
                                                            </li>
                                                        </ul>
                                                    </div>
                                                @endif
                                            </div>
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
