@extends('layouts.main')
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.15.6/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script>
        function setFilter(value) {
            let filterInput = document.getElementById('filter-input');
            filterInput.value = value;

            let form = document.getElementById('search-form');
            form.submit();
        }

        function setMonth(value) {
            let monthInput = document.getElementById('month-input');
            monthInput.value = value;

            let form = document.getElementById('search-form');
            form.submit();
        }

        function setYear(value) {
            let yearInput = document.getElementById('year-input');
            yearInput.value = value;

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
            var wb = XLSX.utils.table_to_book(table, {
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
    <script>
        async function exportTableToPDF(tableID, filename = '') {
            const {
                jsPDF
            } = window.jspdf;

            // Ambil elemen tabel
            var table = document.getElementById(tableID);

            // Gunakan html2canvas untuk menangkap konten tabel sebagai gambar
            const canvas = await html2canvas(table, {
                scale: 2
            });
            const imgData = canvas.toDataURL('image/png');

            // Buat dokumen jsPDF baru
            const pdf = new jsPDF('p', 'pt', 'a4');
            const imgProps = pdf.getImageProperties(imgData);
            const pdfWidth = pdf.internal.pageSize.getWidth();
            const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

            // Tinggi halaman PDF (tinggi A4 dikurangi margin)
            const pageHeight = pdf.internal.pageSize.getHeight();

            // Posisi y awal pada halaman pertama
            let y = 0;

            while (y < imgProps.height) {
                pdf.addImage(imgData, 'PNG', 0, -y, pdfWidth, pdfHeight);
                y += pageHeight;
                if (y < imgProps.height) {
                    pdf.addPage();
                }
            }

            // Simpan dokumen PDF
            pdf.save(filename + '.pdf');
        }
    </script>
    <script>
        document.getElementById('select-all').onclick = function() {
            let checkboxes = document.getElementsByName('ids[]');
            for (let checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        }
    </script>
@endsection

@section('content')
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
                                <h5 class="m-b-10">Sugestion System Rekap Bulanan</h5>
                            </div>

                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="bi bi-house"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('ssBulanan') }}">SS Bulanan</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-darkBlue text-white">
                            <h5 class="text-white">Sugestion System</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 row justify-content-between">
                                @if ($userRole == 'Superadmin')
                                    <div class="col-auto">
                                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal">
                                            Import Excel
                                        </button>
                                        <div class="modal fade" id="exampleModal" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Import SS
                                                            Bulanan
                                                        </h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <form method="POST" action="{{ route('importSsBulanan') }}"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="form-group">
                                                                <label for="bulan">Pilih Bulan:</label>
                                                                <select name="bulan" id="bulan"
                                                                    class="form-control mb-3" required>
                                                                    <option value="januari">Januari</option>
                                                                    <option value="februari">Februari</option>
                                                                    <option value="maret">Maret</option>
                                                                    <option value="april">April</option>
                                                                    <option value="mei">Mei</option>
                                                                    <option value="juni">Juni</option>
                                                                    <option value="juli">Juli</option>
                                                                    <option value="agustus">Agustus</option>
                                                                    <option value="september">September</option>
                                                                    <option value="oktober">Oktober</option>
                                                                    <option value="november">November</option>
                                                                    <option value="desember">Desember</option>
                                                                </select>
                                                                <label for="tahun">Tahun:</label>
                                                                <input type="number" id="tahun" name="tahun"
                                                                    class="form-control mb-3" required>
                                                                <label for="file">Choose Excel File:</label>
                                                                <input type="file" class="form-control" name="file"
                                                                    id="file" accept=".xlsx, .xls" required>
                                                                <p class="py-3"><a
                                                                        href="{{ route('downloadFormatSsBulanan') }}"
                                                                        class="link-dark link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover fs-6">Download
                                                                        Format</a></p>
                                                            </div>
                                                            <button type="submit"
                                                                class="btn btn-primary w-25">IMPORT</button>
                                                        </form>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="row col-auto">
                                    <div class="dropdown col-auto">
                                        <button class="btn btn-light border-dark col-auto text-left" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            {{ $month === '' ? 'Pilih Bulan' : ucfirst($month) }}
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item px-0" href="#" onclick="setMonth('')">All</a>
                                            </li>


                                            @foreach ($uniqueMonths as $item)
                                                <li><a class="dropdown-item px-0 text-capitalize" href="#"
                                                        onclick="setMonth('{{ $item }}')">{{ $item }}</a>
                                                </li>
                                            @endforeach

                                        </ul>
                                    </div>
                                    <div class="dropdown col-auto">
                                        <button class="btn btn-light border-dark col-auto text-left" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            {{ $year === '' ? 'Pilih Tahun' : ucfirst($year) }}
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item px-0" href="#" onclick="setYear('')">All</a>
                                            </li>


                                            @foreach ($uniqueYears as $item)
                                                <li><a class="dropdown-item px-0" href="#"
                                                        onclick="setYear('{{ $item }}')">{{ $item }}</a>
                                                </li>
                                            @endforeach

                                        </ul>
                                    </div>
                                    <div class="dropdown col-auto">
                                        <button class="btn btn-light border-dark col-auto text-left" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            {{ $filter === '' ? 'Pilih Status' : ucfirst($filter) }}
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item px-0" href="#"
                                                    onclick="setFilter('')">All</a>
                                            </li>
                                            <li><a class="dropdown-item px-0" href="#"
                                                    onclick="setFilter('finish')">Finish</a>
                                            </li>
                                            <li><a class="dropdown-item px-0" href="#"
                                                    onclick="setFilter('in progress')">In Progress</a>
                                            </li>
                                        </ul>
                                    </div>

                                    <form action="{{ route('ssBulanan') }}" method="GET" class="col-auto"
                                        id="search-form">
                                        <div class="input-group">
                                            <input type="text" name="search" class="form-control"
                                                placeholder="Cari Nama atau NPK" value="{{ $search }}">
                                            <input type="hidden" id="filter-input" name="filter"
                                                value="{{ request()->query('filter', '') }}">
                                            <input type="hidden" id="month-input" name="month"
                                                value="{{ request()->query('month', '') }}">
                                            <input type="hidden" id="year-input" name="year"
                                                value="{{ request()->query('year', '') }}">
                                            <button type="submit" class="btn btn-primary">Cari</button>
                                        </div>
                                    </form>
                                </div>

                                <div class="col-auto">
                                    <div class="dropdown">
                                        <button class="btn btn-light border-dark" type="button"
                                            data-bs-toggle="dropdown">Export</button>
                                        <ul class="dropdown-menu">
                                            <li><a href="#" class="dropdown-item"
                                                    onclick="exportTableToPDF('ssbulanan-table', 'ss-data')">Export
                                                    To
                                                    Pdf</a>
                                            </li>
                                            <li><a href="#" class="dropdown-item"
                                                    onclick="exportTableToExcel('ssbulanan-table', 'ssbulanan-data')">Export
                                                    To Excel</a></li>
                                        </ul>
                                    </div>
                                    {{-- <button class="btn btn-outline-green"
                                        onclick="exportTableToExcel('ssbulanan-table', 'ssbulanan-data')">EXPORT</button> --}}
                                </div>
                            </div>
                            <form id="delete-form" method="POST" action="{{ route('deleteSelected') }}">
                                @csrf
                                <table class="table table-responsive" id="ssbulanan-table">
                                    <tr class="table-success">
                                        <th>No</th>
                                        <th><input type="checkbox" id="select-all"></th>

                                        <th>NPK</th>
                                        <th class="col-6 px-6">Nama</th>
                                        <th class="col-6">Jabatan</th>
                                        <th class="col-3">Jalur</th>
                                        <th class="col-3">Shift</th>
                                        <th class="col-3">Dept</th>
                                        <th class="col-2">Foreman</th>
                                        <th class="col-2">Supervisor</th>
                                        <th class="col-2">Status</th>
                                        <th class="col-2">Bulan</th>
                                        <th class="col-2">Tahun</th>
                                        <th class="col-2">Jumlah SS</th>

                                    </tr>
                                    @if ($ssBulanan->isEmpty())
                                        <tr>
                                            <td class="text-center col-12" colspan="16">Tidak Ada Data</td>
                                        </tr>
                                    @else
                                        @php
                                            // Array untuk menyimpan kombinasi npk, bulan, dan tahun yang sudah ditampilkan
                                            $displayedCombinations = [];
                                            $counter = 1;
                                        @endphp
                                        @foreach ($ssBulanan as $item)
                                            @php
                                                $combination = $item->npk . '-' . $item->bulan . '-' . $item->tahun;
                                            @endphp
                                            @if (!in_array($combination, $displayedCombinations))
                                                <tr>
                                                    <td>{{ $counter }}</td>
                                                    <td><input type="checkbox" name="ids[]"
                                                            value="{{ $item->id }}">
                                                    </td>

                                                    <td>{{ $item->npk }}</td>
                                                    <td>
                                                        @php
                                                            $org = \App\Models\Org::where('npk', $item->npk)->first();
                                                            $name = \App\Models\User::where('npk', $item->npk)->value(
                                                                'name',
                                                            );

                                                            echo $name;
                                                        @endphp
                                                    </td>
                                                    <td>
                                                        @php
                                                            $jabatan = \App\Models\User::where(
                                                                'npk',
                                                                $item->npk,
                                                            )->value('jabatan');
                                                            echo $jabatan;
                                                        @endphp
                                                    </td>
                                                    <td>
                                                        @php
                                                            $groupName = $org
                                                                ? \App\Models\Group::where(
                                                                    'id_group',
                                                                    $org->grp,
                                                                )->value('nama_group')
                                                                : 'Tidak ada group';
                                                            echo $groupName;
                                                        @endphp
                                                    </td>
                                                    <td>
                                                        @php
                                                            $shift = \App\Models\User::where('npk', $item->npk)->value(
                                                                'shift',
                                                            );
                                                            echo $shift;
                                                        @endphp
                                                    </td>
                                                    <td>
                                                        @php
                                                            $deptName = $org
                                                                ? \App\Models\Departemen::where(
                                                                    'id_dept',
                                                                    $org->dept,
                                                                )->value('dept')
                                                                : 'Tidak ada departemen';
                                                            echo $deptName;
                                                        @endphp
                                                    </td>
                                                    <td>
                                                        @php
                                                            $frmNpk = $org
                                                                ? \App\Models\Group::where(
                                                                    'id_group',
                                                                    $org->grp,
                                                                )->value('npk_cord')
                                                                : 'Tidak ada foreman';
                                                            $frmName = \App\Models\User::where('npk', $frmNpk)->value(
                                                                'name',
                                                            );

                                                            echo $frmName;
                                                        @endphp
                                                    </td>
                                                    <td>
                                                        @php
                                                            $spvNpk = $org
                                                                ? \App\Models\Section::where(
                                                                    'id_section',
                                                                    $org->sect,
                                                                )->value('npk_cord')
                                                                : 'Tidak ada supervisor';
                                                            $spvName = \App\Models\User::where('npk', $spvNpk)->value(
                                                                'name',
                                                            );

                                                            echo $spvName;
                                                        @endphp
                                                    </td>
                                                    <td>{{ $item->status }}</td>
                                                    <td>{{ $item->bulan }}</td>
                                                    <td>{{ $item->tahun }}</td>
                                                    <td class="text-center">
                                                        @php

                                                            // Menghitung jumlah npk yang sama dengan $item->npk
                                                            $npkCount = \App\Models\SsBulanan::where('npk', $item->npk)
                                                                ->where('bulan', $item->bulan)
                                                                ->where('tahun', $item->tahun)
                                                                ->count();
                                                        @endphp
                                                        {{ $npkCount }}
                                                    </td>
                                                </tr>
                                                @php
                                                    // Tambahkan npk yang baru saja ditampilkan ke dalam array
                                                    $displayedCombinations[] = $combination;
                                                    $counter++;
                                                @endphp
                                            @endif
                                        @endforeach
                                    @endif
                                </table>
                                <div class="d-flex justify-content-between mb-3">
                                    @if ($userRole == 'Superadmin')
                                        <button type="submit" class="btn btn-outline-danger"
                                            onclick="confirm('Apakah Kamu Yakin?')">Delete Selected</button>
                                    @endif
                                    <div class="pagination justify-content-between">
                                        <ul class="pagination button w-100 mb-0">
                                            <!-- Tombol Previous tidak ditampilkan -->
                                            <li class="page-item disabled mx-1">
                                                <a class="btn btn-outline-primary"
                                                    href="{{ $ssBulanan->previousPageUrl() }}">Previous</a>
                                            </li>

                                            <!-- Tombol Next -->
                                            @if ($ssBulanan->hasMorePages())
                                                <li class="page-item">
                                                    <a class="btn btn-outline-primary"
                                                        href="{{ $ssBulanan->nextPageUrl() }}" rel="next"
                                                        aria-label="Next">Next</a>
                                                </li>
                                            @else
                                                <li class="page-item disabled">
                                                    <span class="btn btn-outline-primary disabled" aria-disabled="true"
                                                        aria-label="Next">Next</span>
                                                </li>
                                            @endif
                                            {{-- <li class="mx-5 align-content-center me-1 ms-5">
                                                Showing {{ $ssBulanan->count() }} of
                                                {{ $ssBulanan->total() }}
                                            </li> --}}
                                        </ul>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
