<?php

namespace App\Http\Controllers;

use App\Models\MWilayah;
use App\Models\MArea;
use App\Models\TOrder;
use App\Models\MCourier;
use App\Models\MCustomer;
use App\Models\MStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use PHPExcel_Cell_DataType;
use PHPExcel_IOFactory;
use DataTables;
use Carbon\Carbon;
use App\Traits\Helper;  

class COrder extends Controller
{
    use Helper;

    public function index()
    {
        $tanggal = date('d-m-Y').' - '.date('d-m-Y',strtotime("+1 weeks"));
        return view('order.index')
            ->with('area',MArea::where('deleted',1)->orderBy('nama_area','asc')->get())
            ->with('wilayah',MWilayah::where('deleted',1)->orderBy('nama_wilayah','asc')->get())
            ->with('customer',MCustomer::where('deleted',1)->orderBy('nama','asc')->get())
            ->with('tanggal',$tanggal)
            ->with('title','Order');
    }
    public function create($title_page = 'Tambah')
    {
        $url = url('order/create-save');
        return view('order.form')
            ->with('data',null)
            ->with('area',MArea::where('deleted',1)->orderBy('nama_area','asc')->get())
            ->with('wilayah',MWilayah::where('deleted',1)->orderBy('nama_wilayah','asc')->get())
            ->with('customer',MCustomer::where('deleted',1)->orderBy('nama','asc')->get())
            ->with('title','Order')
            ->with('titlePage',$title_page)
            ->with('url',$url);
    }
    public function create_save(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id_customer' => 'required',
            'jenis_pengantaran' => 'required',
            'tanggal_pemesanan' => 'required',
            'jenis_paket' => 'required',
            'id_area' => 'required',
            'id_wilayah' => 'required',
            'alamat' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                        ->withInput($request->all())
                        ->withErrors($validator->errors());
        }

        $mWilayah = new TOrder;
        $mWilayah->id_customer = $request->id_customer;
        $mWilayah->jenis_pengantaran = $request->jenis_pengantaran;
        $mWilayah->tanggal_pemesanan = date('Y-m-d H:i:s',strtotime($request->tanggal_pemesanan));
        $mWilayah->jenis_paket = $request->jenis_paket;
        $mWilayah->id_area = $request->id_area;
        $mWilayah->id_wilayah = $request->id_wilayah;
        $mWilayah->alamat = $request->alamat;
        $mWilayah->keterangan = $request->keterangan;
        $mWilayah->id_status = 1;
        $mWilayah->save();
        return redirect()->route('order-index')->with('msg','Sukses Menambahkan Data');
    }
    
    public function show($id)
    {
        $data=TOrder::find($id);
        
        return view('order.form')
            ->with('data',$data)
            ->with('area',MArea::where('deleted',1)->orderBy('nama_area','asc')->get())
            ->with('wilayah',MWilayah::where('deleted',1)->where('id_area',$data->id_area)->orderBy('nama_wilayah','asc')->get())
            ->with('customer',MCustomer::where('deleted',1)->orderBy('nama','asc')->get())            
            ->with('title','Order')
            ->with('titlePage','Edit')
            ->with('url',url('order/show-save/'.$id));
    }

    public function detail($id)
    {
        // dd(MWilayah::find($id));
        $order = TOrder::find($id);
        return view('order.detail')
            ->with('data',$order)
            ->with('area',MArea::where('deleted',1)->get())
            ->with('wilayah',MWilayah::where('deleted',1)->get())
            ->with('customer',MCustomer::where('deleted',1)->get())
            ->with('courier',MCourier::where('deleted',1)->get())
            ->with('status',MStatus::where('deleted',1)->get())
            ->with('cus',MCustomer::find($order->id_customer))
            ->with('title','Order')
            ->with('titlePage','Detail')
            ->with('url',url('order/show-save/'.$id));
    }

    public function confirm($id)
    {
        // dd(MWilayah::find($id));
        $order = TOrder::find($id);
        return view('order.confirm')
            ->with('data',$order)
            ->with('area',MArea::where('deleted',1)->get())
            ->with('wilayah',MWilayah::where('deleted',1)->get())
            ->with('customer',MCustomer::where('deleted',1)->get())
            ->with('courier',MCourier::where('deleted',1)->get())
            ->with('status',MStatus::where('deleted',1)->get())
            ->with('cus',MCustomer::find($order->id_customer))
            ->with('fee',MWilayah::find($order->id_wilayah))
            ->with('title','Order')
            ->with('titlePage','Confirm')
            ->with('url',url('order/show-save/'.$id));
    }

    public function show_save($id, Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id_customer' => 'required',
            'jenis_pengantaran' => 'required',
            'tanggal_pemesanan' => 'required',
            'jenis_paket' => 'required',
            'id_area' => 'required',
            'id_wilayah' => 'required',
            'alamat' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                        ->withInput($request->all())
                        ->withErrors($validator->errors());
        }
        $mWilayah = TOrder::find($id);
        if ($mWilayah->id_status > 1) {
            return redirect()->back()
            ->with('msg','Tidak bisa edit data karena status bukan new');
        }

        $mWilayah->id_customer = $request->id_customer;
        $mWilayah->jenis_pengantaran = $request->jenis_pengantaran;
        $mWilayah->tanggal_pemesanan = date('Y-m-d H:i:s',strtotime($request->tanggal_pemesanan));
        $mWilayah->jenis_paket = $request->jenis_paket;
        $mWilayah->id_area = $request->id_area;
        $mWilayah->id_wilayah = $request->id_wilayah;
        $mWilayah->alamat = $request->alamat;
        $mWilayah->keterangan = $request->keterangan;
        $mWilayah->update();
        return redirect()->route('order-index')->with('msg','Sukses Mengubah Data');

    }
    public function update_status(Request $request)
    {        
        $mWilayah = TOrder::find($request->id_order);
        if ($request->id_status_m == 4) {
            $mWilayah->fee_courier = str_replace(".","",$request->fee_courier);
            $mWilayah->id_status = $request->id_status_m;
        }else {
            $mWilayah->alasan_reject = $request->alasan_reject;
            $mWilayah->id_status = $request->id_status_m;
        }
        $mWilayah->update();
        return redirect()->route('order-index')->with('msg','Sukses Mengubah Data');

    }
    public function delete($id)
    {
        TOrder::updateDeleted($id);
        return redirect()->route('order-index')->with('msg','Sukses Menambahkan Data');

    }
    public function datatable(Request $request)
    {
        // dd($request->status);
        $date = explode(' - ', $request->date);
        $start = Carbon::createFromFormat('d-m-Y',$date[0])->format('Y-m-d');
        $end = Carbon::createFromFormat('d-m-Y',$date[1])->format('Y-m-d');

        $model = TOrder::select('t_order.*','m_area.nama_area as area','m_wilayah.nama_wilayah as wilayah','m_customer.nama as nama_customer','m_status.nama_status')
                    ->join('m_area','m_area.id_area','t_order.id_area')
                    ->join('m_wilayah','m_wilayah.id_wilayah','t_order.id_wilayah')
                    ->join('m_customer','m_customer.id_customer','t_order.id_customer')                    
                    ->join('m_status','m_status.id_status','t_order.id_status')
                    ->where('t_order.deleted',1)
                    ->whereBetween('t_order.tanggal_pemesanan',[$start,$end]);
                    // ->orderBy('t_order.tanggal_pemesanan','asc');
        if ($request->customer != 0) {
            $model = $model->where('t_order.id_customer',$request->customer);
        }
        if ($request->area != 0) {
            $model = $model->where('t_order.id_area',$request->area);
        }
        if ($request->wilayah != 0) {
            $model = $model->where('t_order.id_wilayah',$request->wilayah);
        }
        if ($request->status != null) {
            $model = $model->whereIn('t_order.id_status',explode(",",$request->status));
        }
        return DataTables::eloquent($model)
            ->addColumn('action', function ($row) {
                $btn = '';
                if($row->id_status == 1){
                    $btn .= '<a href="'.url('order/delete/'.$row->id_order).'" class="text-primary delete mr-2"><span class="mdi mdi-delete" data-toggle="tooltip" data-placement="Top" title="Delete"></span></a>';
                    $btn .= '<a href="'.url('order/show/'.$row->id_order).'" class="text-danger mr-2"><span class="mdi mdi-pen" data-toggle="tooltip" data-placement="Top" title="Edit"></span></a>';
                    $btn .= '<a href="'.url('order/detail/'.$row->id_order).'" class="text-warning mr-2"><span class="mdi mdi-adjust" data-toggle="tooltip" data-placement="Top" title="Detail"></span></a>';
                }else if ($row->id_status == 2 || $row->id_status == 4 || $row->id_status == 5) {
                    $btn .= '<a href="'.url('order/detail/'.$row->id_order).'" class="text-warning mr-2"><span class="mdi mdi-adjust" data-toggle="tooltip" data-placement="Top" title="Detail"></span></a>';
                }else if ($row->id_status == 3) {
                    $btn .= '<a href="'.url('order/detail/'.$row->id_order).'" class="text-warning mr-2"><span class="mdi mdi-adjust" data-toggle="tooltip" data-placement="Top" title="Detail"></span></a>';
                    $btn .= '<a href="'.url('order/confirm/'.$row->id_order).'" class="text-success mr-2"><span class="mdi mdi-check" data-toggle="tooltip" data-placement="Top" title="Confirm"></span></a>';
                }
                return $btn;
            })
            ->editColumn('kurir', function ($row) {
                $btn = '';
                if ($row->id_courier != null) {
                    $kurir = MCourier::find($row->id_courier);
                    $btn = $kurir->nama;
                }else {
                    $btn = "-";
                }
                return $btn;
            })
            ->editColumn('tanggal_tiba', function ($row) {
                $btn = '';
                if ($row->waktu_courier_tiba != null) {
                    $kurir = date('d-m-Y H:i:s',strtotime($row->waktu_courier_tiba));
                    $btn = $kurir;
                }else {
                    $btn = "-";
                }
                return $btn;
            })
            ->editColumn('tanggal_order', function ($row) {
                $btn = '';
                if ($row->tanggal_pemesanan != null) {
                    $kurir = date('d-m-Y',strtotime($row->tanggal_pemesanan));
                    $btn = $kurir;
                }else {
                    $btn = "-";
                }
                return $btn;
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
    }

    public function readExcel(Request $request) {
        // $file = $request->file('excel_file');
        // $path = $file->getRealPath();
        // $objPHPExcel = PHPExcel_IOFactory::load($path);
        // $worksheet = $objPHPExcel->getActiveSheet();
        // $data = $worksheet->toArray();

        $file = $request->file('excel_file');
        $path = $file->getRealPath();
        $excel = PHPExcel_IOFactory::load($path);
        $worksheet = $excel->getActiveSheet();
        $highestColumn = $worksheet->getHighestColumn();
        $highestRow = $worksheet->getHighestRow();
        // Baca nilai sel sebagai array
        $rows = $worksheet->toArray();
        $data=[];
        $error=0;
        $msg='';
        for ($i=5; $i < $highestRow; $i++) { 
            // dd(date('Y-m-d',strtotime($rows[$i][3])));
            // dd($rows[$i][3]);
            $customer = MCustomer::where('no_hp',$rows[$i][0])->first();            
            // $area = MArea::where('kode_area',$rows[$i][5])->first();
            $wilayah = MWilayah::where('kode_wilayah',$rows[$i][5])->first();
            if ($customer == null) {
                $error=1;
                $msg = "No telfon customer <b>".$rows[$i][0]."</b> tidak ditemukan, silakan cek di menu Master Customer";
                continue;
            }
            if ($wilayah == null) {
                $error=1;
                $msg = "wilayah <b>".$rows[$i][5]."</b> tidak ditemukan, silakan cek di menu Master Wilayah";
                continue;
            }
                array_push($data,[
                    'id_customer' => $customer->id_customer,
                    'jenis_pengantaran' => $rows[$i][2],
                    'tanggal_pemesanan' => Carbon::createFromFormat('d/m/Y',$rows[$i][3])->format('Y-m-d'),
                    'jenis_paket' => $rows[$i][4],
                    'id_area' => $wilayah->id_area,
                    'id_wilayah' => $wilayah->id_wilayah,
                    'alamat' => $rows[$i][6],
                    'keterangan' => $rows[$i][7],
                    'id_status' => 1,
                    'created_by' => 1,
                    'updated_by' => 1,
                ]);            
        }

        if ($error == 1) {
            return response()->json(['status'=>true,'error'=>1,'msg_import'=>$msg]);            
        }

        TOrder::insert($data);
        return response()->json(['status'=>true,'error'=>0,'msg_import'=>'Import Order Sukses']);
        // return view('excel', compact('data'));
   }
}
