@extends('template')
@section('content')
<?php 
    use App\Traits\Helper;  
?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h4>Delivery</h4><br>
                <div class="row">                
                    <div class="form-group col-3">
                        <label for="">Tanggal</label>
                        <input class="form-control" type="text" name="tanggal" id="tanggal" value="{{$tanggal}}">
                    </div>
                    <div class="form-group col-3">
                        <label for="exampleInputEmail1">Customer</label>
                        <select class="form-control js-example-basic-single" name="id_customer" id="id_customer">
                            <option value="0" selected> Semua customer </option>                                
                            @foreach($customer as $key)
                            <option value="{{$key->id_customer}}">{{$key->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-3">
                        <label for="exampleInputEmail1">Area</label>
                        <select class="form-control js-example-basic-single" name="id_area" id="id_area">
                            <option value="0" selected> Semua Area </option>                                
                            @foreach($area as $key)
                            <option value="{{$key->id_area}}">{{$key->nama_area}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-3">
                        <label for="exampleInputEmail1">Wilayah</label>
                        <select class="form-control js-example-basic-single" name="id_wilayah" id="id_wilayah">
                            <option value="0" selected> Semua Wilayah </option>                                
                            @foreach($wilayah as $key)
                            <option value="{{$key->id_wilayah}}">{{$key->nama_wilayah}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label style='font-size: 0.875rem;line-height: 1;vertical-align: top;margin-bottom: .5rem;'>Status</label><br>
                        <div class="custom-control custom-checkbox custom-control-inline">
                            <input type="checkbox" id="checkboxAb1" name="checkboxAb[]" class="custom-control-input checkboxB" value='1' checked>
                            <label class="custom-control-label" for="checkboxAb1">New</label>
                        </div>
                        <div class="custom-control custom-checkbox custom-control-inline">
                            <input type="checkbox" id="checkboxAb2" name="checkboxAb[]" class="custom-control-input checkboxB" value='2' checked>
                            <label class="custom-control-label" for="checkboxAb2">Pick Order</label>
                        </div>
                        <div class="custom-control custom-checkbox custom-control-inline">
                            <input type="checkbox" id="checkboxAb3" name="checkboxAb[]" class="custom-control-input checkboxB" value='3' checked>
                            <label class="custom-control-label" for="checkboxAb3">Delivered</label>
                        </div>
                        <div class="custom-control custom-checkbox custom-control-inline">
                            <input type="checkbox" id="checkboxAb4" name="checkboxAb[]" class="custom-control-input checkboxB" value='4' checked>
                            <label class="custom-control-label" for="checkboxAb4">Accept</label>
                        </div>
                        <div class="custom-control custom-checkbox custom-control-inline">
                            <input type="checkbox" id="checkboxAb5" name="checkboxAb[]" class="custom-control-input checkboxB" value='5' checked>
                            <label class="custom-control-label" for="checkboxAb5">Reject</label>
                        </div>
                    </div>
                </div>
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
                                        <th>Opsi</th>
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
                      <p><a href="{{ asset('download/Format Upload Delivery - rasa nyonya.xlsx') }}">Download Format Excel</a></p>
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
<script src="{{ asset('/') }}assets/vendors/daterangepicker/daterangepicker.min.js"></script>
<script>
    $(document).ready(function () {
        read_data();

        $('#id_area, #id_wilayah, #id_customer').select2();

        function read_data() {
            var testval = $('input:checkbox:checked.checkboxB').map(function(){
            return this.value; }).get().join(",");
            $('.table').DataTable({
                processing: true,
                serverSide: true,
                "order": [[ 3, "asc" ]],
                "scrollX": true,
                ajax: {
                    url: '{{ url("order/data") }}',
                    type: 'get',
                    data: {area:$('#id_area').val(), wilayah:$('#id_wilayah').val(), customer:$('#id_customer').val(), date:$('#tanggal').val(), status:testval},
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
                        name: 'tanggal_pemesanan',
                    },
                    {
                        data: 'kurir',
                        name: 'id_courier',
                        searchable: false
                    },
                    {
                        data: 'tanggal_tiba',
                        name: 'waktu_courier_tiba',
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

        $('#tanggal').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear',
                format: 'DD-MM-YYYY',
            }
        });

        $('#tanggal').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
            $('.table').DataTable().destroy();            
            read_data();
        });

        $('#tanggal').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

        function data_wilayah() {
            let id_area = $('#id_area').val();
            $.ajax({
                url: "{{url('courier/get-wilayah-by-area-filter')}}",
                type: "get",
                data:  {
                    id_area : id_area,
                },
                dataType: "JSON",
                success: function(res){
                    $('#id_wilayah').html(res);
                }
            });
        }

        $('#id_area').on('change',function(){
            data_wilayah();
            $('.table').DataTable().destroy();
            read_data();
        });

        $('#id_wilayah, .checkboxB, #id_customer').on('change',function(){
            $('.table').DataTable().destroy();
            read_data();
        });
    });

    $('body').on('click', '.btn-import', function () { 
        $('#modalImport').modal('show');        
    });

</script>
@endpush