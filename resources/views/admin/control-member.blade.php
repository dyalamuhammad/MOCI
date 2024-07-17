@extends('layouts/main')
@section('script')
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
        $(document).ready(function() {
            $('#pindahCircleModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget) // Button that triggered the modal
                var npk = button.data('npk') // Extract info from data-* attributes
                var modal = $(this)
                modal.find('#npkInput').val(npk) // Set the value of the input hidden
            })
        });
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
                                <h5 class="m-b-10">Control Member</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/"><i class="bi bi-house"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('control-member') }}">Control Member</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header bg-darkBlue text-white">
                            <h5 class="text-white">Control Member</h5>
                            <span class="d-block">Halo sahabat admin, silahkan control member</span>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div class="d-flex gap-1 p-0 col-4">
                                    <div class="dropdown">
                                        <button class="btn btn-light border-dark text-uppercase col-12 text-left"
                                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            {{ $filter == '' ? 'all' : ucfirst($filter) }}
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item px-0" href="#" onclick="setFilter('')">All</a>
                                            </li>
                                            <li><a class="dropdown-item px-0" href="#"
                                                    onclick="setFilter('circle')">Sudah Ada Circle</a>
                                            </li>
                                            <li><a class="dropdown-item px-0" href="#"
                                                    onclick="setFilter('no_circle')">Belum Ada Circle</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <form action="{{ route('control-member') }}" method="GET" class="w-100"
                                        id="search-form">
                                        <div class="input-group">
                                            <input type="text" name="search" class="form-control"
                                                placeholder="Cari Nama Circle atau NPK Leader" value="{{ $search }}">
                                            <input type="hidden" id="filter-input" name="filter"
                                                value="{{ request()->query('filter', '') }}">
                                            <button type="submit" class="btn btn-primary">Cari</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <tr class="table-primary">
                                        <th>No</th>
                                        <th>NPK</th>
                                        <th>Nama</th>
                                        <th>Circle</th>
                                        <th class="col-1">Action</th>
                                    </tr>
                                    @foreach ($user as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->npk }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>
                                                @php
                                                    $activePeriode = \App\Models\Periode::where('status', 1)->first();

                                                    // Cari member berdasarkan npk_anggota
                                                    $member = \App\Models\Member::where('npk_anggota', $item->npk)
                                                        ->whereHas('circle', function ($query) use ($activePeriode) {
                                                            $query->where('periode', $activePeriode->periode);
                                                        })
                                                        ->first();

                                                    // Jika member tidak ditemukan, cari di npk_leader pada tabel circle
                                                    if (!$member) {
                                                        $circle = \App\Models\Circle::where('npk_leader', $item->npk)
                                                            ->where('periode', $activePeriode->periode)
                                                            ->first();

                                                        $circleName = $circle ? $circle->name : 'Tidak ada circle';
                                                    } else {
                                                        $circleName = $member->circle->name;
                                                    }

                                                    echo $circleName;
                                                @endphp
                                            </td>
                                            <td>
                                                <button class="btn btn-green" data-toggle="modal"
                                                    data-target="#pindahCircleModal"
                                                    data-npk="{{ $item->npk }}">Ubah</button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="pindahCircleModal" tabindex="-1" role="dialog"
                                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Pindah Circle
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form method="POST" action="{{ route('pindah-circle') }}">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <label for="">NPK</label>
                                                                    <input type="text" class="form-control mb-2"
                                                                        name="npk" id="npkInput" readonly>
                                                                    <div class="form-group">
                                                                        <label for="circle" class="mb-2">Pilih
                                                                            Circle</label>
                                                                        <select class="form-control" id="circle"
                                                                            name="circle_id">
                                                                            @foreach ($circles as $circle)
                                                                                <option value="{{ $circle->id }}">
                                                                                    {{ $circle->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Save
                                                                        changes</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                                <div class="pagination justify-content-between">
                                    <ul class="pagination button w-100">
                                        <!-- Tombol Previous tidak ditampilkan -->
                                        <li class="page-item disabled mx-1">
                                            <a class="btn btn-outline-primary"
                                                href="{{ $user->appends(['search' => $search, 'filter' => $filter])->previousPageUrl() }}">Previous</a>
                                        </li>

                                        <!-- Tombol Next -->
                                        @if ($user->hasMorePages())
                                            <li class="page-item">
                                                <a class="btn btn-outline-primary"
                                                    href="{{ $user->appends(['search' => $search, 'filter' => $filter])->nextPageUrl() }}"
                                                    rel="next" aria-label="Next">Next</a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <span class="btn btn-outline-primary disabled" aria-disabled="true"
                                                    aria-label="Next">Next</span>
                                            </li>
                                        @endif
                                        <li class="mx-5 align-content-center me-1 ms-5">
                                            Showing {{ $user->count() }} of
                                            {{ $user->total() }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endsection
