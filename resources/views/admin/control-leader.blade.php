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
    <!-- Script untuk Mengisi Data ke Modal -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editButtons = document.querySelectorAll('.btn-edit');
            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const circleName = this.getAttribute('data-circle-name');
                    const npkLeaderOld = this.getAttribute('data-npk-leader-old');
                    const circleId = this.getAttribute('data-circle-id');

                    // Isi data di modal
                    document.getElementById('circleName').value = circleName;
                    document.getElementById('npkLeaderOld').value = npkLeaderOld;
                    document.getElementById('circleId').value = circleId;
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editButtons = document.querySelectorAll('.btn-edit-dt');
            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const circleDtName = this.getAttribute('data-circle-dt-name');
                    const npkLeaderDtOld = this.getAttribute('data-npk-leader-dt-old');
                    const circleDtId = this.getAttribute('data-circle-dt-id');

                    // Isi data di modal
                    document.getElementById('circleDtName').value = circleDtName;
                    document.getElementById('npkLeaderDtOld').value = npkLeaderDtOld;
                    document.getElementById('circleDtId').value = circleDtId;
                });
            });
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
                                <h5 class="m-b-10">Control Leader</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/"><i class="bi bi-house"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('control-leader') }}">Control Leader</a></li>
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
                            <h5 class="text-white">Control Leader</h5>
                            <span class="d-block">Halo sahabat admin, silahkan control leader</span>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div class="d-flex justify-content-center gap-1 p-0 col-12">


                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <tr class="table-primary">
                                        <th>No</th>
                                        <th class="text-center">Periode</th>
                                        <th>Category</th>
                                        <th>Circle</th>
                                        <th>NPK Team Leader</th>
                                        <th>Team Leader</th>
                                        <th class="col-1">Action</th>
                                    </tr>
                                    @foreach ($circles as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="text-center">
                                                @php
                                                    $activePeriode = \App\Models\Periode::where('status', 1)->value(
                                                        'periode',
                                                    );
                                                    echo $activePeriode;
                                                @endphp
                                            </td>
                                            <td>QCC</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->npk_leader }}</td>
                                            <td>{{ $item->leader }}</td>
                                            <td>
                                                <button class="btn btn-green btn-edit" data-bs-toggle="modal"
                                                    data-bs-target="#editModal" data-circle-name="{{ $item->name }}"
                                                    data-npk-leader-old="{{ $item->npk_leader }}"
                                                    data-circle-id="{{ $item->id }}">
                                                    Ubah
                                                </button>
                                                <div class="modal fade" id="editModal" tabindex="-1"
                                                    aria-labelledby="editModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <form action="{{ route('update.npk_leader') }}" method="POST">
                                                                @csrf
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="editModalLabel">Ubah NPK
                                                                        Leader
                                                                    </h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label for="circleName" class="form-label">Nama
                                                                            Circle</label>
                                                                        <input type="text" class="form-control"
                                                                            id="circleName" name="circle_name" readonly>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="npkLeaderOld" class="form-label">NPK
                                                                            Leader
                                                                            Lama</label>
                                                                        <input type="text" class="form-control"
                                                                            id="npkLeaderOld" name="npk_leader_old"
                                                                            readonly>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="npkLeaderNew" class="form-label">NPK
                                                                            Leader
                                                                            Baru</label>
                                                                        <input type="text" class="form-control"
                                                                            id="npkLeaderNew" name="npk_leader_new"
                                                                            required>
                                                                    </div>
                                                                    <input type="hidden" name="circle_id" id="circleId">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Simpan
                                                                        Perubahan</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @foreach ($circlesDt as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="text-center">
                                                @php
                                                    $activePeriode = \App\Models\Periode::where('status', 1)->value(
                                                        'periode',
                                                    );
                                                    echo $activePeriode;
                                                @endphp
                                            </td>
                                            <td>{{ $item->category }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->npk_leader }}</td>
                                            <td>
                                                {{ $item->leader }}</td>
                                            <td>
                                                <button class="btn btn-green btn-edit-dt" data-bs-toggle="modal"
                                                    data-bs-target="#editModalDt" data-circle-dt-name="{{ $item->name }}"
                                                    data-npk-leader-dt-old="{{ $item->npk_leader }}"
                                                    data-circle-dt-id="{{ $item->id }}">
                                                    Ubah
                                                </button>
                                                <div class="modal fade" id="editModalDt" tabindex="-1"
                                                    aria-labelledby="editModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <form action="{{ route('update.npk_leader_dt') }}"
                                                                method="POST">
                                                                @csrf
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="editModalLabel">Ubah NPK
                                                                        Leader
                                                                    </h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label for="circleName" class="form-label">Nama
                                                                            Circle</label>
                                                                        <input type="text" class="form-control"
                                                                            id="circleDtName" name="circle_name" readonly>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="npkLeaderOld" class="form-label">NPK
                                                                            Leader
                                                                            Lama</label>
                                                                        <input type="text" class="form-control"
                                                                            id="npkLeaderDtOld" name="npk_leader_old"
                                                                            readonly>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="npkLeaderNew" class="form-label">NPK
                                                                            Leader
                                                                            Baru</label>
                                                                        <input type="text" class="form-control"
                                                                            id="npkLeaderNew" name="npk_leader_new"
                                                                            required>
                                                                    </div>
                                                                    <input type="hidden" name="circle_id"
                                                                        id="circleDtId">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Simpan
                                                                        Perubahan</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                                {{-- <div class="pagination justify-content-between">
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
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endsection
