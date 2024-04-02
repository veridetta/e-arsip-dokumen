@extends('layouts.my_admin_layout')
@section('title', 'Dashboard')
@section('content')
    <main class="content">
        <div class="container-fluid p-0">

            <h1 class="mb-4 fw-bold my-text-color">Selamat Datang, {{ Auth::user()->name }}</h1>
            <div class="row">
                <div class="col-12 col-lg-6 col-xl-6 d-flex" style="min-height: 200px">
                    <div class="card flex-fill ">
                        <div class="card-body">
                            <h3 class="card-title my-text-color">Jumlah Dokumen Umum</h3>
                            <div class="d-flex align-items-center mt-2 p-2">
                                <h1 class="display-2 my-text-color mb-0 font-weight-bold">{{ $total_dokumen_umum }}</h1>
                                <div class="ms-auto">
                                    <div class="avatar text-secondary">
                                        <i class="fas fa-file-alt fa-4x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6 col-xl-6 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <h3 class="card-title my-text-color">Jumlah Dokumen Khusus</h3>
                            <div class="d-flex align-items-center mt-2 p-2">
                                <h1 class="display-2 my-text-color font-weight-bold mb-0">{{ $total_dokumen_pribadi }}</h1>
                                <div class="ms-auto">
                                    <div class="avatar text-secondary">
                                        <i class="fas fa-key fa-4x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
