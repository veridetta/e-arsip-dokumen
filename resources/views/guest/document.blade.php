@extends('layouts.my_layout')
@section('title', 'Lihat Dokumen')
@section('content')
    <main class="content">
        <div class="container p-0 mt-4 mb-4">
            {{-- <h1 class="mb-3 fw-bold my-text-color">Lihat Dokumen</h1> --}}
            {{-- @include('components.flash-message') --}}
            @include('components.flash-message')
            <div class="card">
                <div class="card-body">
                    <?php
                        $ext = pathinfo($data->file, PATHINFO_EXTENSION);
                        ?>
                        @if ($ext == 'pdf')
                            <embed src="{{ url('storage/general-documents/' . $data->file) }}#toolbar=0" type="application/pdf"
                                width="100%" height="600px" />
                        @else
                        {{-- <div id="docx-preview" data-file="{{ '../../../storage/private-documents/' . $data->file }}"></div> --}}

                        <?php
                        $url = url('storage/general-documents/' . $data->file);
                        // $url = urlencode('https://dongenganimasi2d.my.id/1.doc');
                        $url = urlencode($url);
                        ?>
                        <iframe id="fff" src="https://view.officeapps.live.com/op/view.aspx?src={{$url}}&wdOrigin=BROWSELINK" width='100%' height='600px'></iframe>
                        @endif
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
