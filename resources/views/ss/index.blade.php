@extends('layouts.main')
@section('script')
    <script>
        function setSearch(value) {
            filterCategory(value);
        }

        function searchCategory(value) {

            location.href = `?search=${value}`;
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.15.6/xlsx.full.min.js"></script>
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
        function cleanFIle() {

        }
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
                                <h5 class="m-b-10">Sugestion System Rekap Tahunan</h5>
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
                                <li class="breadcrumb-item"><a href="{{ route('ss') }}">SS Tahunan</a></li>
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
                            <div class="d-flex justify-content-between">
                                <div class="col-auto">
                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">
                                        Import Excel
                                    </button>
                                </div>
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Import SS
                                                    Tahunan
                                                </h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">

                                                <form action="{{ route('importSs') }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="month">Pilih Bulan:</label>
                                                        <select name="month" id="month" class="form-control mb-3"
                                                            required>
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
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="file">Pilih File:</label>
                                                        <input type="file" name="file" id="file"
                                                            class="form-control" required>
                                                        <p class="py-3"><a href="{{ route('downloadFormatSs') }}"
                                                                class="link-dark link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover fs-6">Download
                                                                Format</a></p>

                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Import</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex gap-1 mb-3">
                                    <div class="dropdown">
                                        <button class="btn btn-light border-dark col-12 text-left" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            {{ request('year') ?? 'All' }}
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item px-0" href="{{ route('ss') }}">All</a>
                                            </li>
                                            @foreach ($years as $year)
                                                <li><a class="dropdown-item px-0"
                                                        href="{{ route('ss', ['year' => $year]) }}">{{ $year }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                    <form action="{{ route('ss') }}" method="GET">
                                        <div class="input-group">
                                            <input type="text" name="search" class="form-control"
                                                placeholder="Cari Nama atau NPK" value="{{ $search }}">
                                            <button type="submit" class="btn btn-primary">Cari</button>
                                        </div>
                                    </form>
                                </div>

                                <div class="col-auto text-end">
                                    @if ($userRole == 'Superadmin')
                                        <form action="{{ route('cleanFileSsTahunan') }}" method="post" class="d-inline">
                                            @csrf
                                            <button class="btn btn-outline-danger" type="submit"
                                                onclick="confirm('Sahabat Yakin Akan Menghapus File SS Tahunan?')">Clean
                                                File</button>
                                        </form>
                                    @endif
                                    <button class="btn btn-green"
                                        onclick="exportTableToExcel('ss-table', 'ss-data')">EXPORT</button>
                                </div>
                            </div>

                            <table class="table table-responsive" id="ss-table">
                                <tr class="table-success">
                                    <th>No</th>
                                    <th>NPK</th>
                                    <th class="col-6 px-6">Nama</th>
                                    <th class="col-3">Fasilitator</th>
                                    <th class="col-3">Group</th>
                                    <th class="col-3">Departemen</th>
                                    <th class="col-2">Januari</th>
                                    <th class="col-2">Februari</th>
                                    <th class="col-2">Maret</th>
                                    <th class="col-2">April</th>
                                    <th class="col-2">Mei</th>
                                    <th class="col-2">Juni</th>
                                    <th class="col-2">Juli</th>
                                    <th class="col-2">Agustus</th>
                                    <th class="col-2">September</th>
                                    <th class="col-2">Oktober</th>
                                    <th class="col-2">November</th>
                                    <th class="col-2">Desember</th>
                                </tr>
                                @if ($ss->isEmpty())
                                    <tr>
                                        <td class="text-center col-12" colspan="16">Tidak Ada Data</td>
                                    </tr>
                                @else
                                    @foreach ($data_year as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->npk }}</td>
                                            <td>@php
                                                $name = \App\Models\User::where('npk', $item->npk)->value('name');

                                                echo $name;
                                            @endphp</td>
                                            <td>@php
                                                $org = \App\Models\Org::where('npk', $item->npk)->first();
                                                $frmNpk = $org
                                                    ? \App\Models\Group::where('id_group', $org->grp)->value('npk_cord')
                                                    : 'Tidak ada section';
                                                $frmName = \App\Models\User::where('npk', $frmNpk)->value('name');

                                                echo $frmName;
                                            @endphp</td>
                                            <td>@php
                                                $org = \App\Models\Org::where('npk', $item->npk)->first();
                                                $groupName = $org
                                                    ? \App\Models\Group::where('id_group', $org->grp)->value(
                                                        'nama_group',
                                                    )
                                                    : 'Tidak ada departemen';
                                                echo $groupName;
                                            @endphp</td>
                                            <td>@php
                                                $org = \App\Models\Org::where('npk', $item->npk)->first();
                                                $deptName = $org
                                                    ? \App\Models\Departemen::where('id_dept', $org->dept)->value(
                                                        'dept',
                                                    )
                                                    : 'Tidak ada departemen';
                                                echo $deptName;
                                            @endphp</td>
                                            <td class="text-center">
                                                @if ($item->januari)
                                                    {{ $item->januari }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($item->februari)
                                                    {{ $item->februari }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($item->maret)
                                                    {{ $item->maret }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($item->april)
                                                    {{ $item->april }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($item->mei)
                                                    {{ $item->mei }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($item->juni)
                                                    {{ $item->juni }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($item->juli)
                                                    {{ $item->juli }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($item->agustus)
                                                    {{ $item->agustus }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($item->september)
                                                    {{ $item->september }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($item->oktober)
                                                    {{ $item->oktober }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($item->november)
                                                    {{ $item->november }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($item->desember)
                                                    {{ $item->desember }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif

                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
