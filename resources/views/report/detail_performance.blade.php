@extends('template')
@section('content')
<?php 
    use App\Traits\Helper;  
?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h4>Courier Performance Detail - {{$courier->nama}} - {{$courier->nama_wilayah}}</h4><br>
                
                <div class="row mb-2">
                    <div class="form-group col-md-3">
                        <label for="">Tanggal</label>
                        <input class="form-control" type="text" name="tanggal" id="tanggal" value="{{$tanggal}}">
                    </div>                    
                    <div class="form-group col-md-3">
                        <label for="">Jenis Pengantaran</label>
                        <select name="jenis" id="jenis" class="form-control">
                            <option value="0">All</option>
                            <option value="1">Makan Siang</option>
                            <option value="2">Makan Malam</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-12 text-center">
                        <p class="h5 total-performance"></p>
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
                                    <th>Jenis Pengantaran</th>
                                    <th>Tanggal Pemesanan</th>
                                    <th>Waktu Courier Tiba</th>
                                    <th>Status</th>
                                </tr>
                            <thead>                               
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
        set_total();

        function set_total() {
            var tanggal = $('#tanggal').val();
            var jenis = $('#jenis').val();
            var id_courier = "<?php echo $courier->id_courier;?>"
            $.ajax({
                url: "{{url('courier-performance/get-total-performance')}}",
                type: "get",
                data:  {
                    tanggal:tanggal,jenis:jenis,id_courier:id_courier
                },
                dataType: "JSON",
                success: function(res){
                    $('.total-performance').html("Total On time : "+res.ontime+" | Total Delivery : "+res.deliver);
                }
            });
        }
        function load_tabel() {
            var tanggal = $('#tanggal').val();
            var jenis = $('#jenis').val();
            var id_courier = "<?php echo $courier->id_courier;?>"
            $('.table').DataTable({
                processing: true,
                serverSide: true,

                "scrollX": true,
                ajax: {
                    url: '{{ url("courier-performance/data-detail") }}',
                    type: 'get',
                    data: {tanggal:tanggal,jenis:jenis,id_courier:id_courier},
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
                        data: 'nama',
                        name: 'm_customer.nama',                        
                    },
                    {
                        data: 'jenis_pengantaran',
                        name: 'jenis_pengantaran',     
                    },
                    {
                        data: 'tanggal_pemesanan',
                        name: 'tanggal_pemesanan',
                        searchable: false
                    },
                    {
                        data: 'waktu_courier_tiba',
                        name: 'waktu_courier_tiba',
                        searchable: false
                    },
                    {
                        data: 'status',
                        name: 'status',
                        searchable: false
                    }
                ]
            });
        }

        $('#jenis').on('change', function() {
            $('.table').DataTable().destroy();            
            set_total();
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
            set_total();
            load_tabel();
        });

        $('#tanggal').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

    });
    

</script>
@endpush