<?php

namespace App\Http\Controllers;

use App\Models\MCourier;
use App\Models\MArea;
use App\Models\MWilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DataTables;
use App\Traits\Helper;  

class CCourier extends Controller
{
    public function index()
    {
        return view('courier.index')->with('title','Courier');
    }
    public function create($title_page = 'Tambah')
    {
        $url = url('courier/create-save');
        return view('courier.form')
            ->with('data',null)
            ->with('area',MArea::where('deleted',1)->get())
            ->with('wilayah',MWilayah::where('deleted',1)->get())
            ->with('title','Courier')
            ->with('titlePage',$title_page)
            ->with('url',$url);
    }
    public function create_save(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nama' => 'required',
            'alamat' => 'required', 
            'no_hp' => 'required', 
            'id_area' => 'required', 
            'id_wilayah' => 'required', 
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                        ->withInput($request->all())
                        ->withErrors($validator->errors());
        }

        $mCourier = new MCourier;
        $mCourier->nama = $request->nama;
        $mCourier->alamat = $request->alamat;
        $mCourier->no_hp = $request->no_hp;
        $mCourier->id_area = $request->id_area;
        $mCourier->id_wilayah = $request->id_wilayah;
        $mCourier->save();
        return redirect()->route('courier-index')->with('msg','Sukses Menambahkan Data');
    }
    
    public function show($id)
    {
        // dd(MCourier::find($id));
        
        return view('courier.form')
            ->with('data',MCourier::find($id))
            ->with('area',MArea::where('deleted',1)->get())
            ->with('wilayah',MWilayah::where('deleted',1)->get())
            ->with('title','Courier')
            ->with('titlePage','Edit')
            ->with('url',url('courier/show-save/'.$id));
    }
    public function show_save($id, Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nama' => 'required',
            'alamat' => 'required', 
            'no_hp' => 'required', 
            'id_area' => 'required', 
            'id_wilayah' => 'required', 
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                        ->withInput($request->all())
                        ->withErrors($validator->errors());
        }
        $mCourier = MCourier::find($id);
        $mCourier->nama = $request->nama;
        $mCourier->alamat = $request->alamat;
        $mCourier->no_hp = $request->no_hp;
        $mCourier->id_area = $request->id_area;
        $mCourier->id_wilayah = $request->id_wilayah;
        $mCourier->update();
        return redirect()->route('courier-index')->with('msg','Sukses Mengubah Data');

    }
    public function delete($id)
    {
        MCourier::updateDeleted($id);
        return redirect()->route('courier-index')->with('msg','Sukses Menambahkan Data');

    }
    public function datatable()
    {
        $model = MCourier::select('m_courier.*','m_area.nama_area','m_wilayah.nama_wilayah')
                    ->join('m_area','m_area.id_area','m_courier.id_area')
                    ->join('m_wilayah','m_wilayah.id_wilayah','m_courier.id_wilayah')
                    ->where('m_courier.deleted',1);
        return DataTables::eloquent($model)
            ->addColumn('action', function ($row) {
                $btn = '';                
                $btn .= '<a href="'.url('courier/delete/'.$row->id_courier).'" class="text-primary delete mr-2"><span class="mdi mdi-delete" data-toggle="tooltip" data-placement="Top" title="Delete"></span></a>';                
                $btn .= '<a href="'.url('courier/show/'.$row->id_courier).'" class="text-danger"><span class="mdi mdi-pen" data-toggle="tooltip" data-placement="Top" title="Edit"></span></a>';                
                return $btn;
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
    }
    public function get_wilayah_by_area(Request $request)
    {
        $id = $request->id_area;
        $wilayah = MWilayah::where('id_area',$id)->get();        
        $html ='<option value="" selected disabled> Pilih Wilayah </option>';
        foreach ($wilayah as $key) {
            $html.="<option value='".$key->id_wilayah."'>".$key->nama_wilayah."</option>";
        }
        return response()->json($html);        
    }
}
