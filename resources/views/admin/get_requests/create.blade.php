@extends('layouts.my_admin_layout')
@section('title', 'Buat Permintaan Dokumen Khusus')
@section('content')
    <main class="content">
        <div class="container p-0">
            <h1 class="mb-3 fw-bold my-text-color">Buat Permintaan Dokumen Khusus</h1>
            @include('components.flash-message')
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.get-requests.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <div class="form-group">
                                <label for="to" class="form-label fw-bold my-text-color">Tujuan</label>
                                <div class="input-group">
                                    <select class="form-select select2 @error('to') is-invalid @enderror" id="to" name="to">
                                        <option value="">Pilih User</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" @if (old('to') == $user->id) selected @endif>
                                                {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('to')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 mt-5">
                            <label for="message" class="form-label fw-bold my-text-color">Pesan</label>
                            <textarea class="form-control @error('message') is-invalid @enderror" id="message"
                                name="message">{{ old('message') }}</textarea>
                            @error('message')
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
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: 'Pilih User',
            allowClear: true,
            width: '100%'
        });
    });
    </script>
@endsection
