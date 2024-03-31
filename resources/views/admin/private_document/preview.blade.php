@extends('layouts.my_admin_layout')
@section('title', 'Lihat Dokumen Khusus')
@section('content')
    <main class="content">
        <div class="container p-0">
            <h1 class="mb-3 fw-bold my-text-color">Lihat Dokumen Khusus</h1>
            @include('components.flash-message')
            <div class="card">
                <div class="card-body">
                    {{-- {{dd($data)}} --}}
                    @if($auth)
                        <?php
                        $ext = pathinfo($data->file, PATHINFO_EXTENSION);
                        ?>
                        @if ($ext == 'pdf')
                            <embed src="{{ url('storage/private-documents/' . $data->file) }}#toolbar=0" type="application/pdf"
                                width="100%" height="600px" />
                        @else
                        {{-- <div id="docx-preview" data-file="{{ '../../../storage/private-documents/' . $data->file }}"></div> --}}

                        <?php
                        $url = url('storage/private-documents/' . $data->file);
                        // $url = urlencode('https://dongenganimasi2d.my.id/1.doc');
                        $url = urlencode($url);
                        ?>
                        <iframe id="fff" src="https://view.officeapps.live.com/op/view.aspx?src={{$url}}&wdOrigin=BROWSELINK" width='100%' height='600px'></iframe>
                        @endif
                    @else
                        <div class="alert alert-danger" role="alert">
                            Anda tidak memiliki akses untuk melihat dokumen ini
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/jszip/dist/jszip.min.js"></script>
    <script src="{{url('assets/js/docx-preview.js')}}"></script>
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
            //modify http header iframe
        //     var iframe = document.getElementsByTagName('iframe');

        //     var loadke = 0;
        //     function hideRibbon() {
        //     // Menyembunyikan konten dalam iframe dengan div id "WACRibbonPanel"
        //     // $('#fff').contents().find('#WACRibbonPanel').hide();
        //     // Cek apakah konten dalam iframe sudah dimuat
        //     // Cek apakah elemen yang ingin disembunyikan telah ditemukan
        //     // Jika elemen belum ditemukan, panggil fungsi lagi setelah jeda 1 detik
        //     //infokan apa child pertama dari #fff
        //     var iframe = document.getElementsByTagName('iframe');
        //     //cari elemen dengan id wacframe
        //     if(iframe.length > 0){
        //         var wacframe = iframe[0].contentWindow.document;
        //         console.log(wacframe);
        //     }
        //     // if ($('#fff').contents().find('#wacframe').length === 0) {
        //     //     setTimeout(hideRibbon, 1000);
        //     //     console.log($('#fff').contents().find('#WACRibbonPanel').length + ' - ' + loadke);
        //     //     loadke++;
        //     //     if($('#fff').contents().length > 0){
        //     //         console.log('ada '+$('#fff').contents().find('body').html());
        //     //     }
        //     // }
        //     // Jika elemen belum ditemukan, panggil fungsi lagi setelah jeda 1 detik
        //     // if ($('#wacframe').contents().find('#WACRibbonPanel').length === 0) {
        //     //     setTimeout(hideRibbon, 500);
        //     // }
        // }

        // // Panggil fungsi pertama kali
        // hideRibbon();



        })
    </script>
@endsection
