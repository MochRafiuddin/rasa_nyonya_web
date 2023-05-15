@extends('template')
@section('content')
<?php 
    use App\Traits\Helper;  
?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h4>Courier Performance</h4><br>
                
                <div class="row mb-4">
                    <div class="form-group col-md-5">
                        <label for="">Tanggal</label>
                        <input class="form-control" type="text" name="tanggal" id="tanggal" value="{{$tanggal}}">
                    </div>                    
                    <div class="form-group col-md-5">
                        <label for="">Tipe</label>
                        <select name="tipe" id="tipe" class="form-control">
                            <option value="1">Dropp off time</option>
                            <option value="2">Amount of delivery</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table w-100">                                
                            </table>
                        </div>
                    </div>
                </div>
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
        load_tabel();

        function load_tabel() {
            if ($('#tipe').val() == 1) {
                read_data();
            }else{
                read_data1();
            }
        }

        function read_data() {
            $('.table').html('<thead><tr>\
                            <th>No</th>\
                            <th>Nama Kurir</th>\
                            <th>Wilayah</th>\
                            <th>Total Ontime</th>\
                            <th>Total Delivery</th>\
                        </tr><thead>');
            $('.table').DataTable({
                processing: true,
                serverSide: true,

                "scrollX": true,
                ajax: {
                    url: '{{ url("courier-performance/data") }}',
                    type: 'get',
                    data: {data:$('#tanggal').val(),tipe:$('#tipe').val()},
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
                        data: 'nama_courier',
                        name: 'a.nama',                        
                    },
                    {
                        data: 'nama_wilayah',
                        name: 'b.nama_wilayah',     
                    },
                    {
                        data: 'total_on_time',
                        name: 'total_on_time',
                        searchable: false
                    },
                    {
                        data: 'total_delivery',
                        name: 'total_delivery',
                        searchable: false
                    }
                ]
            });
        }
        function read_data1() {
            $('.table').html('<thead><tr>\
                            <th>No</th>\
                            <th>Nama Kurir</th>\
                            <th>Wilayah</th>\
                            <th>Total Delivery</th>\
                        </tr><thead>');
            $('.table').DataTable({
                processing: true,
                serverSide: true,

                "scrollX": true,
                ajax: {
                    url: '{{ url("courier-performance/data") }}',
                    type: 'get',
                    data: {data:$('#tanggal').val(),tipe:$('#tipe').val()},
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
                        data: 'nama_courier',
                        name: 'a.nama',                        
                    },
                    {
                        data: 'nama_wilayah',
                        name: 'b.nama_wilayah',     
                    },                    
                    {
                        data: 'total_delivery',
                        name: 'total_delivery',
                        searchable: false
                    }
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

        $('#tipe').on('change', function() {
            $('.table').DataTable().destroy();
            $('.table').html('')
            load_tabel();
        });

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
            $('.table').html('')
            load_tabel();
        });

        $('#tanggal').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

    });
    

</script>
@endpush