<?php

namespace App\Http\Controllers;

use App\Models\MAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DataTables;
use App\Traits\Helper;  

class CAdmin extends Controller
{
    public function index()
    {
        return view('admin.index')->with('title','Admin');
    }
    public function create($title_page = 'Tambah')
    {
        $url = url('admin/create-save');
        return view('admin.form')
            ->with('data',null)
            ->with('title','Admin')
            ->with('titlePage',$title_page)
            ->with('url',$url);
    }
    public function create_save(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nama' => 'required',             
            'no_hp' => 'required', 
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                        ->withInput($request->all())
                        ->withErrors($validator->errors());
        }

        $mAdmin = new MAdmin;
        $mAdmin->nama = $request->nama;        
        $mAdmin->no_hp = $request->no_hp;
        $mAdmin->save();
        return redirect()->route('admin-index')->with('msg','Sukses Menambahkan Data');
    }
    
    public function show($id)
    {
        // dd(MAdmin::find($id));
        
        return view('admin.form')
            ->with('data',MAdmin::find($id))
            ->with('title','Admin')
            ->with('titlePage','Edit')
            ->with('url',url('admin/show-save/'.$id));
    }
    public function show_save($id, Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nama' => 'required',             
            'no_hp' => 'required', 
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                        ->withInput($request->all())
                        ->withErrors($validator->errors());
        }
        $mAdmin = MAdmin::find($id);
        $mAdmin->nama = $request->nama;        
        $mAdmin->no_hp = $request->no_hp;
        $mAdmin->update();
        return redirect()->route('admin-index')->with('msg','Sukses Mengubah Data');

    }
    public function delete($id)
    {
        MAdmin::updateDeleted($id);
        return redirect()->route('admin-index')->with('msg','Sukses Menambahkan Data');

    }
    public function datatable()
    {
        $model = MAdmin::withDeleted();
        return DataTables::eloquent($model)
            ->addColumn('action', function ($row) {
                $btn = '';                
                $btn .= '<a href="'.url('admin/delete/'.$row->id_admin).'" class="text-primary delete mr-2"><span class="mdi mdi-delete" data-toggle="tooltip" data-placement="Top" title="Delete"></span></a>';                
                $btn .= '<a href="'.url('admin/show/'.$row->id_admin).'" class="text-danger"><span class="mdi mdi-pen" data-toggle="tooltip" data-placement="Top" title="Edit"></span></a>';                
                return $btn;
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
    }
}
