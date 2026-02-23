@extends('layouts/main')
@section('script')
    <script>
        function doDelete(id) {
            if (confirm('Yakin Hapus Section?')) {
                // Menggunakan fungsi route() untuk mendapatkan URL dari nama rute Laravel
                var url = "{{ route('softDeleteSection', ':id') }}";
                // Mengganti placeholder :id dengan nilai id yang diteruskan
                url = url.replace(':id', id);
                // Melakukan redirect ke URL yang sudah dibuat
                location.href = url;
            }
        }
    </script>
    <script>
        function setFilter(value) {
            filterCategory(value);
        }

        function filterCategory(value) {

            location.href = `?filter=${value}`;
        }

        function setSearch(value) {
            filterCategory(value);
        }

        function searchCategory(value) {

            location.href = `?search=${value}`;
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
            // Add quotes to the value in the last cell of each row
            for (var i = 1; i < clonedTable.rows.length; i++) {
                // Add quotes to the value in the last cell of each row
                var lastCellIndex = clonedTable.rows[i].cells.length - 1;
                if (lastCellIndex >= 0) {
                    var lastCell = clonedTable.rows[i].cells[lastCellIndex];
                    lastCell.innerText = "'" + lastCell.innerText;
                }
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
    <div class="pcoded-main-container">
        <!-- [ Main Content ] start -->
        <div class="pcoded-content">
            @include('alert')
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">Control Section</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="bi bi-house"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('section') }}">Data section</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <div class="row">

                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header bg-darkBlue text-white">
                            <h5 class="text-white">Data Section</h5>
                            <span class="d-block m-t-5">Hallo sahabat Berikut data section</span>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between gap-1 mb-3">
                                <div class="">
                                    <button class="btn btn-outline-green w-100"
                                        onclick="exportTableToExcel('section-table', 'section-data')">Export</button>

                                </div>
                                <div class="d-flex gap-1 col-3">
                                    {{-- <div class="dropdown">
                                        <button class="btn btn-light border-dark text-uppercase col-auto text-left"
                                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            {{ $filter === '' ? 'All' : ucfirst($filter) }}
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item px-0" href="#" onclick="setFilter('')">All</a>
                                            </li>
                                            <li><a class="dropdown-item px-0" href="#" onclick="setFilter('tm')">Team
                                                    Member</a></li>
                                            <li><a class="dropdown-item px-0" href="#" onclick="setFilter('tl')">Team
                                                    Leader</a>
                                            <li><a class="dropdown-item px-0" href="#"
                                                    onclick="setFilter('frm')">Foreman</a>
                                            </li>
                                            <li><a class="dropdown-item px-0" href="#"
                                                    onclick="setFilter('spv')">Supervisor</a></li>
                                            <li><a class="dropdown-item px-0" href="#"
                                                    onclick="setFilter('mng')">Manager</a>
                                            <li><a class="dropdown-item px-0" href="#"
                                                    onclick="setFilter('dh')">Division
                                                    Head</a>
                                            </li>
                                        </ul>
                                    </div> --}}
                                    <form action="{{ route('section') }}" method="GET" class="col-12">
                                        <div class="input-group">
                                            <input type="text" name="search" class="form-control"
                                                placeholder="Cari Nama atau ID Section" value="{{ $search }}">
                                            <button type="submit" class="btn btn-primary">Cari</button>
                                        </div>
                                    </form>

                                </div>

                                <div class="d-flex gap-1">
                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">
                                        IMPORT
                                    </button>
                                    <div class="modal fade" id="exampleModal" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Import
                                                        Karyawan
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">

                                                    <form method="POST" action="{{ route('importSection') }}"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label for="file">Choose Excel File:</label>
                                                            <input type="file" class="form-control" name="file"
                                                                id="file" accept=".xlsx, .xls" required>
                                                        </div>
                                                        <p class="py-3"><a href="{{ route('downloadFormatSection') }}"
                                                                class="link-dark link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover fs-6">Download
                                                                Format</a></p>

                                                        <button type="submit" class="btn btn-primary w-100">IMPORT</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary"
                                        onclick="window.location.href='{{ route('form-section') }}'">ADD</button>
                                </div>


                            </div>
                            <div class="table-responsive">
                                <table class="table rounded-3" id="section-table">
                                    <tr class="table-primary">
                                        <th>No</th>
                                        <th>ID Section</th>
                                        <th>Nama Section</th>
                                        <th>NPK Koordinator</th>
                                        <th>Nama Koordinator</th>
                                        <th>ID Department</th>

                                        <th class="text-center">Preview</th>
                                    </tr>
                                    @foreach ($section as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->id_section }}</td>
                                            <td>{{ $item->section }}</td>
                                            <td>{{ $item->npk_cord }}</td>
                                            <td>
                                                @php
                                                    $nama_cord = \App\Models\User::where('npk', $item->npk_cord)->value(
                                                        'name',
                                                    );
                                                    echo $nama_cord;
                                                @endphp

                                            </td>
                                            <td>{{ $item->id_dept }}</td>
                                            <td class="text-center">
                                                <a class="btn btn-sm btn-green"
                                                    href="{{ route('edit-section', ['id' => $item->id]) }}">Detail</a>
                                                <button class="btn btn-sm btn-danger"
                                                    onclick="doDelete({{ $item->id }})">Hapus</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>


                                {{-- <div class="pagination justify-content-between">
                                    <ul class="pagination button w-100">
                                        <!-- Tombol Previous tidak ditampilkan -->
                                        <li class="page-item disabled mx-1">
                                            <a class="btn btn-outline-primary"
                                                href="{{ $users->previousPageUrl() }}">Previous</a>
                                        </li>

                                        <!-- Tombol Next -->
                                        @if ($users->hasMorePages())
                                            <li class="page-item">
                                                <a class="btn btn-outline-primary" href="{{ $users->nextPageUrl() }}"
                                                    rel="next" aria-label="Next">Next</a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <span class="btn btn-outline-primary disabled" aria-disabled="true"
                                                    aria-label="Next">Next</span>
                                            </li>
                                        @endif
                                        <li class="mx-5 align-content-center me-1 ms-5">
                                            Showing {{ $users->count() }} of {{ $users->total() }}
                                        </li>
                                    </ul>
                                </div> --}}




                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @endSection
