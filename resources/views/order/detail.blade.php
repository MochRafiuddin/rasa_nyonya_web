@push('css-app')    
<style>
select.form-control:not([size]):not([multiple]) {
  height: calc(2.7rem + 2px) !important;
  color: #000;
  background: #fff;
  -webkit-appearance: none;
  -moz-appearance: none;
  text-indent: 1px;
  text-overflow: '';
}

.form-control:disabled{
	background: #fff;
    color: #000 !important;  
}

.table-border tbody td {    
    border-left: 0px !important;
    border-right: 0px !important;
    border-top: 2px solid #999 !important;
    border-bottom: 2px solid #999 !important;
}
</style>
@endpush
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
$name[] = 'id_courier';
$name[] = 'id_status';
?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">{{$titlePage}} Order</h6>
                @if($data->id_status < 4)
                <div>
                    @csrf
                    <div class="row">
                        <div class="form-group col">
                            <label for="exampleInputEmail1">Kurir</label>
                            <input type="hidden" name="id_order" value="{{$data->id_order}}" id="id_order">
                            @if($data->id_status == 1)
                            <Input type='text' class="form-control" name="{{$name[8]}}" id="{{$name[8]}}" disabled/>
                            @else
                            <select class="form-control @error($name[8]) is-invalid @enderror" name="{{$name[8]}}" id="{{$name[8]}}" disabled>
                                @foreach($courier as $key)
                                <option value="<?= $key->{$name[8]} ?>"
                                    {{(old($name[8]) == $key->{$name[8]}) ? 'selected' : ''}}
                                    {{Helper::showDataSelected($data,$name[8],$key->{$name[8]})}}>
                                    {{$key->nama}} - {{$key->no_hp}}
                                </option>
                                @endforeach                                
                            </select>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label for="exampleInputEmail1">Status</label>
                            <select class="form-control @error($name[9]) is-invalid @enderror" name="{{$name[9]}}" id="{{$name[9]}}" disabled>
                                @foreach($status as $key)
                                <option value="<?= $key->{$name[9]} ?>"
                                    {{(old($name[9]) == $key->{$name[9]}) ? 'selected' : ''}}
                                    {{Helper::showDataSelected($data,$name[9],$key->{$name[9]})}}>
                                    {{$key->nama_status}}
                                </option>
                                @endforeach                                
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label for="exampleInputEmail1">Tanggal</label>
                            <?php                                
                                $tgl=date('d-m-Y',strtotime($data->tanggal_pemesanan));                                
                            ?>
                            <input type="text" class="form-control @error($name[2]) is-invalid @enderror"
                            value="{{$tgl}}" name="{{$name[2]}}" id="{{$name[2]}}" disabled/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label for="{{ $name[1] }}">Jam Pengantaran</label>
                            <select class="form-control @error($name[1]) is-invalid @enderror" name="{{$name[1]}}" id="{{$name[1]}}" disabled>
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
                            <label for="exampleInputEmail1">Customer</label>
                            <select class="form-control @error($name[0]) is-invalid @enderror" name="{{$name[0]}}" id="{{$name[0]}}" disabled>
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
                            <label for="exampleInputEmail1">No Telefon</label>
                            <input type="text" class="form-control @error($name[3]) is-invalid @enderror"
                            value="{{$cus->no_hp}}" name="nohpcus" disabled/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label for="exampleInputEmail1">Jenis Paket</label>
                            <input type="text" class="form-control @error($name[3]) is-invalid @enderror"
                            value="{{Helper::showData($data,$name[3])}}" name="{{$name[3]}}" disabled/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label for="{{ $name[4] }}">Area</label>
                            <select class="form-control @error($name[4]) is-invalid @enderror" name="{{$name[4]}}" id="{{$name[4]}}" disabled>
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
                            <select class="form-control @error($name[5]) is-invalid @enderror" name="{{$name[5]}}" id="{{$name[5]}}" disabled>
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
                                name="{{$name[6]}}" disabled>{{Helper::showData($data,$name[6])}}</textarea>
                        </div>
                    </div>
                    <div class="row">                        
                        <div class="form-group col">
                            <label for="exampleInputEmail1">Keterangan</label>
                            <textarea type="text" class="form-control @error($name[7]) is-invalid @enderror"
                                cols="5" rows="6" value=""
                                name="{{$name[7]}}" disabled>{{Helper::showData($data,$name[7])}}</textarea>
                        </div>                        
                    </div>
                </div>
                @else
                <div>
                    <div class="row">
                        <div class="form-group col">
                            <label for="exampleInputEmail1">Courier</label>
                            <select class="form-control @error($name[8]) is-invalid @enderror" name="{{$name[8]}}" id="{{$name[8]}}" disabled>
                                @foreach($courier as $key)
                                <option value="<?= $key->{$name[8]} ?>"
                                    {{(old($name[8]) == $key->{$name[8]}) ? 'selected' : ''}}
                                    {{Helper::showDataSelected($data,$name[8],$key->{$name[8]})}}>
                                    {{$key->nama}} - {{$key->no_hp}}
                                </option>
                                @endforeach                                
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label for="exampleInputEmail1">Status</label>
                            <select class="form-control @error($name[9]) is-invalid @enderror" name="{{$name[9]}}" id="{{$name[9]}}" disabled>
                                @foreach($status as $key)
                                <option value="<?= $key->{$name[9]} ?>"
                                    {{(old($name[9]) == $key->{$name[9]}) ? 'selected' : ''}}
                                    {{Helper::showDataSelected($data,$name[9],$key->{$name[9]})}}>
                                    {{$key->nama_status}}
                                </option>
                                @endforeach                                
                            </select>
                        </div>
                    </div>
                    <div class="row">                    
                        <div class="form-group col">
                            <label for="exampleInputEmail1">Tanggal</label>
                            <?php                                
                                $tgl=date('d-m-Y',strtotime($data->tanggal_pemesanan));                                
                            ?>
                            <input type="text" class="form-control @error($name[2]) is-invalid @enderror"
                            value="{{$tgl}}" name="{{$name[2]}}" id="{{$name[2]}}" disabled/>
                        </div>                    
                        <div class="form-group col-6">
                            <label for="{{ $name[1] }}">Jam Pengantaran</label>
                            <select class="form-control @error($name[1]) is-invalid @enderror" name="{{$name[1]}}" id="{{$name[1]}}" disabled>
                                <option value="" selected disabled> Pilih Jam </option>                                
                                <option value="1"
                                {{(old($name[1]) == 1) ? 'selected' : ''}}
                                {{Helper::showDataSelected($data,$name[1],1)}}>Makan Siang</option>
                                <option value="2"
                                {{(old($name[1]) == 2) ? 'selected' : ''}}
                                {{Helper::showDataSelected($data,$name[1],2)}}>Makan Malam</option>
                            </select>
                        </div>                                        
                        <div class="form-group col-6">
                            <label for="exampleInputEmail1">Customer</label>
                            <select class="form-control @error($name[0]) is-invalid @enderror" name="{{$name[0]}}" id="{{$name[0]}}" disabled>
                                @foreach($customer as $key)
                                <option value="<?= $key->{$name[0]} ?>"
                                    {{(old($name[0]) == $key->{$name[0]}) ? 'selected' : ''}}
                                    {{Helper::showDataSelected($data,$name[0],$key->{$name[0]})}}>
                                    {{$key->nama}}
                                </option>
                                @endforeach                                
                            </select>
                        </div>                    
                        <div class="form-group col-6">
                            <label for="exampleInputEmail1">No Telefon</label>
                            <input type="text" class="form-control @error($name[3]) is-invalid @enderror"
                            value="{{$cus->no_hp}}" name="nohpcus" disabled/>
                        </div>                    
                        <div class="form-group col-6">
                            <label for="exampleInputEmail1">Jenis Paket</label>
                            <input type="text" class="form-control @error($name[3]) is-invalid @enderror"
                            value="{{Helper::showData($data,$name[3])}}" name="{{$name[3]}}" disabled/>
                        </div>                    
                        <div class="form-group col-6">
                            <label for="{{ $name[4] }}">Area</label>
                            <select class="form-control @error($name[4]) is-invalid @enderror" name="{{$name[4]}}" id="{{$name[4]}}" disabled>
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
                        <div class="form-group col-6">
                            <label for="{{ $name[5] }}">Wilayah</label>
                            <select class="form-control @error($name[5]) is-invalid @enderror" name="{{$name[5]}}" id="{{$name[5]}}" disabled>
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
                        <div class="form-group col-6">
                            <label for="exampleInputEmail1">Alamat</label>
                            <textarea type="text" class="form-control @error($name[6]) is-invalid @enderror"
                                cols="5" rows="6" value=""
                                name="{{$name[6]}}" disabled>{{Helper::showData($data,$name[6])}}</textarea>
                        </div>                                          
                        <div class="form-group col-6">
                            <label for="exampleInputEmail1">Keterangan</label>
                            <textarea type="text" class="form-control @error($name[7]) is-invalid @enderror"
                                cols="5" rows="6" value=""
                                name="{{$name[7]}}" disabled>{{Helper::showData($data,$name[7])}}</textarea>
                        </div>                        
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="exampleInputEmail1">Waktu Kurir Tiba</label>
                            <?php 
                            if ($data->waktu_courier_tiba != null) {
                                $tgl1=date('d-m-Y H:i',strtotime($data->waktu_courier_tiba));                                
                            }else {
                                $tgl1='';
                            }
                            ?>
                            <input type="text" class="form-control @error($name[6]) is-invalid @enderror"
                            value="{{$tgl1}}" name="waktu_kurir" disabled/>
                        </div>
                        <div class="form-group col-6">
                            <label for="exampleInputEmail1">Koordinat</label>
                            <input type="text" class="form-control @error($name[6]) is-invalid @enderror"
                            value="{{$data->latitude}},{{$data->longitude}}" name="koordinat" disabled/>
                            <input type="hidden" value="{{$data->latitude}}" id="latitude"/>
                            <input type="hidden" value="{{$data->longitude}}" id="longitude"/>
                        </div>
                        <div class="form-group col-6">
                            <label for="exampleInputEmail1">Catatan</label>
                            <textarea type="text" class="form-control @error($name[7]) is-invalid @enderror"
                                cols="5" rows="6" value=""
                                name="{{$name[7]}}" disabled>{{$data->catatan_courier}}</textarea>
                        </div>
                        @if($data->id_status == 5)
                        <div class="form-group col-6">
                            <label for="exampleInputEmail1">Alasan Reject</label>
                            <textarea type="text" class="form-control @error($name[7]) is-invalid @enderror"
                                cols="5" rows="6" value=""
                                name="{{$name[7]}}" disabled>{{$data->alasan_reject}}</textarea>
                        </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <label for="">lokasi</label>
                            <div id="map" style="width:100%;height:400px;"></div><br>
                        </div>
                        <div class="col-4">
                            <label for="">Gambar</label>
                            <div class="d-flex justify-content-center">
                                <img src="http://134.209.103.184/rasa_nyonya/public/upload/foto/{{$data->foto_bukti}}" alt="" id='gambar' width="80%">
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <a href="{{route('order-index')}}" class="btn btn-success">Kembali</a>
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

    // $('#tanggal_pemesanan').datetimepicker({
    //     format: 'LD',
    //           icons: {
    //               time: "mdi mdi-clock ",
    //               date: "mdi mdi-calendar",
    //               up: "mdi mdi-arrow-up",
    //               down: "mdi mdi-arrow-down"
    //           }
    //       });
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
<script>
    function initAutocomplete() {
        // var lati = document.getElementById('latitude').value;
        // var long = document.getElementById('longitude').value;
        var lati = $('#latitude').val();
        var long = $('#longitude').val();
        // console.log(lati, long);
      var latlng = new google.maps.LatLng(lati,long);
        var map = new google.maps.Map(document.getElementById('map'), {
            center: latlng,
            zoom: 18,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        var marker1 = new google.maps.Marker({
            position: latlng,
            map: map,
            title: '',
            draggable: false
        })
    //     google.maps.event.addListener(marker1, 'dragend', function(marker1) {
    //         var latLng = marker1.latLng;
    //         document.getElementById('latitude').value = latLng.lat();
    //         document.getElementById('longitude').value = latLng.lng();
    //     });
    //   var input = document.getElementById('pac-input');
    //   map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);

        
    }
</script>    
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-W-RsTAPM3gMXac5yEMIxNbip9mSEVuo&callback=initAutocomplete&libraries=places&v=weekly" defer></script>
@endpush