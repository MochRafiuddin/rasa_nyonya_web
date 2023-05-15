<?php

namespace App\Http\Controllers;

use App\Models\MCourier;
use App\Models\MSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DataTables;
use Carbon\Carbon;
use App\Traits\Helper;  

class CReport extends Controller
{
    use Helper;

    public function index()
    {
        $tanggal = date('d-m-Y',strtotime("-1 days")).' - '.date('d-m-Y');
        return view('report.index')
            ->with('tanggal',$tanggal)
            ->with('title','Courier Performance');
    }

    public function index_fee()
    {
        $tanggal = date('d-m-Y',strtotime("-1 days")).' - '.date('d-m-Y');
        return view('report.index_fee')
            ->with('tanggal',$tanggal)
            ->with('title','Courier Fee');
    }

    public function datatable(Request $request)
    {
        // $date = explode(' - ',date('Y-m-d',strtotime("-2 days")).' - '.date('Y-m-d'));
        $siang = MSetting::where('kode','batas_kirim_siang')->first();
        $malam = MSetting::where('kode','batas_kirim_malam')->first();
        $date = explode(' - ', $request->data);
        $start = Carbon::createFromFormat('d-m-Y',$date[0])->format('Y-m-d');
        $end = Carbon::createFromFormat('d-m-Y',$date[1])->format('Y-m-d');
        // dd($request->start);
        // $model = MCourier::from('m_courier');
        if ($request->tipe == 1) {
            $model = MCourier::from('m_courier as a')
            ->selectRaw('a.id_courier, a.nama as nama_courier, b.nama_wilayah, (select count(*) from t_order where deleted = 1 and id_status IN (4) and id_courier = a.id_courier and ((date(tanggal_pemesanan) between "'.$start.'" and "'.$end.'") and IF(jenis_pengantaran = 1, time(waktu_courier_tiba) < "'.$siang->nilai.'", time(waktu_courier_tiba) < "'.$malam->nilai.'"))) as total_on_time, (select count(*) from t_order where deleted = 1 and id_status IN (4,5) and id_courier = a.id_courier and (date(tanggal_pemesanan) between "'.$start.'" and "'.$end.'")) as total_delivery')
            ->leftJoin('m_wilayah as b','a.id_wilayah','b.id_wilayah')
            ->where('a.deleted',1)
            ->where('b.deleted',1)
            ->orderBy('total_on_time','desc')
            ->orderBy('total_delivery','desc');
        }else {
            $model = MCourier::from('m_courier as a')
            ->selectRaw('a.id_courier, a.nama as nama_courier, b.nama_wilayah,(select count(*) from t_order where deleted = 1 and id_status IN (4,5) and id_courier = a.id_courier and (date(tanggal_pemesanan) between "'.$start.'" and "'.$end.'")) as total_delivery')
            ->leftJoin('m_wilayah as b','a.id_wilayah','b.id_wilayah')                    
            ->where('a.deleted',1)
            ->where('b.deleted',1)
            ->orderBy('total_delivery','desc');
        }
        // dd($model->get());

        return DataTables::eloquent($model)
            ->addIndexColumn()
            ->toJson();
    }
    public function datatable_fee(Request $request)
    {
        // $date = explode(' - ',date('Y-m-d',strtotime("-2 days")).' - '.date('Y-m-d'));
        
        $date = explode(' - ', $request->data);
        $start = Carbon::createFromFormat('d-m-Y',$date[0])->format('Y-m-d');
        $end = Carbon::createFromFormat('d-m-Y',$date[1])->format('Y-m-d'); 
        // dd($request->start);
        // $model = MCourier::from('m_courier');
        
            $model = MCourier::from('m_courier as a')
            ->selectRaw('a.id_courier, a.nama as nama_courier, b.nama_wilayah, (select SUM(fee_courier) from t_order where deleted = 1 and id_status IN (4) and id_courier = a.id_courier and (date(tanggal_pemesanan) between "'.$start.'" and "'.$end.'")) as total_fee')
            ->leftJoin('m_wilayah as b','a.id_wilayah','b.id_wilayah')                    
            ->where('a.deleted',1)
            ->where('b.deleted',1)
            ->orderBy('id_courier','asc');

        return DataTables::eloquent($model)
            ->editColumn('total_fee', function ($row) {
                if ($row->total_fee != null) {
                    $btn = Helper::ribuan($row->total_fee);
                }else {
                    $btn = '0';
                }
                return $btn;
            })
            ->addIndexColumn()
            ->toJson();
    }
}
