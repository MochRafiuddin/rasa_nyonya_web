@extends('template')
@section('content')
<?php 
use App\Traits\Helper;  
$name[] = 'nama';
$name[] = 'no_hp';
$name[] = 'alamat';
$name[] = 'id_area';
$name[] = 'id_wilayah';
?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">{{$titlePage}} Kurir</h6>
                <form action="{{$url}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="form-group col">
                            <label for="exampleInputEmail1">Nama</label>
                            <input type="text" class="form-control @error($name[0]) is-invalid @enderror"
                            value="{{Helper::showData($data,$name[0])}}" name="{{$name[0]}}" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label for="exampleInputEmail1">No Hp</label>
                            <input type="text" class="form-control @error($name[1]) is-invalid @enderror"
                            value="{{Helper::showData($data,$name[1])}}" name="{{$name[1]}}" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label for="{{ $name[3] }}">Area</label>
                            <select class="form-control @error($name[3]) is-invalid @enderror" name="{{$name[3]}}" id="{{$name[3]}}">
                                <option value="" selected disabled> Pilih Area </option>
                                @foreach($area as $key)
                                <option value="<?= $key->{$name[3]} ?>"
                                    {{(old($name[3]) == $key->{$name[3]}) ? 'selected' : ''}}
                                    {{Helper::showDataSelected($data,$name[3],$key->{$name[3]})}}>
                                    {{$key->nama_area}}
                                </option>
                                @endforeach
                            </select>
                        </div>                    
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label for="{{ $name[4] }}">Wilayah</label>
                            <select class="form-control @error($name[4]) is-invalid @enderror" name="{{$name[4]}}" id="{{$name[4]}}">
                                <option value="" selected disabled> Pilih Wilayah </option>
                                @if($data)
                                @foreach($wilayah as $key)
                                <option value="<?= $key->{$name[4]} ?>"
                                    {{(old($name[4]) == $key->{$name[4]}) ? 'selected' : ''}}
                                    {{Helper::showDataSelected($data,$name[4],$key->{$name[4]})}}>
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
                            <textarea type="text" class="form-control @error($name[2]) is-invalid @enderror"
                                cols="5" rows="6" value=""
                                name="{{$name[2]}}">{{Helper::showData($data,$name[2])}}</textarea>
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
    $('#id_area ,#id_wilayah').select2();

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