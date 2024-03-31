@extends('layouts.my_layout')
@section('title', 'Jelajahi')
@section('content')
<div class="w-100" style="min-height: 70vh;">
    <div class=" text-center col-12 container pt-4">
        <h3 class="fw-bold text-uppercase text-primary">Jelajahi Dokumen</h3>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form action="{{ route('guest.explore.filter') }}" method="GET">
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
                            <a href="{{ route('guest.explore.document', $document->id) }}" target="_blank" class="btn btn-primary col-12">Lihat</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
