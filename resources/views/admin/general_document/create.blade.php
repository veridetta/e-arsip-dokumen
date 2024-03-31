@extends('layouts.my_admin_layout')
@section('title', 'Tambah Dokumen Umum')
@section('content')
    <main class="content">
        <div class="container p-0">
            <h1 class="mb-3 fw-bold my-text-color">Tambah Dokumen Umum</h1>
            @include('components.flash-message')
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.general-documents.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold my-text-color">Nama Dokumen</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                value="{{ old('name') }}" name="name">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="general_category_id" class="form-label">Jenis Dokumen</label>
                            <select name="general_category_id" id="general_category_id" class="form-select @error('general_category_id') is-invalid @enderror">
                                <option value="">Pilih Jenis Dokumen</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('general_category_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="file" class="form-label fw-bold my-text-color">File</label>
                            <input type="file" class="form-control @error('file') is-invalid @enderror" id="file"
                                name="file" accept=".pdf,.doc,.docx,.xls,.xlsx">
                            @error('file')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn my-bg text-white p-2 px-4"><i class="fa fa-save fa-fw"></i>
                                Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')

@endsection
