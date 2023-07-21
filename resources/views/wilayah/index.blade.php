@extends('template')
@section('content')
<?php 
    use App\Traits\Helper;  
?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h4>Wilayah</h4><br>
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
                </div>
                <div class="row mb-4">
                    <div class="col text-right">                        
                        <a href="{{url('wilayah/create')}}" class="btn btn-info">Tambah</a>                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table w-100">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Wilayah</th>
                                        <th>Kode Wilayah</th>
                                        <th>Nama Area</th>
                                        <th>Fee</th>
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
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    @include("partial.footer")
    <!-- partial -->
</div>
@endsection
@push('js')
<script src="{{asset('/')}}assets/js/select2.js"></script>
<script>
    $('.js-example-basic-single').select2({
          placeholder: "Pilih Area",
    });
    $(document).ready(function () {
        read_data();

        function read_data() {
            $('.table').DataTable({
                processing: true,
                serverSide: true,

                "scrollX": true,
                ajax: {
                    url: '{{ url("wilayah/data") }}',
                    type: 'get',
                    data: {data:$('#id_area').val()},
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
                        data: 'nama_wilayah',
                        name: 'nama_wilayah',                        
                    },
                    {
                        data: 'kode_wilayah',
                        name: 'kode_wilayah',                        
                    },
                    {
                        data: 'area',
                        name: 'm_area.nama_area',                        
                    },
                    {
                        data: 'fee',
                        name: 'fee',                        
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

        $('#id_area').on('change',function(){
            $('.table').DataTable().destroy();
            read_data();
        });
    });
</script>
@endpush