@extends('template')
@section('content')
<?php 
    use App\Traits\Helper;  
?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h4>Order</h4><br>
                <div class="row mb-4">
                    <div class="col text-right">                        
                        <button class="btn btn-warning btn-import">Import</button>
                        <a href="{{url('order/create')}}" class="btn btn-info">Tambah</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table w-100">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Customer</th>
                                        <th>Wilayah</th>
                                        <th>Tanggal Order</th>
                                        <th>Kurir</th>
                                        <th>Tanggal Terkirim</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalImport" tabindex="-1" role="dialog" aria-labelledby="modalImportTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalImportTitle">Import Excel</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <form class="form-horizontal" role="form" id="formForm" method="post"
                action="{{url('order/import')}}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form_group">
                      <label>Format Excel</label>
                      <p><a href="{{ asset('download/Format upload customer - rasa nyonya.xlsx') }}">Download Format Excel</a></p>
                  </div>
                  <br>
                  <div class="form_group" id="file">
                      <label>File</label>
                      <input type="file" class="form-control" name="excel_file"  accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" >
                  </div>
                  <div class="msg"></div>
                  <div class="loading" style="display: none;">
                     <div class="jumping-dots-loader">
                         <span></span>
                         <span></span>
                         <span></span>
                     </div>
                  </div>
                 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-import">Import</button>
                </div>
            </form>
        </div>
      </div>
    </div>
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    @include("partial.footer")
    <!-- partial -->
</div>
@endsection
@push('js')
<script>
    $(document).ready(function () {
        read_data();

        function read_data() {
            $('.table').DataTable({
                processing: true,
                serverSide: true,

                "scrollX": true,
                ajax: {
                    url: '{{ url("order/data") }}',
                },
                rowReorder: {
                    selector: 'td:nth-child(1)'
                },

                responsive: true,
                columns: [{
                        "data": 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        width: '4%',
                        className: 'text-center'
                    },
                    {
                        data: 'nama_customer',
                        name: 'm_customer.nama',                        
                    },
                    {
                        data: 'wilayah',
                        name: 'm_wilayah.nama_wilayah',                        
                    },
                    {
                        data: 'tanggal_order',
                        name: 'tanggal_order',
                    },
                    {
                        data: 'kurir',
                        name: 'kurir',
                        searchable: false
                    },
                    {
                        data: 'tanggal_tiba',
                        name: 'tanggal_tiba',
                    },
                    {
                        data: 'nama_status',
                        name: 'm_status.nama_status',                        
                    },                                        
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        }
         $(document).on('click','.delete',function(e){
            e.preventDefault();
            Swal.fire({
                title: 'Kamu Yakin?',
                text: "Menghapus data ini",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
                }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = $(this).attr('href');
                }
                })
        })
    $("#formForm").on('submit',(function(e) {
        $(".loading").css('display','block');
        $('#file').css('display','none');
        $('.btn-import').attr('disabled','disabled');
        $(".msg").html("");
        e.preventDefault();
        $.ajax({
            url: "{{url('order/import')}}",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function(data){
                $('#file').css('display','block');
                $('.btn-import').removeAttr('disabled');
                $(".loading").css('display','none');
                if(data.status){
                    if(data.error == 0){
                        console.log(data);
                        $('.table').DataTable().destroy();
                        read_data();
                        $(".msg").html('<div class="alert alert-success alert-sm mt-2">'+data.msg_import+'</div>');
                    }else{
                        $(".msg").html('<div class="alert alert-danger alert-sm mt-2">'+data.msg_import+'</div>');
                    }
                }
            }
        });
    }));

    });

    $('body').on('click', '.btn-import', function () { 
        $('#modalImport').modal('show');        
    });

</script>
@endpush