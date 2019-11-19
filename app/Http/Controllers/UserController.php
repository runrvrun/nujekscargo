<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;
use Schema;
use Session;
use Validator;
use Hash;

class UserController extends Controller
{
    private $cols;

    public function __construct()
    {
        //setup cols
        $dbcols = Schema::getColumnListing('users');//get all columns from DB
        foreach($dbcols as $key=>$val){
            // add bread props
            $cols[$val] = ['column'=>$val,'dbcolumn'=>$val,
                'caption'=>ucwords(str_replace('_',' ',$val)),
                'type' => 'text',
                'B'=>1,'R'=>1,'E'=>1,'A'=>1,'D'=>1
            ];
            // add joined columns, if any
            if($val == 'branch_id'){
                $cols['branch'] = ['column'=>'branch','dbcolumn'=>'branches.branch',
                'caption'=>'Branch',
                'type' => 'text',
                'B'=>1,'R'=>1,'E'=>0,'A'=>0,'D'=>1
                ];
            }
            if($val == 'role_id'){
                $cols['role'] = ['column'=>'role','dbcolumn'=>'roles.role',
                'caption'=>'Role',
                'type' => 'text',
                'B'=>1,'R'=>1,'E'=>0,'A'=>0,'D'=>1
                ];
            }
        } 
        // modify defaults
        $cols['password']['B'] = 0;
        $cols['status']['B'] = 0;
        $cols['remember_token']['B'] = 0;
        $cols['remember_token']['R'] = 0;
        $cols['remember_token']['E'] = 0;
        $cols['remember_token']['A'] = 0;
        $cols['email_verified_at']['B'] = 0;
        $cols['email_verified_at']['R'] = 0;
        $cols['email_verified_at']['E'] = 0;
        $cols['email_verified_at']['A'] = 0;
        $cols['password']['type'] = 'password';
        $cols['status']['type'] = 'enum';
        $cols['status']['enum_values'] = ['1'=>'Aktif','0'=>'Tidak Aktif'];
        $cols['branch_id']['caption'] = 'Branch';
        $cols['branch_id']['type'] = 'dropdown';
        $cols['branch_id']['dropdown_model'] = 'App\Branch';
        $cols['branch_id']['dropdown_value'] = 'id';
        $cols['branch_id']['dropdown_caption'] = 'branch';
        $cols['branch_id']['B'] = 0;
        $cols['role_id']['caption'] = 'Role';
        $cols['role_id']['type'] = 'dropdown';
        $cols['role_id']['dropdown_model'] = 'App\Role';
        $cols['role_id']['dropdown_value'] = 'id';
        $cols['role_id']['dropdown_caption'] = 'role';
        $cols['role_id']['B'] = 0;

        $this->cols = $cols;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cols = $this->cols;        
        return view('user.index',compact('cols'));
    }

    public function indexjson()
    {
        return datatables(User::select('users.*','branch','role')
        ->leftJoin('branches','branch_id','branches.id')
        ->leftJoin('roles','role_id','roles.id')
        )->addColumn('action', function ($dt) {
            return view('user.action',compact('dt'));
        })
        ->toJson();
    }

    public function csvall()
    {
        $export = User::all();
        $filename = 'nujeks-user.csv';
        $temp = 'temp/'.$filename;
        (new FastExcel($export))->export('temp/nujeks-user.csv');
        $headers = [
            'Content-Type: text/csv',
            ];
        return response()->download($temp, $filename, $headers)->deleteFileAfterSend(true);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cols = $this->cols;        
        return view('user.createupdate',compact('cols'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:users',
            'email' => 'required|unique:users',
            'password' => 'required|unique:users',
        ]);

        $requestData = $request->all();
        if(!empty($requestData['password'])){
            $requestData['password'] = Hash::make($requestData['password']);
        }else{
            unset($requestData['password']);
        }
        User::create($requestData);
        Session::flash('message', 'Pengguna ditambahkan'); 
        Session::flash('alert-class', 'alert-success'); 
        return redirect('user');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $cols = $this->cols;        
        $item = user::find($user->id);
        return view('user.createupdate',compact('cols','item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|unique:users,name,'.$user->id,
            'email' => 'required|unique:users,email,'.$user->id,
        ]);
        
        $requestData = $request->all();
        if(!empty($requestData['password'])){
            $requestData['password'] = Hash::make($requestData['password']);
        }else{
            unset($requestData['password']);
        }        
        User::find($user->id)->update($requestData);
        Session::flash('message', 'Pengguna diubah'); 
        Session::flash('alert-class', 'alert-success'); 
        return redirect('user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        User::destroy($user->id);
        Session::flash('message', 'Pengguna dihapus'); 
        Session::flash('alert-class', 'alert-success'); 
        return redirect('user');
    }
    
    public function destroymulti(Request $request)
    {
        $ids = htmlentities($request->id);
        User::whereRaw('id in ('.$ids.')')->delete();
        Session::flash('message', 'Pengguna dihapus'); 
        Session::flash('alert-class', 'alert-success'); 
        return redirect('user');
    }

    public function hashunhashed()
    {
        $user = User::whereRaw('LENGTH(password) < 20')->get();
        foreach ($user as $val){
            $hashpass = Hash::make($val->password);
            User::find($val->id)->update(['password'=>$hashpass]);
        }
    }
}
