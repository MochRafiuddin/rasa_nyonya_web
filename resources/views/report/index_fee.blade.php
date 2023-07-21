@extends('template')
@section('content')
<?php 
    use App\Traits\Helper;  
?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h4>Courier Fee</h4><br>
                
                <div class="row mb-4">
                    <div class="form-group col-md-5">
                        <label for="">Tanggal</label>
                        <input class="form-control" type="text" name="tanggal" id="tanggal" value="{{$tanggal}}">
                    </div>                                        
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table w-100">    
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kurir</th>
                                    <th>Wilayah</th>
                                    <th>Total Fee</th>
                                    <th>Opsi</th>
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
        read_data();         

        function read_data() {            
            $('.table').DataTable({
                processing: true,
                serverSide: true,

                "scrollX": true,
                ajax: {
                    url: '{{ url("courier-fee/data") }}',
                    type: 'get',
                    data: {data:$('#tanggal').val()},
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
                        data: 'total_fee',
                        name: 'total_fee',
                        searchable: false
                    },
                    {
                        data: 'opsi',
                        name: 'opsi',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        }        

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

    });
    

</script>
@endpush