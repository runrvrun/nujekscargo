<?php

namespace App\Http\Controllers;

use App\Spb;
use App\Branch;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;
use Auth;
use Schema;
use Session;
use Validator;

class SpbController extends Controller
{
    private $cols;

    public function __construct()
    {
        // setup cols
        $dbcols = Schema::getColumnListing('spbs');//get all columns from DB
        foreach($dbcols as $key=>$val){
            // add bread props
            $cols[$val] = ['column'=>$val,'dbcolumn'=>$val,
                    'caption'=>ucwords(str_replace('_',' ',$val)),
                    'type' => 'text', 
                    'B'=>1,'R'=>1,'E'=>1,'A'=>1,'D'=>1
                ];
            // add joined columns, if any
            if($val == 'customer_id'){
                $cols['customer'] = ['column'=>'customer','dbcolumn'=>'customers.customer',
                    'caption'=>'Customer',
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
            if($val == 'province_id'){
                $cols['province'] = ['column'=>'province','dbcolumn'=>'provinces.province',
                    'caption'=>'Province',
                    'type' => 'text',
                    'B'=>1,'R'=>1,'E'=>0,'A'=>0,'D'=>1
                ];
            }
            if($val == 'spb_payment_type_id'){
                $cols['type'] = ['column'=>'type','dbcolumn'=>'spb_payment_types.type',
                    'caption'=>'Payment',
                    'type' => 'text',
                    'B'=>1,'R'=>1,'E'=>0,'A'=>0,'D'=>1
                ];
            }
            if($val == 'spb_status_id'){
                $cols['status_code'] = ['column'=>'status_code','dbcolumn'=>'spb_statuses.status_code',
                    'caption'=>'Status',
                    'type' => 'text',
                    'B'=>1,'R'=>1,'E'=>0,'A'=>0,'D'=>1
                ];
            }
        } 
        // modify defaults
        $cols['customer_id']['caption'] = 'Customer';
        $cols['customer_id']['type'] = 'dropdown';
        $cols['customer_id']['dropdown_model'] = 'App\Customer';
        $cols['customer_id']['dropdown_value'] = 'id';
        $cols['customer_id']['dropdown_caption'] = 'customer';
        $cols['customer_id']['B'] = 0;
        $cols['customer_id']['R'] = 0;
        $cols['city_id']['caption'] = 'City';
        $cols['city_id']['type'] = 'dropdown';
        $cols['city_id']['dropdown_model'] = 'App\City';
        $cols['city_id']['dropdown_value'] = 'id';
        $cols['city_id']['dropdown_caption'] = 'city';
        $cols['city_id']['B'] = 0;
        $cols['city_id']['R'] = 0;
        $cols['province_id']['caption'] = 'Province';
        $cols['province_id']['type'] = 'dropdown';
        $cols['province_id']['dropdown_model'] = 'App\Province';
        $cols['province_id']['dropdown_value'] = 'id';
        $cols['province_id']['dropdown_caption'] = 'province';
        $cols['province_id']['B'] = 0;
        $cols['province_id']['R'] = 0;
        $cols['spb_payment_type_id']['caption'] = 'Payment';
        $cols['spb_payment_type_id']['type'] = 'dropdown';
        $cols['spb_payment_type_id']['dropdown_model'] = 'App\Spb_payment_type';
        $cols['spb_payment_type_id']['dropdown_value'] = 'id';
        $cols['spb_payment_type_id']['dropdown_caption'] = 'type';
        $cols['spb_payment_type_id']['B'] = 0;
        $cols['spb_payment_type_id']['R'] = 0;
        $cols['spb_status_id']['caption'] = 'Status';
        $cols['spb_status_id']['type'] = 'dropdown';
        $cols['spb_status_id']['dropdown_model'] = 'App\Spb_status';
        $cols['spb_status_id']['dropdown_value'] = 'id';
        $cols['spb_status_id']['dropdown_caption'] = 'status';
        $cols['spb_status_id']['B'] = 0;
        $cols['spb_status_id']['R'] = 0;
        $cols['address']['B'] = 0;
        $cols['address']['type'] = 'textarea';
        $cols['created_by']['R'] = 0;
        $cols['created_by']['E'] = 0;
        $cols['created_by']['A'] = 0;
        $cols['updated_by']['R'] = 0;
        $cols['updated_by']['E'] = 0;
        $cols['updated_by']['A'] = 0;
        $cols['deleted_at']['B'] = 0;
        $cols['deleted_at']['R'] = 0;
        $cols['deleted_at']['E'] = 0;
        $cols['deleted_at']['A'] = 0;
        $cols['manifest_id']['B'] = 0;
        $cols['manifest_id']['R'] = 0;
        $cols['manifest_id']['E'] = 0;
        $cols['manifest_id']['A'] = 0;

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
        return view('spb.index',compact('cols'));
    }

    public function indexjson()
    {
        return datatables(Spb::select('spbs.*','customer','city','province','type','status_code','status')
        ->leftJoin('customers','customer_id','customers.id')
        ->leftJoin('cities','spbs.city_id','cities.id')
        ->leftJoin('provinces','spbs.province_id','provinces.id')
        ->leftJoin('spb_payment_types','spb_payment_type_id','spb_payment_types.id')
        ->leftJoin('spb_statuses','spb_Status_id','spb_statuses.id')
        )->addColumn('action', function ($dt) {
            return view('spb.action',compact('dt'));
        })
        ->toJson();
    }

    public function csvall()
    {
        $export = Spb::all();
        $filename = 'nujeks-spb.csv';
        $temp = 'temp/'.$filename;
        (new FastExcel($export))->export('temp/nujeks-spb.csv');
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
        $no_spb = $this->next_no_spb(Auth::user()->branch_id);
        $cols = $this->cols;        
        return view('spb.createupdate',compact('cols','no_spb'));
    }

    public function next_no_spb($branch_id){
        $branch = Branch::find($branch_id);
        $spb = Spb::selectRaw('MAX(SUBSTR(no_spb,6))+1 as next_spb_no')->whereRaw('no_spb LIKE (\'SPB'.$branch->code.'%\')')->first();
        $next_spb_no = 'SPB'.$branch->code.str_pad($spb->next_spb_no,6,'0',STR_PAD_LEFT);
        return $next_spb_no;
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
            'no_spb' => 'required|unique:spbs,no_spb,null,id,deleted_at,NULL',
        ]);

        $requestData = $request->all();
        $spb = Spb::create($requestData);
        Session::flash('message', 'SPB ditambahkan'); 
        Session::flash('alert-class', 'alert-success'); 
        return redirect('spb/'.$spb->id.'/item');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Spb  $spb
     * @return \Illuminate\Http\Response
     */
    public function show(Spb $spb)
    {
        $cols = $this->cols;        
        $item = Spb::select('spbs.*','customer','city','province','type')
        ->leftJoin('customers','customer_id','customers.id')
        ->leftJoin('cities','spbs.city_id','cities.id')
        ->leftJoin('provinces','spbs.province_id','provinces.id')
        ->leftJoin('spb_payment_types','spb_payment_type_id','spb_payment_types.id')
        ->where('spbs.id',$spb->id)->first();
        // dd($item);
        return view('spb.show',compact('cols','item'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Spb  $spb
     * @return \Illuminate\Http\Response
     */
    public function edit(Spb $spb)
    {
        $cols = $this->cols;        
        $item = Spb::find($spb->id);
        return view('spb.createupdate',compact('cols','item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Spb  $spb
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Spb $spb)
    {
        $request->validate([
            'no_spb' => 'required|unique:spbs,no_spb,'.$spb->id.',id,deleted_at,NULL'
        ]);

        $requestData = $request->all();
        Spb::find($spb->id)->update($requestData);
        Session::flash('message', 'SPB diubah'); 
        Session::flash('alert-class', 'alert-success'); 
        return redirect('spb');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Spb  $spb
     * @return \Illuminate\Http\Response
     */
    public function destroy(Spb $spb)
    {
        Spb::find($spb->id)->update(['updated_by'=>Auth::user()->id]);
        Spb::destroy($spb->id);
        Session::flash('message', 'SPB dihapus'); 
        Session::flash('alert-class', 'alert-success'); 
        return redirect('spb');
    }
    
    public function destroymulti(Request $request)
    {
        $ids = htmlentities($request->id);
        Spb::whereRaw('id in ('.$ids.')')->delete();
        Session::flash('message', 'SPB dihapus'); 
        Session::flash('alert-class', 'alert-success'); 
        return redirect('spb');
    }

    public function searchjson(Request $request)
    {
        return Spb::selectRaw("no_spb as `value`,CONCAT(customer,' -> ',COALESCE(recipient,''),' (',COALESCE(city,''),', ',COALESCE(province,''),')') AS `desc`")
        ->leftJoin('customers','customer_id','customers.id')
        ->leftJoin('cities','spbs.city_id','cities.id')
        ->leftJoin('provinces','spbs.province_id','provinces.id')
        ->whereNull('manifest_id')
        ->whereRaw('no_spb like \'%'.$request->term.'%\'')
        ->take(10)->get();
    }
}
