@extends('template')
@section('content')
<?php 
use App\Traits\Helper;  
$name[] = 'nama_wilayah';
$name[] = 'kode_wilayah';
$name[] = 'id_area';
$name[] = 'fee';
?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">{{$titlePage}} Wilayah</h6>
                <form action="{{$url}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="form-group col">
                            <label for="{{ $name[2] }}">Area</label>
                            <select class="form-control @error($name[2]) is-invalid @enderror" name="{{$name[2]}}" id="{{$name[2]}}">
                                <option value="" selected disabled> Pilih Area </option>
                                @foreach($area as $key)
                                <option value="<?= $key->{$name[2]} ?>"
                                    {{(old($name[2]) == $key->{$name[2]}) ? 'selected' : ''}}
                                    {{Helper::showDataSelected($data,$name[2],$key->{$name[2]})}}>
                                    {{$key->nama_area}}
                                </option>
                                @endforeach
                            </select>
                        </div>                    
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label for="exampleInputEmail1">Kode</label>
                            <input type="text" class="form-control @error($name[1]) is-invalid @enderror"
                                value="{{Helper::showData($data,$name[1])}}" name="{{$name[1]}}" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label for="exampleInputEmail1">Nama</label>
                            <input type="text" class="form-control @error($name[0]) is-invalid @enderror"
                                value="{{Helper::showData($data,$name[0])}}" name="{{$name[0]}}" />
                        </div>
                    </div>                    
                    <div class="row">
                        <div class="form-group col">
                            <label for="exampleInputEmail1">Fee</label>
                            <input type="text" class="form-control numeric @error($name[3]) is-invalid @enderror"
                                value="{{Helper::showData($data,$name[3])}}" name="{{$name[3]}}" />
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
    $('#id_area').select2({
          placeholder: "Pilih Area",
    });
</script>
@endpush