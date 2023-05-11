<?php

namespace App\Http\Controllers;

use App\Models\MCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use DataTables;
use App\Traits\Helper;  

class CCustomer extends Controller
{

    public $validator =  [
        'nama' => 'required',
        'alamat' => 'required', 
        'no_hp' => 'required', 
    ];

    public function index()
    {
        return view('customer.index')->with('title','Customer');
    }
    public function create($title_page = 'Tambah')
    {
        $url = url('customer/create-save');
        return view('customer.form')
            ->with('data',null)
            ->with('title','Customer')
            ->with('titlePage',$title_page)
            ->with('url',$url);
    }
    public function create_save(Request $request)
    {
        $this->validator['no_hp'] = [
            "required",
            Rule::unique('m_customer', 'no_hp')->where(function ($query) {
                $query->where('deleted',1);
            }),
        ];
        $validator = Validator::make($request->all(),$this->validator);
        if ($validator->fails()) {
            return redirect()->back()
                        ->withInput($request->all())
                        ->withErrors($validator->errors());
        }

        $mCMCustomer = new MCustomer;
        $mCMCustomer->nama = $request->nama;
        $mCMCustomer->alamat = $request->alamat;
        $mCMCustomer->no_hp = $request->no_hp;
        $mCMCustomer->save();
        return redirect()->route('customer-index')->with('msg','Sukses Menambahkan Data');
    }
    
    public function show($id)
    {
        // dd(MCustomer::find($id));
        
        return view('customer.form')
            ->with('data',MCustomer::find($id))
            ->with('title','Customer')
            ->with('titlePage','Edit')
            ->with('url',url('customer/show-save/'.$id));
    }
    public function show_save($id, Request $request)
    {        
        $this->validator['no_hp'] = [
            "required",
            Rule::unique('m_customer', 'no_hp')->ignore($id,'id_customer')->where(function ($query) {
                $query->where('deleted',1);
            }),
        ];
        $validator = Validator::make($request->all(),$this->validator);
        // dd($validator);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withInput($request->all())
                        ->withErrors($validator->errors());
        }
        $mCMCustomer = MCustomer::find($id);
        $mCMCustomer->nama = $request->nama;
        $mCMCustomer->alamat = $request->alamat;
        $mCMCustomer->no_hp = $request->no_hp;
        $mCMCustomer->update();
        return redirect()->route('customer-index')->with('msg','Sukses Mengubah Data');

    }
    public function delete($id)
    {
        MCustomer::updateDeleted($id);
        return redirect()->route('customer-index')->with('msg','Sukses Menambahkan Data');

    }
    public function datatable()
    {
        $model = MCustomer::withDeleted();
        return DataTables::eloquent($model)
            ->addColumn('action', function ($row) {
                $btn = '';                
                $btn .= '<a href="'.url('customer/delete/'.$row->id_customer).'" class="text-primary delete mr-2"><span class="mdi mdi-delete" data-toggle="tooltip" data-placement="Top" title="Delete"></span></a>';                
                $btn .= '<a href="'.url('customer/show/'.$row->id_customer).'" class="text-danger"><span class="mdi mdi-pen" data-toggle="tooltip" data-placement="Top" title="Edit"></span></a>';                
                return $btn;
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
    }
}
