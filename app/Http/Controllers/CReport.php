<?php

namespace App\Http\Controllers;

use App\Models\MCourier;
use App\Models\MSetting;
use App\Models\TOrder;
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
        $tgl = $request->data;
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
            ->editColumn('opsi', function ($row) use ($tgl){
                $btn = '';
                $btn .= '<a href="'.url('report/detail-courier-performance/'.$row->id_courier.'/'.$tgl).'" class="text-warning mr-2"><span class="mdi mdi-information-outline" data-toggle="tooltip" data-placement="Top" title="Detail"></span></a>';
                return $btn;
            })
            ->rawColumns(['opsi'])
            ->addIndexColumn()
            ->toJson();
    }
    public function datatable_fee(Request $request)
    {
        // $date = explode(' - ',date('Y-m-d',strtotime("-2 days")).' - '.date('Y-m-d'));
        $tgl = $request->data;
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
            ->editColumn('opsi', function ($row) use ($tgl){
                $btn = '';
                $btn .= '<a href="'.url('report/detail-courier-fee/'.$row->id_courier.'/'.$tgl).'" class="text-warning mr-2"><span class="mdi mdi-information-outline" data-toggle="tooltip" data-placement="Top" title="Detail"></span></a>';
                return $btn;
            })
            ->rawColumns(['opsi'])
            ->addIndexColumn()
            ->toJson();
    }

    public function detail_fee($id_courier,$tgl)
    {       
        $courier = MCourier::leftJoin('m_wilayah','m_wilayah.id_wilayah','m_courier.id_wilayah')
        ->where('id_courier',$id_courier)
        ->first();
        $date = explode(' - ', $tgl);
        $start = Carbon::createFromFormat('d-m-Y',$date[0])->format('Y-m-d');
        $end = Carbon::createFromFormat('d-m-Y',$date[1])->format('Y-m-d');        
        
        return view('report.detail_fee')
            ->with('tanggal',$tgl)
            ->with('courier',$courier)            
            ->with('title','Detail Fee');
    }

    public function datatable_detail_fee(Request $request)
    {
        // $date = explode(' - ',date('Y-m-d',strtotime("-2 days")).' - '.date('Y-m-d'));
        
        $date = explode(' - ', $request->tanggal);
        $start = Carbon::createFromFormat('d-m-Y',$date[0])->format('Y-m-d');
        $end = Carbon::createFromFormat('d-m-Y',$date[1])->format('Y-m-d'); 
        // dd($request->start);
        // $model = MCourier::from('m_courier');
        
        $model = TOrder::leftJoin('m_customer','m_customer.id_customer','t_order.id_customer')
        ->select('m_customer.nama','t_order.*')
        ->where('t_order.deleted',1)
        ->where('t_order.id_courier',$request->id_courier)
        ->whereIn('t_order.id_status',[4])
        ->whereRaw('(date(t_order.tanggal_pemesanan) between "'.$start.'" and "'.$end.'")');
        if ($request->jenis != 0) {
            $model = $model->where('t_order.jenis_pengantaran',$request->jenis);
        }        
        // dd($model->get());
        return DataTables::eloquent($model)
            ->editColumn('jenis_pengantaran', function ($row) {
                if ($row->jenis_pengantaran == 1) {
                    $html = 'Makan Siang';
                }else{
                    $html = 'Makan malam';
                }
                return $html;
            })
            ->editColumn('tanggal_pemesanan', function ($row) {
                $html = date('d-m-Y',strtotime($row->tanggal_pemesanan));
                return $html;
            })
            ->editColumn('waktu_courier_tiba', function ($row) {
                $html = date('d-m-Y H:i:s',strtotime($row->waktu_courier_tiba));
                return $html;
            })
            ->addColumn('fee_courier', function ($row){
                if ($row->fee_courier != null) {
                    $btn = Helper::ribuan($row->fee_courier);
                }else {
                    $btn = '0';
                }
                return $btn;
            })
            ->addIndexColumn()
            ->toJson();
    }

    public function detail_performance($id_courier,$tgl)
    {       
        $courier = MCourier::leftJoin('m_wilayah','m_wilayah.id_wilayah','m_courier.id_wilayah')
        ->where('id_courier',$id_courier)
        ->first();
        $date = explode(' - ', $tgl);
        $start = Carbon::createFromFormat('d-m-Y',$date[0])->format('Y-m-d');
        $end = Carbon::createFromFormat('d-m-Y',$date[1])->format('Y-m-d');        
        
        return view('report.detail_performance')
            ->with('tanggal',$tgl)
            ->with('courier',$courier)            
            ->with('title','Detail Performance');
    }

    public function datatable_detail_performance(Request $request)
    {
        // $date = explode(' - ',date('Y-m-d',strtotime("-2 days")).' - '.date('Y-m-d'));
        
        $date = explode(' - ', $request->tanggal);
        $start = Carbon::createFromFormat('d-m-Y',$date[0])->format('Y-m-d');
        $end = Carbon::createFromFormat('d-m-Y',$date[1])->format('Y-m-d'); 
        // dd($request->start);
        // $model = MCourier::from('m_courier');
        
        $model = TOrder::leftJoin('m_customer','m_customer.id_customer','t_order.id_customer')
        ->select('m_customer.nama','t_order.*')
        ->where('t_order.deleted',1)
        ->where('t_order.id_courier',$request->id_courier)
        ->whereIn('t_order.id_status',[4,5])
        ->whereRaw('(date(t_order.tanggal_pemesanan) between "'.$start.'" and "'.$end.'")');
        if ($request->jenis != 0) {
            $model = $model->where('t_order.jenis_pengantaran',$request->jenis);
        }

        $siang = MSetting::where('kode','batas_kirim_siang')->first();
        $malam = MSetting::where('kode','batas_kirim_malam')->first();

        return DataTables::eloquent($model)
            ->editColumn('jenis_pengantaran', function ($row) {
                if ($row->jenis_pengantaran == 1) {
                    $html = 'Makan Siang';
                }else{
                    $html = 'Makan malam';
                }
                return $html;
            })
            ->editColumn('tanggal_pemesanan', function ($row) {
                $html = date('d-m-Y',strtotime($row->tanggal_pemesanan));
                return $html;
            })
            ->editColumn('waktu_courier_tiba', function ($row) {
                $html = date('d-m-Y H:i:s',strtotime($row->waktu_courier_tiba));
                return $html;
            })
            ->addColumn('status', function ($row) use ($siang,$malam){
                $html = "<span class='mdi mdi-close text-danger'></span>";
                $jam_tiba = date('H:i:s',strtotime($row->waktu_courier_tiba));
                // dd($jam_tiba.' '.$siang->nilai);
                if ($row->jenis_pengantaran == 1 && $jam_tiba <= $siang->nilai) {
                    $html = "<span class='mdi mdi-check text-success'></span>";
                }elseif ($row->jenis_pengantaran == 2 && $jam_tiba <= $malam->nilai) {
                    $html = "<span class='mdi mdi-check text-success'></span>";
                }
                return $html;
            })
            ->rawColumns(['status'])
            ->addIndexColumn()
            ->toJson();
    }

    public function get_total_performance(Request $request)
    {
        $date = explode(' - ', $request->tanggal);
        $start = Carbon::createFromFormat('d-m-Y',$date[0])->format('Y-m-d');
        $end = Carbon::createFromFormat('d-m-Y',$date[1])->format('Y-m-d');

        $siang = MSetting::where('kode','batas_kirim_siang')->first();
        $malam = MSetting::where('kode','batas_kirim_malam')->first();

        $ontime = TOrder::where('deleted',1)
            ->where('id_courier',$request->id_courier)
            ->where('id_status',4)
            ->whereRaw('(date(tanggal_pemesanan) between "'.$start.'" and "'.$end.'")');
            if ($request->jenis == 0) {
                $ontime = $ontime->whereRaw('IF(jenis_pengantaran = 1, time(waktu_courier_tiba) < "'.$siang->nilai.'", time(waktu_courier_tiba) < "'.$malam->nilai.'")');
            }elseif ($request->jenis == 1) {
                $ontime = $ontime->where('jenis_pengantaran',$request->jenis)
                        ->whereRaw('time(waktu_courier_tiba) < "'.$siang->nilai.'"');
            }else {
                $ontime = $ontime->where('jenis_pengantaran',$request->jenis)
                        ->whereRaw('time(waktu_courier_tiba) < "'.$malam->nilai.'"');                
            }
            $ontime = $ontime->get()->count();
            // dd($ontime);
        $deliver = TOrder::where('deleted',1)
            ->where('id_courier',$request->id_courier)
            ->whereIn('id_status',[4,5])
            ->whereRaw('(date(tanggal_pemesanan) between "'.$start.'" and "'.$end.'")');
            if ($request->jenis != 0) {
                $deliver = $deliver->where('jenis_pengantaran',$request->jenis);
            }
            $deliver = $deliver->get()->count();

            return response()->json(['ontime'=>$ontime, 'deliver'=>$deliver]);
    }

    public function get_total_fee(Request $request)
    {
        $date = explode(' - ', $request->tanggal);
        $start = Carbon::createFromFormat('d-m-Y',$date[0])->format('Y-m-d');
        $end = Carbon::createFromFormat('d-m-Y',$date[1])->format('Y-m-d');        
        
        $deliver = TOrder::where('deleted',1)
            ->where('id_courier',$request->id_courier)
            ->whereIn('id_status',[4])
            ->whereRaw('(date(tanggal_pemesanan) between "'.$start.'" and "'.$end.'")');
            if ($request->jenis != 0) {
                $deliver = $deliver->where('jenis_pengantaran',$request->jenis);
            }
            $deliver = $deliver->sum('fee_courier');

            return response()->json(['deliver'=>$deliver]);
    }
}
