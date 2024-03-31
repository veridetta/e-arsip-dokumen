@extends('layouts.my_admin_layout')
@section('title', 'Tambah Client')
@section('content')
    <main class="content">
        <div class="container p-0">
            <h1 class="mb-3 fw-bold my-text-color">Tambah Client</h1>
            @include('components.flash-message')
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.clients.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold my-text-color">Nama</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="company_name" class="form-label fw-bold my-text-color">Nama Perusahaan</label>
                            <input type="text" class="form-control @error('company_name') is-invalid @enderror"
                                id="company_name" name="company_name" value="{{ old('company_name') }}">
                            @error('company_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label fw-bold my-text-color">No Telp</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                                name="phone" value="{{ old('phone') }}">
                            @error('phone')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="start_contract" class="form-label fw-bold my-text-color">Mulai Kontrak</label>
                            <input type="date" class="form-control @error('start_contract') is-invalid @enderror"
                                id="start_contract" name="start_contract" value="{{ old('start_contract') }}">
                            @error('start_contract')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="end_contract" class="form-label fw-bold my-text-color">Berakhir Kontrak</label>
                            <input type="date" class="form-control @error('end_contract') is-invalid @enderror"
                                id="end_contract" name="end_contract" value="{{ old('end_contract') }}">
                            @error('end_contract')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="file" class="form-label fw-bold my-text-color">File</label>
                            <input type="file" class="form-control @error('file') is-invalid @enderror" id="file"
                                name="file" accept=".pdf">
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
