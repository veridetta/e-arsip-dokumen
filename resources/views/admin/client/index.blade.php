@extends('layouts.my_admin_layout')
@section('title', 'Kelola Client')
@section('content')
    <main class="content">
        <div class="container p-0">
            <h1 class="mb-3 fw-bold my-text-color">Kelola Client</h1>
            @include('components.flash-message')
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mb-4 justify-content-end">
                        <a href="{{ route('admin.clients.create') }}" class="btn my-bg text-white p-2 px-4"><i
                                class="fa fa-plus fa-fw"></i>
                            Tambah Client</a>
                    </div>

                    <table id="datatable" class="table table-bordered rounded w-100">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Nama Perusahaan</th>
                                <th class="text-center">No Telp</th>
                                <th class="text-center">Mulai Kontrak</th>
                                <th class="text-center">Berakhir Kontrak</th>
                                <th class="text-center">File</th>
                                <th class="text-center"><i class="fa fa-cogs"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach ($data as $data)
                                <tr>
                                    <td class="text-center">{{ $no++ }}</td>
                                    <td class="text-center">{{ $data->name }}</td>
                                    <td class="text-center">{{ $data->company_name }}</td>
                                    <td class="text-center">{{ $data->phone }}</td>
                                    <td class="text-center">{{ $data->start_contract }}</td>
                                    <td class="text-center">{{ $data->end_contract }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.clients.preview', [$data->id]) }}" target="_blank"
                                            class="btn btn-primary"><i class="fa fa-file fa-fw"></i></a>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex flex-row justify-content-center">
                                            <a href="{{ route('admin.clients.edit', [$data->id]) }}"
                                                class="btn my-bg me-1 text-white"><i class="fa fa-edit"></i></a>
                                            <form action="{{ route('admin.clients.destroy', [$data->id]) }}"
                                                class="d-inline-block delete-btn" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"><i
                                                        class="fa fa-trash"></i></button>
                                            </form>
                                            <?php
                                            //halo nama, perkenalkan saya dari perusahaan kami
                                            $pesan_wa = "Halo, " . $data->name . ". Perkenalkan saya ". Auth::user()->name ." dari perusahaan".  get_my_app_config('nama_web').".";
                                            //convert $pesan_wa
                                            $pesan_wa = urlencode($pesan_wa);
                                            //format nomor whatsapp
                                            $data->phone = str_replace(' ', '', $data->phone);
                                            //ubah 0 diawal nomor menjadi 62
                                            $data->phone = '62' . substr($data->phone, 1);
                                            ?>
                                            <a href="https://wa.me/{{ $data->phone }}?text={{ $pesan_wa }}"
                                                class="btn btn-success ms-2"><i class="fa fa-brands fa-whatsapp"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <?php $no++; ?>
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
