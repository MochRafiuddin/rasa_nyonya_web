@extends('template')
@section('content')
<?php 
use App\Traits\Helper;  
$name[] = 'username';
$name[] = 'password';
$name[] = 'tipe_user';
$name[] = 'id_ref';
?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">{{$titlePage}} Akun</h6>
                <form action="{{$url}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="form-group col">
                            <label for="exampleInputEmail1">Username</label>
                            <input type="text" class="form-control @error($name[0]) is-invalid @enderror"
                            value="{{Helper::showData($data,$name[0])}}" name="{{$name[0]}}" />
                        </div>
                    </div>                    
                    @if($data == null)
                    <div class="row">
                        <div class="form-group col">
                            <label for="exampleInputEmail1">Password</label>
                            <input type="password" class="form-control @error($name[1]) is-invalid @enderror"
                                value="{{Helper::showData($data,$name[1])}}" name="{{$name[1]}}" />
                        </div>
                    </div>           
                    @endif         
                    <div class="row">
                        <div class="form-group col">
                            <label for="{{ $name[2] }}">Tipe User</label>
                            <select class="form-control @error($name[2]) is-invalid @enderror" name="{{$name[2]}}" id="{{$name[2]}}">
                                <option value="" selected disabled> Pilih Tipe User </option>                                
                                <option value="1"
                                {{(old($name[2]) == 1) ? 'selected' : ''}}
                                {{Helper::showDataSelected($data,$name[2],1)}}>Admin</option>
                                <option value="2"
                                {{(old($name[2]) == 2) ? 'selected' : ''}}
                                {{Helper::showDataSelected($data,$name[2],2)}}>Kurir</option>
                            </select>
                        </div>                    
                    </div>    
                    <div class="row">
                        <div class="form-group col">
                            <label for="exampleInputEmail1">User</label>
                            <select class="form-control js-example-basic-single @error($name[3]) is-invalid @enderror" name="{{$name[3]}}" id="{{$name[3]}}">
                                @if($data)
                                @foreach($id_ref as $key)
                                <option value="<?= $key->{$name[3]} ?>"
                                    {{(old($name[3]) == $key->{$name[3]}) ? 'selected' : ''}}
                                    {{Helper::showDataSelected($data,$name[3],$key->{$name[3]})}}>
                                    {{$key->nama}}
                                </option>
                                @endforeach
                                @endif
                            </select>
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
          placeholder: "Cari User",
    });
    function read_data() {
        let tipe_user = $('#tipe_user').val();
        $.ajax({
            url: "{{url('user/get-user-by-tipe')}}",
            type: "get",
            data:  {
                tipe_user : tipe_user,
            },
            dataType: "JSON",
            success: function(res){
                $('.js-example-basic-single').html(res);
            }
        });
    }
    $('#tipe_user').on('change',function(){
        read_data();
    });
</script>
@endpush