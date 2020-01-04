<?php

namespace App\Http\Controllers;

use App\Manifest;
use App\Spb;
use App\Manifest_spb;
use App\Spb_track;
use App\Spb_warehouse;
use App\Item;
use App\Branch;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;
use Auth;
use DB;
use PDF;
use Schema;
use Session;
use Validator;
use App\Exports\ManifestsExport;
use Maatwebsite\Excel\Facades\Excel;

class ManifestController extends Controller
{
    private $cols;

    public function __construct()
    {
        // setup cols
        $dbcols = Schema::getColumnListing('manifests');//get all columns from DB
        foreach($dbcols as $key=>$val){
            // add bread props
            $cols[$val] = ['column'=>$val,'dbcolumn'=>$val,
                    'caption'=>ucwords(str_replace('_',' ',$val)),
                    'type' => 'text', 
                    'B'=>1,'R'=>1,'E'=>1,'A'=>1,'D'=>1
                ];
            // add joined columns, if any
            if($val == 'origin_province_id'){
                $cols['origin'] = ['column'=>'origin','dbcolumn'=>'ori.province',
                    'caption'=>'Origin',
                    'type' => 'text',
                    'B'=>1,'R'=>1,'E'=>0,'A'=>0,'D'=>1
                ];
            }
            if($val == 'destination_province_id'){
                $cols['destination'] = ['column'=>'destination','dbcolumn'=>'des.province',
                    'caption'=>'Destination',
                    'type' => 'text',
                    'B'=>1,'R'=>1,'E'=>0,'A'=>0,'D'=>1
                ];
            }
            if($val == 'driver_id'){
                $cols['driver'] = ['column'=>'driver','dbcolumn'=>'users.name',
                    'caption'=>'Driver',
                    'type' => 'text',
                    'B'=>1,'R'=>1,'E'=>0,'A'=>0,'D'=>1
                ];
            }
            if($val == 'vehicle_id'){
                $cols['no_plate'] = ['column'=>'no_plate','dbcolumn'=>'vehicles.no_plate',
                    'caption'=>'Vehicle',
                    'type' => 'text',
                    'B'=>1,'R'=>1,'E'=>0,'A'=>0,'D'=>1
                ];
            }
        } 
        $cols['count_spb'] = ['column'=>'count_spb','dbcolumn'=>'count_spb',
            'caption'=>'Jumlah SPB',
            'type' => 'text',
            'B'=>1,'R'=>1,'E'=>0,'A'=>0,'D'=>1
        ];
        // modify defaults
        $cols['origin_province_id']['caption'] = 'Origin';
        $cols['origin_province_id']['type'] = 'dropdown';
        $cols['origin_province_id']['dropdown_model'] = 'App\Province';
        $cols['origin_province_id']['dropdown_value'] = 'id';
        $cols['origin_province_id']['dropdown_caption'] = 'province';
        $cols['origin_province_id']['B'] = 0;
        $cols['destination_province_id']['caption'] = 'Destination';
        $cols['destination_province_id']['type'] = 'dropdown';
        $cols['destination_province_id']['dropdown_model'] = 'App\Province';
        $cols['destination_province_id']['dropdown_value'] = 'id';
        $cols['destination_province_id']['dropdown_caption'] = 'province';
        $cols['destination_province_id']['B'] = 0;
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
        $cols['driver_id']['R'] = 0;
        $cols['driver_id']['B'] = 0;
        $cols['driver_id']['A'] = 0;
        $cols['driver_id']['caption'] = 'Driver';
        $cols['driver_id']['type'] = 'dropdown';
        $cols['driver_id']['dropdown_model'] = 'App\User';
        $cols['driver_id']['dropdown_value'] = 'id';
        $cols['driver_id']['dropdown_caption'] = 'name';
        $cols['vehicle_id']['R'] = 0;
        $cols['vehicle_id']['B'] = 0;
        $cols['vehicle_id']['A'] = 0;
        $cols['vehicle_id']['caption'] = 'Vehicle';
        $cols['vehicle_id']['type'] = 'dropdown';
        $cols['vehicle_id']['dropdown_model'] = 'App\Vehicle';
        $cols['vehicle_id']['dropdown_value'] = 'id';
        $cols['vehicle_id']['dropdown_caption'] = 'no_plate';

        $this->cols = $cols;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cols = $this->cols;        
        if($request->branch_id){
            $branch = Branch::find($request->branch_id);
        }else{
            $branch = null;
        }
        return view('manifest.index',compact('cols','branch'));
    }

    public function indexjson(Request $request)
    {
        /*
        * RULES
        * user cabang hanya bisa lihat manifest berasal dari cabangnya
        * operasional cabang hanya bisa lihat manifest dari cabangnya yang drivernya dia
        */
        $userbranch = Branch::find(Auth::user()->branch_id);
        $manifest = Manifest::select('manifests.*','ori.province as origin','des.province as destination','users.name as driver','no_plate')
        ->addSelect(DB::raw('count(DISTINCT spb_id) as count_spb'))
        ->leftJoin('provinces as ori','origin_province_id','ori.id')
        ->leftJoin('provinces as des','destination_province_id','des.id')
        ->leftJoin('users','driver_id','users.id')
        ->leftJoin('vehicles','vehicle_id','vehicles.id')
        ->leftJoin('manifest_spbs','manifest_spbs.manifest_id','manifests.id')
        ->groupBy('manifests.id');
        
        if($userbranch->type != 'Pusat'){
            $manifest->where('origin_province_id',$userbranch->province_id);
        }
        
        // operasional jakarta/cabang hanya tampilkan yang dia sebagai driver
        if(Auth::user()->role_id == 6 || Auth::user()->role_id == 9){
            $manifest->where('driver_id',Auth::user()->id);
        }

        if($request->startdate > '1990-01-01'){
            $manifest->whereBetween('manifests.created_at',[$request->startdate.' 00:00:00',$request->enddate.' 23:59:59']);
        }

        if($request->branch_province_id){
            $manifest->where('origin_province_id',$request->branch_province_id);
        }

        return datatables($manifest
        )->addColumn('action', function ($dt) {
            return view('manifest.action',compact('dt'));
        })
        ->toJson();
    }

    public function csvall()
    {
        $export = Manifest::all();
        $filename = 'nujeks-manifest.csv';
        $temp = 'temp/'.$filename;
        (new FastExcel($export))->export('temp/nujeks-manifest.csv');
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
        $no_manifest = $this->next_no_manifest(Auth::user()->branch_id);
        $cols = $this->cols;        
        return view('manifest.createupdate',compact('cols','no_manifest'));
    }
    
    public function next_no_manifest($branch_id){
        $branch = Branch::find($branch_id);
        $manifest = Manifest::selectRaw('MAX(SUBSTR(no_manifest,6))+1 as next_manifest_no')->whereRaw('no_manifest LIKE (\'MAID'.$branch->code.'%\')')->first();
        $next_manifest_no = 'MAID'.$branch->code.str_pad($manifest->next_manifest_no,6,'0',STR_PAD_LEFT);
        return $next_manifest_no;
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
            'no_manifest' => 'required|unique:manifests,no_manifest,null,id,deleted_at,NULL',
        ]);

        $requestData = $request->all();
        Manifest::create($requestData);
        Session::flash('message', 'Manifest ditambahkan'); 
        Session::flash('alert-class', 'alert-success'); 
        return redirect('manifest');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Manifest  $manifest
     * @return \Illuminate\Http\Response
     */
    public function show(Manifest $manifest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Manifest  $manifest
     * @return \Illuminate\Http\Response
     */
    public function edit(Manifest $manifest)
    {
        $cols = $this->cols;        
        $item = Manifest::find($manifest->id);
        return view('manifest.createupdate',compact('cols','item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Manifest  $manifest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Manifest $manifest)
    {
        $request->validate([
            'no_manifest' => 'required|unique:manifests,no_manifest,'.$manifest->id.',id,deleted_at,NULL'
        ]);

        $requestData = $request->all();
        Manifest::find($manifest->id)->update($requestData);
        Session::flash('message', 'Manifest diubah'); 
        Session::flash('alert-class', 'alert-success'); 
        return redirect('manifest');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Manifest  $manifest
     * @return \Illuminate\Http\Response
     */
    public function destroy(Manifest $manifest)
    {
        Manifest::find($manifest->id)->update(['updated_by'=>Auth::user()->id]);
        Manifest::destroy($manifest->id);
        Session::flash('message', 'Manifest dihapus'); 
        Session::flash('alert-class', 'alert-success'); 
        return redirect('manifest');
    }
    
    public function destroymulti(Request $request)
    {
        $ids = htmlentities($request->id);
        Manifest::whereRaw('id in ('.$ids.')')->delete();
        Session::flash('message', 'Manifest dihapus'); 
        Session::flash('alert-class', 'alert-success'); 
        return redirect('manifest');
    }
    
    public function report($manifest_id)
    {
        $manifest = Manifest::select('manifests.*','name')->where('manifests.id',$manifest_id)
        ->leftJoin('users','created_by','users.id')->first();
        $spb = Spb::with('items')->select('spbs.*','customer')
        ->leftJoin('customers','customer_id','customers.id')
        ->leftJoin('manifest_spbs','manifest_spbs.spb_id','spbs.id')
        ->where('manifest_id',$manifest_id)
        ->get();
        // return view('manifest.report',compact('manifest','spb'));
        $pdf = PDF::loadview('manifest.report',compact('manifest','spb'),[],['title' => 'Nujeks - Manifest_'.$manifest->no_manifest.'.pdf']);
    	return $pdf->stream();
    }
    
    public function fastexcel($manifest_id)
    {
        $man = Manifest::find($manifest_id);
        $manifest = Spb::selectRaw("no_spb,customer as pengirim,recipient as penerima,item as barang,
        bale as koli,weight as berat, bale*weight as total_berat,
        CONCAT(length,'x',width,'x',height) as dimensi,
        length*width*height*bale/1000 as volume,packaging,no_po")
        ->leftJoin('customers','customer_id','customers.id')
        ->leftJoin('items','spb_id','spbs.id')
        ->leftJoin('manifest_spbs','manifest_spbs.spb_id','spbs.id')
        ->where('manifest_id',$manifest_id)
        ->get();
        return (new FastExcel($manifest))->download('Nujeks_manifest_'.$man->no_manifest.'.csv');
    }
    
    public function excel($manifest_id)
    {
        $man = Manifest::find($manifest_id);
        // $manifest = Spb::selectRaw("no_spb,customer as pengirim,recipient as penerima,item as barang,
        // bale as koli,weight as berat, bale*weight as total_berat,
        // CONCAT(length,'x',width,'x',height) as dimensi,
        // length*width*height*bale/1000 as volume,packaging,no_po")
        // ->leftJoin('customers','customer_id','customers.id')
        // ->leftJoin('items','spb_id','spbs.id')
        // ->leftJoin('manifest_spbs','manifest_spbs.spb_id','spbs.id')
        // ->where('manifest_id',$manifest_id)
        // ->get();
        return Excel::download(new ManifestsExport($manifest_id), 'Nujeks_manifest_'.$man->no_manifest.'.xlsx');
        // return (new ManifestsExport($manifest_id))->download('Nujeks_manifest_'.$man->no_manifest.'.xlsx');
    }

    public function spbindex($manifest_id)
    {
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
            if($val == 'spb_status_id'){
                $cols['status_code'] = ['column'=>'status_code','dbcolumn'=>'spb_statuses.status_code',
                    'caption'=>'Status',
                    'type' => 'text',
                    'B'=>1,'R'=>1,'E'=>0,'A'=>0,'D'=>1
                ];
            }
        } 
        $cols['customer_id']['B'] = 0;
        $cols['province_id']['B'] = 0;
        $cols['city_id']['B'] = 0;
        $cols['spb_status_id']['B'] = 0;
        $cols['spb_payment_type_id']['B'] = 0;
        $cols['manifest_id']['B'] = 0;
        $cols['branch_id']['B'] = 0;
        $cols['deleted_at']['B'] = 0;
        $cols['note']['B'] = 0;

        $manifest = Manifest::select('manifests.*','origins.province as origin','destinations.province as destination')
        ->leftJoin('provinces as origins','origin_province_id','origins.id')
        ->leftJoin('provinces as destinations','destination_province_id','destinations.id')
        ->where('manifests.id',$manifest_id)->first();
        return view('manifest.spbindex',compact('cols','manifest'));
    }

    public function spbindexjson($manifest_id,Request $request)
    {
        $spb = Spb::select('spbs.*','manifest_id','customer','province','city','status_code')
        ->leftJoin('customers','customer_id','customers.id')
        ->leftJoin('cities','spbs.city_id','cities.id')
        ->leftJoin('provinces','spbs.province_id','provinces.id')
        ->leftJoin('spb_statuses','spbs.spb_status_id','spb_statuses.id')
        ->leftJoin('manifest_spbs','manifest_spbs.spb_id','spbs.id')
        ->where('manifest_id',$manifest_id);
        
        if($request->filterstatus >= 0){
            $spb->where('status_code',$request->filterstatus);
        }
        // operasional jakarta/cabang hanya tampilkan yang bukan RCV TODO(dan bukan WHS+pic)
        if(Auth::user()->role_id == 6 || Auth::user()->role_id == 9){
            $spb->where('spb_status_id','!=',4);
        }
        
        return datatables($spb
        )->addColumn('action', function ($dt) {
            return view('manifest.spbaction',compact('dt'));
        })
        ->toJson();
    }

    public function spbdestroy(Request $request)
    {
        $manifest_spb = Manifest_spb::where('manifest_id',$request->manifest_id)->where('spb_id',$request->spb_id)->first();
        Manifest_spb::destroy($manifest_spb->id);
        Session::flash('message', 'SPB dihapus dari Manifest'); 
        Session::flash('alert-class', 'alert-success'); 
        return redirect('manifest/'.$request->manifest_id.'/spb');
    }
    
    public function spbdestroymulti(Request $request)
    {
        $ids = htmlentities($request->id);
        $id = explode(',',$ids);
        foreach($id as $val){
            $manifest_spb = Manifest_spb::where('manifest_id',$request->manifest_id)->where('spb_id',$val)->first();
            Manifest_spb::destroy($manifest_spb->id);
        }
        Session::flash('message', 'SPB dihapus dari Manifest'); 
        Session::flash('alert-class', 'alert-success'); 
        return redirect('manifest/'.$request->manifest_id.'/spb');
    }

    public function setmanifestmulti(Request $request){
        $spb_add = str_replace(' ','',$request->spb_add);        
        $spb_add = preg_split('@,@', $spb_add, NULL, PREG_SPLIT_NO_EMPTY);
        foreach($spb_add as $val){
            $spb = Spb::where('no_spb',$val)->first();
            Manifest_spb::create(['manifest_id'=>$request->manifest_id,'spb_id'=>$spb->id]);
        }
        Session::flash('message', 'SPB ditambahkan ke Manifest'); 
        Session::flash('alert-class', 'alert-success'); 
        return redirect('manifest/'.$request->manifest_id.'/spb');
    }

    public function spbupdatestatus(Request $request)
    {
        if($request->process == 'Lainnya' && !empty($request->processother)){
            $request->process = $request->processother;
        }

        if(!empty($request->sel_spb_id)){
            Spb::find($request->sel_spb_id)->update(['spb_status_id'=>$request->spb_status_id]);
            Spb_track::create(['spb_id'=>$request->sel_spb_id,'spb_status_id'=>$request->spb_status_id,'process'=>$request->process,'city_id'=>$request->city_id,'created_by'=>Auth::user()->id,'track'=>$request->track]);
            if(!empty($request->warehouse_city_id)){
                Spb_warehouse::create(['spb_id'=>$request->sel_spb_id,'city_id'=>$request->warehouse_city_id,'user_id'=>$request->user_id]);
            }
            if(!empty($request->spb_status_note)){
                Spb::find($request->sel_spb_id)->update(['note'=>$request->spb_status_note]);
            }
        }elseif(!empty($request->sel_spb_ids)){
            $sel_spb_ids = explode('%2C',$request->sel_spb_ids);
            foreach($sel_spb_ids as $key=>$val){
                Spb::find($val)->update(['spb_status_id'=>$request->spb_status_id]);
                Spb_track::create(['spb_id'=>$val,'spb_status_id'=>$request->spb_status_id,'process'=>$request->process,'city_id'=>$request->city_id,'created_by'=>Auth::user()->id,'track'=>$request->track]);
                if(!empty($request->warehouse_city_id)){
                    Spb_warehouse::create(['spb_id'=>$val,'city_id'=>$request->warehouse_city_id,'user_id'=>$request->user_id]);
                }
                if(!empty($request->spb_status_note)){
                    Spb::find($val)->update(['note'=>$request->spb_status_note]);
                }
            }
        }
        // if operasional, count undelivered spb
        if(Auth::user()->role_id == 6 || Auth::user()->role_id == 9){
            $manifest = Manifest::where('driver_id',Auth::user()->id)->first();
            $spb_undelivered = Spb::where('manifest_id',$manifest->id)->where('spb_status_id','!=',4)->count();
            session(['spb_undelivered'=>$spb_undelivered]);
        }
        Session::flash('message', 'Status SPB diubah'); 
        Session::flash('alert-class', 'alert-success'); 
        return redirect('manifest/'.$request->manifest_id.'/spb');
    }

    public function my(){
        $manifest = Manifest::where('driver_id',Auth::user()->id)->first();
        if($manifest){
            return redirect ('manifest/'.$manifest->id.'/spb');
        }else{
            return redirect ('manifest');
        }
    }
}
