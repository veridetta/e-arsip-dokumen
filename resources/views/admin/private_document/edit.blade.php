@extends('layouts.my_admin_layout')
@section('title', 'Ubah Dokumen Khusus')
@section('content')
    <main class="content">
        <div class="container p-0">
            <h1 class="mb-3 fw-bold my-text-color">Ubah Dokumen Khusus</h1>
            @include('components.flash-message')
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.private-documents.update', [$data->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold my-text-color">Nama</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                value="{{ old('name', $data->name) }}" name="name">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="file" class="form-label fw-bold my-text-color">File (kosongkan jika tidak ingin mengubah file)</label>
                            <labe class="d-block">File saat ini: <a href="{{ url('storage/private-documents/' . $data->file) }}"
                                    target="_blank">{{ $data->file }}</a></labe>
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
