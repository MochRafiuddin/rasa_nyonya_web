@extends('template')
@section('content')
<?php 
    use App\Traits\Helper;  
?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h4>Kurir</h4><br>
                <div class="row">                
                    <div class="form-group col-4">
                        <label for="exampleInputEmail1">Area</label>
                        <select class="form-control js-example-basic-single" name="id_area" id="id_area">
                            <option value="0" selected> Semua Area </option>                                
                            @foreach($area as $key)
                            <option value="{{$key->id_area}}">{{$key->nama_area}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-4">
                        <label for="exampleInputEmail1">Wilayah</label>
                        <select class="form-control js-example-basic-single" name="id_wilayah" id="id_wilayah">
                            <option value="0" selected> Semua Wilayah </option>                                
                            @foreach($wilayah as $key)
                            <option value="{{$key->id_wilayah}}">{{$key->nama_wilayah}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col text-right">                        
                        <a href="{{url('courier/create')}}" class="btn btn-info">Tambah</a>                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table w-100">
                                <thead>
                                    <tr>
                                        <th>No</th>                                        
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>No Hp</th>
                                        <th>Area</th>
                                        <th>Wilayah</th>
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

        $('#id_area ,#id_wilayah').select2();

        function read_data() {
            $('.table').DataTable({
                processing: true,
                serverSide: true,

                "scrollX": true,
                ajax: {
                    url: '{{ url("courier/data") }}',
                    type: 'get',
                    data: {area:$('#id_area').val(), wilayah:$('#id_wilayah').val()},
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
                        name: 'nama',
                    },
                    {
                        data: 'alamat',
                        name: 'alamat',
                    },
                    {
                        data: 'no_hp',
                        name: 'no_hp',
                    },
                    {
                        data: 'nama_area',
                        name: 'm_area.nama_area',
                    },
                    {
                        data: 'nama_wilayah',
                        name: 'm_wilayah.nama_area',
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

        $('#id_wilayah').on('change',function(){
            $('.table').DataTable().destroy();
            read_data();
        });
    });
</script>
@endpush