<?php

namespace App\Http\Controllers;

use App\Models\MWilayah;
use App\Models\MArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DataTables;
use App\Traits\Helper;  

class CWilayah extends Controller
{
    use Helper;

    public function index()
    {
        return view('wilayah.index')->with('title','Wilayah');
    }
    public function create($title_page = 'Tambah')
    {
        $url = url('wilayah/create-save');
        return view('wilayah.form')
            ->with('data',null)
            ->with('area',MArea::where('deleted',1)->get())
            ->with('title','Wilayah')
            ->with('titlePage',$title_page)
            ->with('url',$url);
    }
    public function create_save(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id_area' => 'required',
            'kode_wilayah' => 'required', 
            'nama_wilayah' => 'required', 
            'fee' => 'required', 
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                        ->withInput($request->all())
                        ->withErrors($validator->errors());
        }

        $mWilayah = new MWilayah;
        $mWilayah->nama_wilayah = $request->nama_wilayah;
        $mWilayah->kode_wilayah = $request->kode_wilayah;
        $mWilayah->id_area = $request->id_area;
        $mWilayah->fee = str_replace(".","",$request->fee);
        $mWilayah->save();
        return redirect()->route('wilayah-index')->with('msg','Sukses Menambahkan Data');
    }
    
    public function show($id)
    {
        // dd(MWilayah::find($id));
        
        return view('wilayah.form')
            ->with('data',MWilayah::find($id))
            ->with('area',MArea::where('deleted',1)->get())
            ->with('title','Wilayah')
            ->with('titlePage','Edit')
            ->with('url',url('wilayah/show-save/'.$id));
    }
    public function show_save($id, Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id_area' => 'required',
            'kode_wilayah' => 'required', 
            'nama_wilayah' => 'required', 
            'fee' => 'required', 
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                        ->withInput($request->all())
                        ->withErrors($validator->errors());
        }
        $mWilayah = MWilayah::find($id);
        $mWilayah->nama_wilayah = $request->nama_wilayah;
        $mWilayah->kode_wilayah = $request->kode_wilayah;
        $mWilayah->id_area = $request->id_area;
        $mWilayah->fee = str_replace(".","",$request->fee);
        $mWilayah->update();
        return redirect()->route('wilayah-index')->with('msg','Sukses Mengubah Data');

    }
    public function delete($id)
    {
        MWilayah::updateDeleted($id);
        return redirect()->route('wilayah-index')->with('msg','Sukses Menambahkan Data');

    }
    public function datatable()
    {
        $model = MWilayah::select('m_wilayah.*','m_area.nama_area as area')
                    ->join('m_area','m_area.id_area','m_wilayah.id_area')
                    ->where('m_wilayah.deleted',1);
        return DataTables::eloquent($model)
            ->addColumn('action', function ($row) {
                $btn = '';                
                $btn .= '<a href="'.url('wilayah/delete/'.$row->id_wilayah).'" class="text-primary delete mr-2"><span class="mdi mdi-delete" data-toggle="tooltip" data-placement="Top" title="Delete"></span></a>';                
                $btn .= '<a href="'.url('wilayah/show/'.$row->id_wilayah).'" class="text-danger"><span class="mdi mdi-pen" data-toggle="tooltip" data-placement="Top" title="Edit"></span></a>';                
                return $btn;
            })
            ->editColumn('fee', function ($row) {
                $btn = Helper::ribuan($row->fee);
                return $btn;
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
    }
}
