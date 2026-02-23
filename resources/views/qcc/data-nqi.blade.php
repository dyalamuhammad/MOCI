@extends('layouts/main')
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.2/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.2/FileSaver.min.js"></script>

    <script>
        function exportTableToExcel(tableID, filename = '') {
            var table = document.getElementById(tableID);

            // Clone the table
            var clonedTable = table.cloneNode(true);



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
    <!-- JavaScript to handle filter submission -->
    <script>
        function setFilter(filter) {
            // Create a form and submit it
            var form = document.createElement('form');
            form.method = 'GET';
            form.action = '{{ route('dataNqiQcc') }}';

            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'periode';
            input.value = filter;

            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
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
                                <h5 class="m-b-10">Data NQI</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="bi bi-house"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#!">Data NQI</a></li>
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
                            <h5 class="text-white">Monitoring Data NQI</h5>
                            <span class="d-block">Hallo sahabat Berikut data monitoring NQI</span>
                        </div>
                        <div class="card-body table-border-style">
                            <div class="d-flex justify-content-between gap-1 mb-3">
                                <div class="">
                                    <button class="btn btn-outline-green w-100"
                                        onclick="exportTableToExcel('data-nqi-table', 'data-nqi')">Export</button>
                                </div>
                                <div class="d-flex gap-1">
                                    <p class="align-middle my-auto fs-6">Periode :</p>
                                    <div class="dropdown">
                                        <button class="btn btn-light border-dark col-12 text-left" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            {{ $periode == '' ? 'All' : ucfirst($periode) }}
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item px-0" href="#" onclick="setFilter('')">All</a>
                                            </li>
                                            @foreach ($periodes as $item)
                                                <li><a class="dropdown-item px-0" href="#"
                                                        onclick="setFilter('{{ $item->periode }}')">{{ $item->periode }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table" id="data-nqi-table">

                                    <tr class="table-primary">
                                        <th>No</th>
                                        <th>Kriteria</th>
                                        <th>Periode</th>
                                        <th>Circle</th>
                                        <th>Npk Fasilitator</th>
                                        <th>Nama Fasilitator </th>
                                        <th>Npk Tema Leader</th>
                                        <th>Nama Tema Leader</th>
                                        <th>Dept</th>
                                        <th>Judul</th>
                                        <th>Manfaat Finansial</th>
                                        <th>Manfaat Non Finansial</th>
                                    </tr>
                                    @php
                                        $counter = 1; // Inisialisasi counter di luar loop
                                    @endphp
                                    {{-- @dd($cbi) --}}
                                    @foreach ($cbi as $item)
                                        <tr>
                                            <td>{{ $counter }}</td>
                                            <td>cbi</td>
                                            <td>
                                                @php
                                                    $cbiCircle = \App\Models\CircleDt::where(
                                                        'id',
                                                        $item->circle_id,
                                                    )->first();
                                                    $org = \App\Models\Org::where(
                                                        'npk',
                                                        $cbiCircle->npk_leader,
                                                    )->first();

                                                    $frmNpk = $org
                                                        ? \App\Models\Group::where('id_group', $org->grp)->value(
                                                            'npk_cord',
                                                        )
                                                        : 'Tidak ada group';
                                                    $frmName = \App\Models\User::where('npk', $frmNpk)->value('name');

                                                    $deptName = $org
                                                        ? \App\Models\Departemen::where('id_dept', $org->dept)->value(
                                                            'dept',
                                                        )
                                                        : 'Tidak ada departemen';
                                                    $judul = \App\Models\NotulenCbi1::where(
                                                        'circle_id',
                                                        $item->circle_id,
                                                    )->value('judul');
                                                @endphp
                                                {{ $cbiCircle->periode }}
                                            </td>
                                            <td>
                                                {{ $cbiCircle->name }}
                                            </td>
                                            <td>
                                                @php
                                                    echo $frmNpk;
                                                @endphp
                                            </td>
                                            <td>
                                                {{ $frmName }}
                                            </td>
                                            <td>

                                                {{ $cbiCircle->npk_leader }}
                                            </td>
                                            <td>

                                                {{ $cbiCircle->leader }}
                                            </td>
                                            <td>
                                                @php

                                                    echo $deptName;
                                                @endphp
                                            </td>
                                            <td>
                                                @php

                                                    echo $judul;

                                                @endphp
                                            </td>
                                            <td>{{ $item->benefit }}</td>
                                            <td>{{ $item->manfaat }}</td>
                                        </tr>
                                        @php
                                            $counter++;
                                        @endphp
                                    @endforeach
                                    @foreach ($qcc as $item)
                                        @php
                                            $qccCircle = \App\Models\Circle::where('id', $item->circle_id)->first();
                                            $qccOrg = \App\Models\Org::where('npk', $qccCircle->npk_leader)->first();

                                            $frmNpk = $qccOrg
                                                ? \App\Models\Group::where('id_group', $qccOrg->grp)->value('npk_cord')
                                                : 'Tidak ada group';
                                            $frmName = \App\Models\User::where('npk', $frmNpk)->value('name');

                                            $deptName = $qccOrg
                                                ? \App\Models\Departemen::where('id_dept', $qccOrg->dept)->value('dept')
                                                : 'Tidak ada departemen';
                                            $judul = \App\Models\Notulen1::where('circle_id', $item->circle_id)->value(
                                                'judul',
                                            );
                                        @endphp
                                        <tr>
                                            <td>{{ $counter }}</td>
                                            <td>qcc</td>
                                            <td>{{ $qccCircle->periode }}</td>
                                            <td>
                                                {{ $qccCircle->name }}
                                            </td>
                                            <td>
                                                @php
                                                    echo $frmNpk;
                                                @endphp
                                            </td>
                                            <td>
                                                {{ $frmName }}
                                            </td>
                                            <td>

                                                {{ $qccCircle->npk_leader }}
                                            </td>
                                            <td>

                                                {{ $qccCircle->leader }}
                                            </td>
                                            <td>
                                                @php

                                                    echo $deptName;
                                                @endphp
                                            </td>
                                            <td>
                                                @php

                                                    echo $judul;

                                                @endphp
                                            </td>
                                            <td>{{ $item->benefit }}</td>
                                            <td>{{ $item->manfaat }}</td>
                                        </tr>
                                        @php
                                            $counter++;
                                        @endphp
                                    @endforeach
                                    @foreach ($dt as $item)
                                        @php
                                            $dtCircle = \App\Models\CircleDt::where('id', $item->circle_id)->first();
                                            $dtOrg = \App\Models\Org::where('npk', $dtCircle->npk_leader)->first();

                                            $frmNpk = $dtOrg
                                                ? \App\Models\Group::where('id_group', $dtOrg->grp)->value('npk_cord')
                                                : 'Tidak ada group';
                                            $frmName = \App\Models\User::where('npk', $frmNpk)->value('name');

                                            $deptName = $dtOrg
                                                ? \App\Models\Departemen::where('id_dept', $dtOrg->dept)->value('dept')
                                                : 'Tidak ada departemen';
                                            $judul = \App\Models\NotulenDt1::where(
                                                'circle_id',
                                                $item->circle_id,
                                            )->value('judul');
                                        @endphp
                                        <tr>
                                            <td>{{ $counter }}</td>
                                            <td>dt</td>
                                            <td>{{ $dtCircle->periode }}</td>
                                            <td>
                                                {{ $dtCircle->name }}
                                            </td>
                                            <td>
                                                @php
                                                    echo $frmNpk;
                                                @endphp
                                            </td>
                                            <td>
                                                {{ $frmName }}
                                            </td>
                                            <td>

                                                {{ $dtCircle->npk_leader }}
                                            </td>
                                            <td>

                                                {{ $dtCircle->leader }}
                                            </td>
                                            <td>
                                                @php

                                                    echo $deptName;
                                                @endphp
                                            </td>
                                            <td>
                                                @php

                                                    echo $judul;

                                                @endphp
                                            </td>
                                            <td>{{ $item->benefit }}</td>
                                            <td>{{ $item->manfaat }}</td>
                                        </tr>
                                        @php
                                            $counter++;
                                        @endphp
                                    @endforeach


                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- table card-1 start -->
            <!-- Warning Section Ends -->

            <!-- Required Js -->
            <script src="assets/js/vendor-all.min.js"></script>
            <script src="assets/js/plugins/bootstrap.min.js"></script>
            <script src="assets/js/pcoded.min.js"></script>

            <!-- Apex Chart -->
            <!-- <script src="assets/js/plugins/apexcharts.min.js"></script> -->


            <!-- custom-chart js -->
            <!-- <script src="assets/js/pages/dashboard-main.js"></script> -->
        @endsection
