@extends('layouts.my_admin_layout')
@section('title', 'Kelola Permintaan Dokumen')
@section('content')
    <main class="content">
        <div class="container p-0">
            <h1 class="mb-3 fw-bold my-text-color">Kelola Request</h1>
            @include('components.flash-message')
            <div class="card">
                <div class="card-body">
                    <table id="datatable" class="table table-bordered rounded w-100">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Permintaan Dari</th>
                                <th class="text-center">Pesan</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Tanggal Permintaan</th>
                                <th class="text-center">Balasan</th>
                                <th class="text-center">Dokumen Dibagikan</th>
                                <th class="text-center"><i class="fa fa-cogs"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach ($data as $data)
                                <tr>
                                    <td class="text-center">{{ $no++ }}</td>
                                    <td class="text-center">{{ $data->user->name }}</td>
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
                                    <td class="text-center">{{ $data->created_at }}</td>
                                    <td class="text-center">{{ $data->response }}</td>
                                    <td class="text-center">
                                        @if ($data->status == 'approved')
                                            <a href="{{ route('admin.private-documents.preview', [$data->id]) }}"
                                                class="btn btn-primary"><i class="fa fa-file fa-fw"></i> Lihat</a>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($data->status == 'pending')
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#replyModal{{ $data->id }}">
                                                Balas
                                            </button>
                                            <form action="{{ route('admin.requests.reject', $data->id) }}" method="post"
                                                class="d-inline delete-btn">
                                                @csrf

                                                <button type="submit" class="btn btn-danger">Tolak</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                <div class="modal fade text-start" id="replyModal{{ $data->id }}" tabindex="-1"
                                    aria-labelledby="replyModalLabel{{ $data->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('admin.requests.reply', $data->id) }}" method="post">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="replyModalLabel{{ $data->id }}">Balas Permintaan Dokumen</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-start">
                                                    <div class="mb-3">
                                                        <label for="response" class="form-label">Balasan</label>
                                                        <textarea class="form-control" name="response" id="response" rows="3"
                                                            required></textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="document_id" class="form-label">Dokumen</label>
                                                        <select class="form-select" name="document_id" id="document_id" required>
                                                            <option value="">Pilih Dokumen</option>
                                                            @foreach ($documents as $document)
                                                                <option value="{{ $document->id }}">{{ $document->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Tutup</button>
                                                    <button type="submit" class="btn btn-primary">Kirim</button>
                                                </div>
                                            </form>
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
                        text: "Ingin menolak data ini",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'Tolak',
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
