@extends('layouts.my_admin_layout')
@section('title', 'Dokumen Umum')
@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <div class="container p-0">
                <h1 class="mb-3 fw-bold my-text-color">Dokumen Umum</h1>
                <div class="card">
                    <div class="card-body">
                        <table id="datatable" class="table table-bordered rounded w-100">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Pengunggah</th>
                                    <th class="text-center">Nama Dokumen</th>
                                    <th class="text-center">File</th>
                                    <th class="text-center">Kategori</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                @foreach ($data as $data)
                                    <tr>
                                        <td class="text-center">{{ $no++ }}</td>
                                        <td>{{ $data->user->name }}</td>
                                        <td>{{ $data->name }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('user.general.document', [$data->id]) }}"
                                                class="btn btn-primary"><i class="fa fa-file fa-fw"></i> Lihat</a>

                                        </td>
                                        <td>{{ $data->generalCategory->name }}</td>
                                    </tr>
                                    <?php $no++; ?>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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
