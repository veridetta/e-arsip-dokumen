@extends('layouts.my_admin_layout')
@section('title', 'Dashboard')
@section('content')
    <main class="content">
        <div class="container-fluid p-0">

            <h1 class="mb-4 fw-bold my-text-color text-capitalize">Selamat Datang, {{ Auth::user()->name }}</h1>
            <div class="col-12 col-lg-12 col-xl-12 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <h3 class="card-title my-text-color">Jumlah Dokumen Khusus</h3>
                        <div class="d-flex align-items-center mt-2 p-2">
                            <h1 class="display-3 my-text-color font-weight-bold mb-0">{{ $total_dokumen_pribadi }}</h1>
                            <div class="ms-auto">
                                <div class="my-text-color opacity-75">
                                    <i class="fas fa-key fa-5x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class=" text-center col-12 container pt-4">
                <h3 class="fw-bold text-uppercase text-primary">Jelajahi Dokumen Umum</h3>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <form action="{{ route('user.dashboard.filter') }}" method="GET">
                            <div class="input-group mb-3">
                                <select class="form-select" name="category" id="category">
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }} " @if (request()->get('category') == $category->id) selected @endif>
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-primary" type="submit">Filter</button>
                            </div>
                        </form>
                    </div>

                    @if (count($documents) == 0)

                        <div class="col-12">
                            <div class="alert alert-danger" role="alert">
                                Dokumen tidak ditemukan
                            </div>
                        </div>

                    @endif
                    @foreach ($documents as $document)
                        <div class="col-12 col-md-4">
                            <div class="card mb-4">
                                @if(checkFileExtension($document->file) == 'pdf')
                                    <i class="fa fa-file-pdf fa-5x text-center mt-3"></i>
                                @elseif(checkFileExtension($document->file) == 'doc' || checkFileExtension($document->file) == 'docx')
                                    <i class="fa fa-file-word fa-5x text-center mt-3"></i>
                                @elseif(checkFileExtension($document->file) == 'xls' || checkFileExtension($document->file) == 'xlsx')
                                    <i class="fa fa-file-excel fa-5x text-center mt-3"></i>
                                @else
                                    <i class="fa fa-file-alt fa-5x text-center mt-3"></i>
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ $document->name }}</h5>
                                    <p class="card-text">Kategori : {{ $document->generalCategory->name }}</p>
                                    <a href="{{ route('user.dashboard.document', $document->id) }}" class="btn btn-primary col-12">Lihat</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>

@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable();
        });

    </script>
@endsection
