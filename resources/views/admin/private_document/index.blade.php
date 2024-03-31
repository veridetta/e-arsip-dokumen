@extends('layouts.my_admin_layout')
@section('title', 'Kelola Dokumen Khusus')
@section('content')
    <main class="content">
        <div class="container p-0">
            <h1 class="mb-3 fw-bold my-text-color">Kelola Dokumen Khusus</h1>
            @include('components.flash-message')
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mb-4 justify-content-end">
                        <a href="{{ route('admin.private-documents.create') }}" class="btn my-bg text-white p-2 px-4"><i
                                class="fa fa-plus fa-fw"></i>
                            Tambah Dokumen Khusus</a>
                    </div>
                    <table id="datatable" class="table table-bordered rounded w-100">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Pengunggah</th>
                                <th class="text-center">Nama Dokumen</th>
                                <th class="text-center">File</th>
                                <th class="text-center"><i class="fa fa-cogs"></i></th>
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
                                        <a href="{{ route('admin.private-documents.preview', [$data->id]) }}"
                                            class="btn btn-primary"><i class="fa fa-file fa-fw"></i> Lihat</a>
                                    </td>

                                    <td class="text-center">
                                        {{-- <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                            data-bs-target="#shareModal{{ $data->id }}">
                                            <i class="fa fa-share"></i>
                                        </button> --}}
                                        <a href="{{ route('admin.private-documents.edit', [$data->id]) }}"
                                            class="btn my-bg text-white"><i class="fa fa-edit"></i></a>
                                        <form action="{{ route('admin.private-documents.destroy', [$data->id]) }}"
                                            class="d-inline-block delete-btn" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"><i
                                                    class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                <div class="modal fade" id="shareModal{{ $data->id }}" tabindex="-1"
                                    aria-labelledby="shareModalLabel{{ $data->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="shareModalLabel{{ $data->id }}">Bagikan Dokumen
                                                    Khusus</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('admin.private-documents.share', [$data->id]) }}"
                                                    method="POST">
                                                    @csrf

                                                    <div class="mb-3">
                                                        <label for="user_id" class="form-label">Pilih User</label>
                                                        <select class="select2 form-select" name="user_id[]" id="user_id">
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <button type="submit" class="btn my-bg text-white">Bagikan</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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

            $('.select2').select2({
                placeholder: 'Pilih User',
                allowClear: true,
                width: '100%',
                multiple: true,
                dropdownParent: $('#shareModal{{ $data->id }}')

            });
        })
    </script>
@endsection
