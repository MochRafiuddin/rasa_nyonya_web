<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MCourier;
use App\Models\MAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DataTables;
use DB;
use Hash;
use App\Traits\Helper;  

class CUser extends Controller
{
    use Helper;

    public function index()
    {
        return view('user.index')->with('title','Akun');
    }
    public function create($title_page = 'Tambah')
    {
        $url = url('user/create-save');
        return view('user.form')
            ->with('data',null)            
            ->with('title','Akun')
            ->with('titlePage',$title_page)
            ->with('url',$url);
    }
    public function create_save(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'username' => 'required',
            'tipe_user' => 'required',
            'id_ref' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                        ->withInput($request->all())
                        ->withErrors($validator->errors());
        }

        $user = new user;
        $user->username = $request->username;
        $user->tipe_user = $request->tipe_user;
        $user->id_ref = $request->id_ref;
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->route('user-index')->with('msg','Sukses Menambahkan Data');
    }
    
    public function show($id)
    {
        // dd(User::find($id));
        $user = User::find($id);
        if ($user->tipe_user == 1) {
            $ref = MAdmin::select('id_admin as id_ref','nama')->where('deleted',1)->get();
        }else {
            $ref = MCourier::select('id_courier as id_ref','nama')->where('deleted',1)->get();
        }
        return view('user.form')
            ->with('data',$user)            
            ->with('id_ref',$ref)
            ->with('title','Akun')
            ->with('titlePage','Edit')
            ->with('url',url('user/show-save/'.$id));
    }
    public function show_save($id, Request $request)
    {
        $validator = Validator::make($request->all(),[
            'username' => 'required',
            'tipe_user' => 'required',
            'id_ref' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                        ->withInput($request->all())
                        ->withErrors($validator->errors());
        }
        $user = User::find($id);
        $user->username = $request->username;
        $user->tipe_user = $request->tipe_user;
        $user->id_ref = $request->id_ref;
        $user->update();
        return redirect()->route('user-index')->with('msg','Sukses Mengubah Data');

    }
    public function delete($id)
    {
        User::where('id_user',$id)->update(['deleted'=> 0]);
        return redirect()->route('user-index')->with('msg','Sukses Menambahkan Data');

    }
    public function datatable()
    {
        $results = User::from('m_user as t1')
                ->selectRaw('t1.*, IF(t1.tipe_user = "1", (select nama from m_admin where deleted = 1 and id_admin = t1.id_ref), (select nama from m_courier where deleted = 1 and id_courier = t1.id_ref)) AS nama_user')                
                ->where('t1.deleted',1);        
        return DataTables::eloquent($results)
            ->addColumn('action', function ($row) {
                $btn = '';                
                $btn .= '<a href="'.url('user/delete/'.$row->id_user).'" class="text-primary delete mr-2"><span class="mdi mdi-delete" data-toggle="tooltip" data-placement="Top" title="Delete"></span></a>';                
                $btn .= '<a href="'.url('user/show/'.$row->id_user).'" class="text-danger"><span class="mdi mdi-pen" data-toggle="tooltip" data-placement="Top" title="Edit"></span></a>';                
                return $btn;
            })            
            ->editColumn('tipe_user', function ($row) {
                if ($row->tipe_user == 1) {
                    $btn = 'Admin';
                }else {
                    $btn = 'Kurir';
                }
                return $btn;
            })            
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
    }
    public function get_user_by_tipe(Request $request)
    {
        $id = $request->tipe_user;
        if ($id == 1) {
            $ref = MAdmin::select('id_admin as id_ref','nama')->where('deleted',1)->get();
        }else {
            $ref = MCourier::select('id_courier as id_ref','nama')->where('deleted',1)->get();
        }
        $html ='<option value="" selected disabled> Pilih Wilayah </option>';
        foreach ($ref as $key) {
            $html.="<option value='".$key->id_ref."'>".$key->nama."</option>";
        }
        return response()->json($html);        
    }
	
	public function apk(){
		
		$dir = public_path('rasa_nyonya.apk'); // trailing slash is important
		$file = $dir;
		$filename = "rasa-nyonya.apk";

		header('Content-Description: File Transfer');
	    header('Content-Type: application/octet-stream');
	    header('Content-Disposition: attachment; filename='.basename($filename));
	    header('Expires: 0');
	    header('Cache-Control: must-revalidate');
	    header('Pragma: public');
	    header('Content-Length: ' . filesize($file));
	    ob_clean();
	    flush();
	    readfile($file);
	    exit;

	}
}
