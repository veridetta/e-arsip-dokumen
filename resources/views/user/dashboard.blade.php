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
        </div>
    </main>

@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            new DataTable('#datatable', {
                "columnDefs": [{
                    "orderable": false,
                    "targets": 2
                }]
            });

            const deleleBtn = document.querySelectorAll('.delete-btn')
            deleleBtn.forEach(el => {
                console.log(el)
                el.addEventListener('submit', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Apakah anda yakin?',
                        text: "Ingin menghapus data ini",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'Hapus',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit()
                        }
                    })
                })
            })
        })
    </script>
@endsection
