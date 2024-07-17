@extends('layouts.admin')



@section('script')
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script>
        $(function() {
            // Summernote
            $('#address').summernote({
                height: 180
            });
        })
    </script>
@endsection

@section('content')
    @include('alert')
    <main class="main" id="main">
        <div class="container-fluid mb-3">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <a href="{{ route('adminSlides') }}" class="btn btn-dark">
                        <i class="bi bi-arrow-left"></i> Back</a>
                </div>

            </div>
        </div><!-- /.container-fluid -->

        <div class="container-fluid">
            <div class="row">

                <div class="col-md-12">
                    <!-- FORM -->
                    <form action="{{ $forms['id'] ?? null ? route('updateSlides', $forms['id']) : route('addSlides') }}"
                        method="post" enctype="multipart/form-data">
                        @csrf
                        @method($forms['id'] ?? null ? 'put' : 'post')

                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Form</h3>


                            </div>
                            <!-- /.card-header -->


                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 text-center mb-3">

                                        <img src="{{ asset($forms['img_url'] ?? null) }}" style="max-width: 300px"
                                            alt="">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sku">Order *</label>
                                            <input type="number" name="order" class="form-control"
                                                value="{{ old('order') ?? ($dataCount ?? ($forms['order'] ?? 0)) }}"
                                                required>

                                        </div>
                                        <!-- /.form-group -->

                                    </div>
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="sell_price">Slides Link *</label>
                                            <input type="text" name="link" class="form-control"
                                                value="{{ old('link') ?? ($forms['link'] ?? '') }}" required>
                                        </div>

                                    </div>
                                    <!-- /.col -->
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="sell_price">Slides Image *</label>
                                            <input type="file" name="img_url"
                                                value="{{ asset($img['img_url'] ?? null) }}" class="form-control">
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title_id">Slides Title *</label>
                                            <input type="text" id="title" name="title"
                                                value="{{ old('title') ?? ($forms['title'] ?? '') }}" class="form-control"
                                                required>

                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="title_id">Slides Description *</label>
                                            <textarea name="description" id="" cols="30" rows="2" class="form-control">{{ old('description') ?? ($forms['description'] ?? '') }}
                            </textarea>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                            </div>

                            <div class="card-footer text-right">

                                <button class="btn btn-purple"
                                    onclick="this.form.submit(); this.disabled=true; this.value='Sending…';"
                                    type="submit"><i class="fa fa-save"></i> Save</button>
                            </div>
                        </div>

                    </form>
                    <!-- /.form -->
                </div>


            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </main>
@endsection
