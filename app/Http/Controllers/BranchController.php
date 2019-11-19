<?php

namespace App\Http\Controllers;

use App\Branch;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;
use Schema;
use Session;
use Validator;

class BranchController extends Controller
{
    private $cols;

    public function __construct()
    {
        //setup cols
        $dbcols = Schema::getColumnListing('branches');//get all columns from DB
        foreach($dbcols as $key=>$val){
            // add bread props
            $cols[$val] = ['column'=>$val,'dbcolumn'=>$val,
                'caption'=>ucwords(str_replace('_',' ',$val)),
                'type' => 'text',
                'B'=>1,'R'=>1,'E'=>1,'A'=>1,'D'=>1
            ];
            // add joined columns, if any
            if($val == 'province_id'){
                $cols['province'] = ['column'=>'province','dbcolumn'=>'provinces.province',
                'caption'=>'Province',
                'type' => 'text',
                'B'=>1,'R'=>1,'E'=>0,'A'=>0,'D'=>1
                ];
            }
            if($val == 'city_id'){
                $cols['city'] = ['column'=>'city','dbcolumn'=>'cities.city',
                'caption'=>'City',
                'type' => 'text',
                'B'=>1,'R'=>1,'E'=>0,'A'=>0,'D'=>1
                ];
            }
        } 
        // modify defaults
        $cols['code']['type'] = 'number';
        $cols['address']['type'] = 'textarea';
        $cols['phone']['type'] = 'number';
        $cols['fax']['type'] = 'number';
        $cols['email']['type'] = 'email';
        $cols['email_acc']['type'] = 'email';
        $cols['type']['type'] = 'enum';
        $cols['type']['enum_values'] = ['Cabang'=>'Cabang','Pusat'=>'Pusat'];
        $cols['province_id']['caption'] = 'Province';
        $cols['province_id']['type'] = 'dropdown';
        $cols['province_id']['dropdown_model'] = 'App\Province';
        $cols['province_id']['dropdown_value'] = 'id';
        $cols['province_id']['dropdown_caption'] = 'province';
        $cols['province_id']['B'] = 0;
        $cols['city_id']['caption'] = 'City';
        $cols['city_id']['type'] = 'dropdown';
        $cols['city_id']['dropdown_model'] = 'App\City';
        $cols['city_id']['dropdown_value'] = 'id';
        $cols['city_id']['dropdown_caption'] = 'city';
        $cols['city_id']['B'] = 0;

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
        return view('branch.index',compact('cols'));
    }

    public function indexjson()
    {
        return datatables(Branch::select('branches.*','province','city')
        ->leftJoin('provinces','province_id','provinces.id')
        ->leftJoin('cities','city_id','cities.id')
        )->addColumn('action', function ($dt) {
            return view('branch.action',compact('dt'));
        })
        ->toJson();
    }

    public function csvall()
    {
        $export = Branch::all();
        $filename = 'nujeks-branch.csv';
        $temp = 'temp/'.$filename;
        (new FastExcel($export))->export('temp/nujeks-branch.csv');
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
        return view('branch.createupdate',compact('cols'));
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
            'branch' => 'required|unique:branches',
            'code' => 'required|unique:branches',
            'initial' => 'required|unique:branches',
        ]);

        $requestData = $request->all();
        Branch::create($requestData);
        Session::flash('message', 'Kantor Cabang ditambahkan'); 
        Session::flash('alert-class', 'alert-success'); 
        return redirect('branch');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function show(Branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function edit(Branch $branch)
    {
        $cols = $this->cols;        
        $item = branch::find($branch->id);
        return view('branch.createupdate',compact('cols','item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Branch $branch)
    {
        $request->validate([
            'branch' => 'required|unique:branches,branch,'.$branch->id,
            'code' => 'required|unique:branches,code,'.$branch->id,
            'initial' => 'required|unique:branches,initial,'.$branch->id,
        ]);

        $requestData = $request->all();
        Branch::find($branch->id)->update($requestData);
        Session::flash('message', 'Kantor Cabang diubah'); 
        Session::flash('alert-class', 'alert-success'); 
        return redirect('branch');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Branch $branch)
    {
        Branch::destroy($branch->id);
        Session::flash('message', 'Kantor Cabang dihapus'); 
        Session::flash('alert-class', 'alert-success'); 
        return redirect('branch');
    }
    
    public function destroymulti(Request $request)
    {
        $ids = htmlentities($request->id);
        Branch::whereRaw('id in ('.$ids.')')->delete();
        Session::flash('message', 'Kantor Cabang dihapus'); 
        Session::flash('alert-class', 'alert-success'); 
        return redirect('branch');
    }
}
