<?php

namespace App\Http\Controllers;

use App\Models\MArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DataTables;
use App\Traits\Helper;  

class CArea extends Controller
{
    public function index()
    {
        return view('area.index')->with('title','Area');
    }
    public function create($title_page = 'Tambah')
    {
        $url = url('area/create-save');
        return view('area.form')
            ->with('data',null)
            ->with('title','Area')
            ->with('titlePage',$title_page)
            ->with('url',$url);
    }
    public function create_save(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nama_area' => 'required',
            'kode_area' => 'required', 
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                        ->withInput($request->all())
                        ->withErrors($validator->errors());
        }

        $mArea = new MArea;
        $mArea->nama_area = $request->nama_area;
        $mArea->kode_area = $request->kode_area;
        $mArea->save();
        return redirect()->route('area-index')->with('msg','Sukses Menambahkan Data');
    }
    
    public function show($id)
    {
        // dd(MArea::find($id));
        
        return view('area.form')
            ->with('data',MArea::find($id))
            ->with('title','Area')
            ->with('titlePage','Edit')
            ->with('url',url('area/show-save/'.$id));
    }
    public function show_save($id, Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nama_area' => 'required',
            'kode_area' => 'required', 
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                        ->withInput($request->all())
                        ->withErrors($validator->errors());
        }
        $mArea = MArea::find($id);
        $mArea->nama_area = $request->nama_area;
        $mArea->kode_area = $request->kode_area;
        $mArea->update();
        return redirect()->route('area-index')->with('msg','Sukses Mengubah Data');

    }
    public function delete($id)
    {
        MArea::updateDeleted($id);
        return redirect()->route('area-index')->with('msg','Sukses Menambahkan Data');

    }
    public function datatable()
    {
        $model = MArea::withDeleted()->orderBy('nama_area','asc');
        return DataTables::eloquent($model)
            ->addColumn('action', function ($row) {
                $btn = '';                
                $btn .= '<a href="'.url('area/delete/'.$row->id_area).'" class="text-primary delete mr-2"><span class="mdi mdi-delete" data-toggle="tooltip" data-placement="Top" title="Delete"></span></a>';                
                $btn .= '<a href="'.url('area/show/'.$row->id_area).'" class="text-danger"><span class="mdi mdi-pen" data-toggle="tooltip" data-placement="Top" title="Edit"></span></a>';                
                return $btn;
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
    }
}
