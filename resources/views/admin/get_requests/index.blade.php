@extends('layouts.my_admin_layout')
@section('title', 'Minta Izin Akses Dokumen Khusus')
@section('content')
    <main class="content">
        <div class="container p-0">
            <h1 class="mb-3 fw-bold my-text-color">Request Dokumen Khusus</h1>
            @include('components.flash-message')
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mb-4 justify-content-end">
                        <a href="{{ route('admin.get-requests.create') }}" class="btn my-bg text-white p-2 px-4"><i
                                class="fa fa-plus fa-fw"></i>
                            Minta Izin Baru</a>
                    </div>
                    <table id="datatable" class="table table-bordered rounded w-100">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Tanggal Permintaan</th>
                                <th class="text-center">Tujuan</th>
                                <th class="text-center">Pesan</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Balasan</th>
                                <th class="text-center">File</th>
                                <th class="text-center">Expired</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach ($data as $data)
                                <tr>
                                    <td class="text-center">{{ $no++ }}</td>
                                    <td class="text-center">{{ $data->created_at }}</td>
                                    <td class="text-center">{{ $data->toUser->name }}</td>
                                    <td class="text-center">{{ $data->message }}</td>
                                    <td class="text-center">
                                        @if ($data->status == 'pending')
                                            <span class="badge bg-warning">Menunggu</span>
                                        @elseif ($data->status == 'approved')
                                            @if ($data->expired < now())
                                                <span class="badge bg-secondary">Berbagi Dokumen Telah Berakhir</span>
                                            @else
                                                <span class="badge bg-success">Disetujui</span>
                                            @endif
                                        @else
                                            <span class="badge bg-danger">Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $data->response }}</td>
                                    <td class="text-center">
                                        @if ($data->status == 'approved')
                                        <a href="{{ route('admin.get-requests.preview', [$data->id]) }}"
                                            class="btn btn-primary"><i class="fa fa-file fa-fw"></i> Lihat</a>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $data->expired }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
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
