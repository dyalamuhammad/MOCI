@extends('layouts.main')
@section('script')
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>

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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.2/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.2/FileSaver.min.js"></script>

    <script>
        function exportTableToExcel(tableID, filename = '') {
            var table = document.getElementById(tableID);

            // Clone the table
            var clonedTable = table.cloneNode(true);

            // Remove "No" and "Preview" columns
            for (var i = 0; i < clonedTable.rows.length; i++) {
                clonedTable.rows[i].deleteCell(0); // Remove the first cell (No column)
                clonedTable.rows[i].deleteCell(clonedTable.rows[i].cells.length -
                    1); // Remove the last cell (Preview column)
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
                                <h5 class="m-b-10">Monitor Design Thinking</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href=""><i class="bi bi-house"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('monitorDt') }}">Monitor DT</a></li>
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
                    @if ($userRole != 'Superadmin' or $userRole != 'frm' or $npkLeaderExists)
                        @if ($userRole != 'Superadmin' or $userRole != 'frm' or $npkLeaderCategory)
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-header bg-darkBlue text-white">
                                            <h5 class="text-white">Monitoring Keaktifan Circle</h5>
                                            <span class="d-block">Hallo sahabat Berikut data monitoring keaktifan
                                                circle</span>
                                        </div>
                                        <div class="card-body table-border-style">
                                            <div class="d-flex justify-content-between gap-1 mb-3">
                                                <div class="">
                                                    <button class="btn btn-outline-green w-100"
                                                        onclick="exportTableToExcel('dt-table', 'dt-data')">Export</button>
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
                                                    <form action="{{ route('monitorDt') }}" method="GET" class="w-100"
                                                        id="search-form">
                                                        <div class="input-group">
                                                            <input type="text" name="search" class="form-control"
                                                                placeholder="Cari Nama Circle atau NPK Leader"
                                                                value="{{ $search }}">
                                                            <input type="hidden" id="filter-input" name="filter"
                                                                value="{{ request()->query('filter', '') }}">
                                                            <button type="submit" class="btn btn-primary">Cari</button>
                                                        </div>
                                                    </form>
                                                </div>

                                                <div class="d-flex gap-3 my-auto">
                                                    <div><i class="bi bi-clock-history fs-5 text-warning"></i>
                                                        <li class="list-group-item d-inline align-top">: Menunggu
                                                            Approve</li>
                                                    </div>
                                                    <div><i class="bi bi-check2-all fs-5 text-success me-1 align-top"></i>
                                                        <li class="list-group-item d-inline align-top">: Sudah
                                                            Approve</li>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table" id="dt-table">
                                                    <tr class="table-primary">
                                                        <th>No</th>
                                                        <th>Circle</th>
                                                        <th>Npk Tema Leader</th>
                                                        <th>Nama Tema Leader</th>
                                                        <th>Dept</th>
                                                        <th>SPV</th>
                                                        <th>Fasilitator</th>
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
                                                    @foreach ($showCircle as $item)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $item->name }}</td>
                                                            <td>{{ $item->npk_leader }}</td>
                                                            <td>{{ $item->leader }}</td>
                                                            <td>@php
                                                                $org = \App\Models\Org::where(
                                                                    'npk',
                                                                    $item->npk_leader,
                                                                )->first();
                                                                $deptName = $org
                                                                    ? \App\Models\Departemen::where(
                                                                        'id_dept',
                                                                        $org->dept,
                                                                    )->value('dept')
                                                                    : 'Tidak ada departemen';
                                                                echo $deptName;
                                                            @endphp</td>
                                                            <td>@php
                                                                $spvNpk = $org
                                                                    ? \App\Models\Section::where(
                                                                        'id_section',
                                                                        $org->sect,
                                                                    )->value('npk_cord')
                                                                    : 'Tidak ada section';
                                                                $spvName = \App\Models\User::where(
                                                                    'npk',
                                                                    $spvNpk,
                                                                )->value('name');
                                                                echo $spvName;
                                                            @endphp</td>
                                                            <td>@php
                                                                $frmNpk = $org
                                                                    ? \App\Models\Group::where(
                                                                        'id_group',
                                                                        $org->grp,
                                                                    )->value('npk_cord')
                                                                    : 'Tidak ada section';
                                                                $frmName = \App\Models\User::where(
                                                                    'npk',
                                                                    $frmNpk,
                                                                )->value('name');

                                                                echo $frmName;
                                                            @endphp</td>
                                                            <td class="py-0 align-middle">
                                                                @if ($item->l1 == 1)
                                                                    <i class="bi bi-clock-history fs-4 text-warning"></i>
                                                                    <p class="d-none">Menunggu Approve</p>
                                                                @elseif($item->l1 == 2)
                                                                    <i class="bi bi-check2-all fs-4 text-success"></i>
                                                                    <p class="d-none">Sudah Approve</p>
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                            <td class="py-0 align-middle">
                                                                @if ($item->l2 == 1)
                                                                    <i class="bi bi-clock-history fs-4 text-warning"></i>
                                                                    <p class="d-none">Menunggu Approve</p>
                                                                @elseif($item->l2 == 2)
                                                                    <i class="bi bi-check2-all fs-4 text-success"></i>
                                                                    <p class="d-none">Sudah Approve</p>
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                            <td class="py-0 align-middle">
                                                                @if ($item->l3 == 1)
                                                                    <i class="bi bi-clock-history fs-4 text-warning"></i>
                                                                    <p class="d-none">Menunggu Approve</p>
                                                                @elseif($item->l3 == 2)
                                                                    <i class="bi bi-check2-all fs-4 text-success"></i>
                                                                    <p class="d-none">Sudah Approve</p>
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                            <td class="py-0 align-middle">
                                                                @if ($item->l4 == 1)
                                                                    <i class="bi bi-clock-history fs-4 text-warning"></i>
                                                                    <p class="d-none">Menunggu Approve</p>
                                                                @elseif($item->l4 == 2)
                                                                    <i class="bi bi-check2-all fs-4 text-success"></i>
                                                                    <p class="d-none">Sudah Approve</p>
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                            <td class="py-0 align-middle">
                                                                @if ($item->l5 == 1)
                                                                    <i class="bi bi-clock-history fs-4 text-warning"></i>
                                                                    <p class="d-none">Menunggu Approve</p>
                                                                @elseif($item->l5 == 2)
                                                                    <i class="bi bi-check2-all fs-4 text-success"></i>
                                                                    <p class="d-none">Sudah Approve</p>
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                            <td class="py-0 align-middle">
                                                                @if ($item->l6 == 1)
                                                                    <i class="bi bi-clock-history fs-4 text-warning"></i>
                                                                    <p class="d-none">Menunggu Approve</p>
                                                                @elseif($item->l6 == 2)
                                                                    <i class="bi bi-check2-all fs-4 text-success"></i>
                                                                    <p class="d-none">Sudah Approve</p>
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                            <td class="py-0 align-middle">
                                                                @if ($item->l7 == 1)
                                                                    <i class="bi bi-clock-history fs-4 text-warning"></i>
                                                                    <p class="d-none">Menunggu Approve</p>
                                                                @elseif($item->l7 == 2)
                                                                    <i class="bi bi-check2-all fs-4 text-success"></i>
                                                                    <p class="d-none">Sudah Approve</p>
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                            <td class="py-0 align-middle">
                                                                @if ($item->l8 == 1)
                                                                    <i class="bi bi-clock-history fs-4 text-warning"></i>
                                                                    <p class="d-none">Menunggu Approve</p>
                                                                @elseif($item->l8 == 2)
                                                                    <i class="bi bi-check2-all fs-4 text-success"></i>
                                                                    <p class="d-none">Sudah Approve</p>
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                            <td class="py-0 align-middle">
                                                                @if ($item->nqi == 1)
                                                                    <i class="bi bi-clock-history fs-4 text-warning"></i>
                                                                    <p class="d-none">Menunggu Approve</p>
                                                                @elseif($item->nqi == 2)
                                                                    <i class="bi bi-check2-all fs-4 text-success"></i>
                                                                    <p class="d-none">Sudah Approve</p>
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>


                                                            <td class="text-center">
                                                                <button class="btn btn-sm btn-green"
                                                                    onclick="window.location='{{ route('detailCircleDt', ['circle_id' => $item->id]) }}'"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    data-bs-title="Lihat Notulen">Lihat</button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                                @if ($userRole != 'TL')
                                                    <div class="pagination justify-content-between">
                                                        <ul class="pagination button w-100">
                                                            <!-- Tombol Previous tidak ditampilkan -->
                                                            <li class="page-item disabled mx-1">
                                                                <a class="btn btn-outline-primary"
                                                                    href="{{ $showCircle->appends(['search' => $search, 'filter' => $filter])->previousPageUrl() }}">Previous</a>
                                                            </li>

                                                            <!-- Tombol Next -->
                                                            @if ($showCircle->hasMorePages())
                                                                <li class="page-item">
                                                                    <a class="btn btn-outline-primary"
                                                                        href="{{ $showCircle->appends(['search' => $search, 'filter' => $filter])->nextPageUrl() }}"
                                                                        rel="next" aria-label="Next">Next</a>
                                                                </li>
                                                            @else
                                                                <li class="page-item disabled">
                                                                    <span class="btn btn-outline-primary disabled"
                                                                        aria-disabled="true" aria-label="Next">Next</span>
                                                                </li>
                                                            @endif
                                                            <li class="mx-5 align-content-center me-1 ms-5">
                                                                Showing {{ $showCircle->count() }} of
                                                                {{ $showCircle->total() }}
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
