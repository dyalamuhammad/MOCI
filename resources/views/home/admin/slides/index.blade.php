@extends('layouts.admin')



@section('script')
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.semanticui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.8.8/semantic.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        $(() => {

            $('#data-table').DataTable({
                order: [
                    [0, 'asc']
                ],
                processing: true,
                serverSide: false
            });


        });

        function doDelete(id) {
            if (confirm('Yakin Hapus?')) {
                location.href = `slides/${id}/delete`;
            }
        }
    </script>
@endsection

@section('content')
    <main class="main" id="main">
        @include('alert')
        <div class="pagetitle">
            <h1>Slider</h1>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="container-fluid mb-3">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <a href="{{ route('formSlides') }}" class="btn btn-purple">
                            <i class="fa fa-plus"></i> Add Slides</a>
                    </div>

                </div>
            </div><!-- /.container-fluid -->



            <div class="container-fluid">
                <!-- Data Table -->
                <table class="ui celled table table-bordered" id="data-table">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Image</th>

                            <th>Title</th>
                            <th>Description</th>
                            <th>Link</th>
                            <th>Update Terakhir</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($slides as $item)
                            <tr>
                                <td>{{ $item->order }}</td>
                                <td><img src="{{ asset($item->img_url) }}" width="200px" alt=""></td>

                                <td>{{ $item->title ?? '-' }}</td>
                                <td>{{ $item->description ?? '-' }}</td>
                                <td>{{ $item->link ?? '-' }}</td>
                                <td>{{ $item->updated_at }}</td>
                                <td>
                                    <div class="d-flex gap-1">

                                        <a class="btn btn-primary" href="{{ route('editSlides', $item->id) }}">Ubah</a>
                                        <form action="{{ route('softDeleteSlide', $item->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Yakin Hapus?')">Hapus</button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </main>
@endsection
