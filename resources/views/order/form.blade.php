@extends('template')
@section('content')
<?php 
use App\Traits\Helper;  
$name[] = 'id_customer';
$name[] = 'jenis_pengantaran';
$name[] = 'tanggal_pemesanan';
$name[] = 'jenis_paket';
$name[] = 'id_area';
$name[] = 'id_wilayah';
$name[] = 'alamat';
$name[] = 'keterangan';
?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">{{$titlePage}} Delivery</h6>
                @if(Session::has('msg'))
                <div class="alert alert-danger alert-sm mt-2">{{ Session::get('msg') }}</div>
                @endif
                <form action="{{$url}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="form-group col">
                            <label for="exampleInputEmail1">Customer</label>
                            <select class="form-control js-example-basic-single @error($name[0]) is-invalid @enderror" name="{{$name[0]}}" id="{{$name[0]}}">                     
                            <option value="" selected disabled> Pilih Customer </option>                                
                                @foreach($customer as $key)
                                <option value="<?= $key->{$name[0]} ?>"
                                    {{(old($name[0]) == $key->{$name[0]}) ? 'selected' : ''}}
                                    {{Helper::showDataSelected($data,$name[0],$key->{$name[0]})}}>
                                    {{$key->nama}}
                                </option>
                                @endforeach                                
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label for="{{ $name[1] }}">Jam Pengantaran</label>
                            <select class="form-control @error($name[1]) is-invalid @enderror" name="{{$name[1]}}" id="{{$name[1]}}">
                                <option value="" selected disabled> Pilih Jam </option>                                
                                <option value="1"
                                {{(old($name[1]) == 1) ? 'selected' : ''}}
                                {{Helper::showDataSelected($data,$name[1],1)}}>Makan Siang</option>
                                <option value="2"
                                {{(old($name[1]) == 2) ? 'selected' : ''}}
                                {{Helper::showDataSelected($data,$name[1],2)}}>Makan Malam</option>
                            </select>
                        </div>                    
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label for="exampleInputEmail1">Tanggal</label>
                            <?php
                                if($data != null){
                                    $tgl=date('d-m-Y',strtotime($data->tanggal_pemesanan));
                                }else{
                                    $tgl='';
                                }
                            ?>
                            <input type="text" class="form-control @error($name[2]) is-invalid @enderror"
                            value="{{$tgl}}" name="{{$name[2]}}" id="{{$name[2]}}" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label for="exampleInputEmail1">Jenis Paket</label>                            
                            <input type="text" class="form-control @error($name[3]) is-invalid @enderror"
                            value="{{Helper::showData($data,$name[3])}}" name="{{$name[3]}}" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label for="{{ $name[4] }}">Area</label>
                            <select class="form-control @error($name[4]) is-invalid @enderror" name="{{$name[4]}}" id="{{$name[4]}}">
                                <option value="" selected disabled> Pilih Area </option>
                                @foreach($area as $key)
                                <option value="<?= $key->{$name[4]} ?>"
                                    {{(old($name[4]) == $key->{$name[4]}) ? 'selected' : ''}}
                                    {{Helper::showDataSelected($data,$name[4],$key->{$name[4]})}}>
                                    {{$key->nama_area}}
                                </option>
                                @endforeach
                            </select>
                        </div>                    
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label for="{{ $name[5] }}">Wilayah</label>
                            <select class="form-control @error($name[5]) is-invalid @enderror" name="{{$name[5]}}" id="{{$name[5]}}">
                                <option value="" selected disabled> Pilih Wilayah </option>
                                @if($data)
                                @foreach($wilayah as $key)
                                <option value="<?= $key->{$name[5]} ?>"
                                    {{(old($name[5]) == $key->{$name[5]}) ? 'selected' : ''}}
                                    {{Helper::showDataSelected($data,$name[5],$key->{$name[5]})}}>
                                    {{$key->nama_wilayah}}
                                </option>
                                @endforeach
                                @endif
                            </select>
                        </div>                    
                    </div>    
                    <div class="row">
                        <div class="form-group col">
                            <label for="exampleInputEmail1">Alamat</label>
                            <textarea type="text" class="form-control @error($name[6]) is-invalid @enderror"
                                cols="5" rows="6" value=""
                                name="{{$name[6]}}">{{Helper::showData($data,$name[6])}}</textarea>
                        </div>
                    </div>
                    <div class="row">                        
                        <div class="form-group col">
                            <label for="exampleInputEmail1">Keterangan</label>
                            <textarea type="text" class="form-control @error($name[7]) is-invalid @enderror"
                                cols="5" rows="6" value=""
                                name="{{$name[7]}}">{{Helper::showData($data,$name[7])}}</textarea>
                        </div>                        
                    </div>
                    <input type="submit" class="btn btn-success" value="Simpan" />
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@push('js')
<script src="{{asset('/')}}assets/js/select2.js"></script>
<script>        
    $('.js-example-basic-single').select2({
          placeholder: "Cari Customer",
    });
    $('#id_area, #id_wilayah').select2();

    $('#tanggal_pemesanan').datepicker({
        format: 'dd-mm-yyyy',
        startDate: '1d',
    });
    function read_data() {
        let id_area = $('#id_area').val();
        $.ajax({
            url: "{{url('courier/get-wilayah-by-area')}}",
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
        read_data();
    });
</script>
@endpush