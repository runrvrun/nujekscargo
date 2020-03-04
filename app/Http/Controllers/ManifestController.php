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
            if($val == 'destination2_province_id'){
                $cols['destination2'] = ['column'=>'destination2','dbcolumn'=>'des2.province',
                    'caption'=>'Destination 2',
                    'type' => 'text',
                    'B'=>1,'R'=>1,'E'=>0,'A'=>0,'D'=>1
                ];
            }
            if($val == 'destination3_province_id'){
                $cols['destination3'] = ['column'=>'destination3','dbcolumn'=>'des3.province',
                    'caption'=>'Destination 3',
                    'type' => 'text',
                    'B'=>1,'R'=>1,'E'=>0,'A'=>0,'D'=>1
                ];
            }
            if($val == 'destination4_province_id'){
                $cols['destination4'] = ['column'=>'destination4','dbcolumn'=>'des4.province',
                    'caption'=>'Destination 4',
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
        $cols['no_spb'] = ['column'=>'no_spb','dbcolumn'=>'spbs.no_spb',
            'caption'=>'SPB',
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
        $cols['destination2_province_id']['caption'] = 'Destination 2';
        $cols['destination2_province_id']['type'] = 'dropdown';
        $cols['destination2_province_id']['dropdown_model'] = 'App\Province';
        $cols['destination2_province_id']['dropdown_value'] = 'id';
        $cols['destination2_province_id']['dropdown_caption'] = 'province';
        $cols['destination2_province_id']['dropdown_firstempty'] = 1;
        $cols['destination2_province_id']['B'] = 0;
        $cols['destination3_province_id']['caption'] = 'Destination 3';
        $cols['destination3_province_id']['type'] = 'dropdown';
        $cols['destination3_province_id']['dropdown_model'] = 'App\Province';
        $cols['destination3_province_id']['dropdown_value'] = 'id';
        $cols['destination3_province_id']['dropdown_caption'] = 'province';
        $cols['destination3_province_id']['dropdown_firstempty'] = 1;
        $cols['destination3_province_id']['B'] = 0;
        $cols['destination4_province_id']['caption'] = 'Destination 4';
        $cols['destination4_province_id']['type'] = 'dropdown';
        $cols['destination4_province_id']['dropdown_model'] = 'App\Province';
        $cols['destination4_province_id']['dropdown_value'] = 'id';
        $cols['destination4_province_id']['dropdown_caption'] = 'province';
        $cols['destination4_province_id']['dropdown_firstempty'] = 1;
        $cols['destination4_province_id']['B'] = 0;
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
        * user cabang hanya bisa lihat manifest berasal dari cabangnya, 
        * atau menuju provinsi cabangnya
        * operasional cabang hanya bisa lihat manifest dari cabangnya yang drivernya dia
        */
        $userbranch = Branch::find(Auth::user()->branch_id);
        $manifest = Manifest::select('manifests.*','ori.province as origin','des.province as destination'
        ,'des2.province as destination2','des3.province as destination3','des4.province as destination4','users.name as driver','no_plate')
        ->addSelect(DB::raw('count(DISTINCT spb_id) as count_spb'))
        ->addSelect(DB::raw('GROUP_CONCAT(DISTINCT no_spb ORDER BY no_spb ASC SEPARATOR \', \') as no_spb'))
        ->leftJoin('provinces as ori','origin_province_id','ori.id')
        ->leftJoin('provinces as des','destination_province_id','des.id')
        ->leftJoin('provinces as des2','destination2_province_id','des2.id')
        ->leftJoin('provinces as des3','destination3_province_id','des3.id')
        ->leftJoin('provinces as des4','destination4_province_id','des4.id')
        ->leftJoin('users','driver_id','users.id')
        ->leftJoin('vehicles','vehicle_id','vehicles.id')
        ->leftJoin('manifest_spbs','manifest_spbs.manifest_id','manifests.id')
        ->leftJoin('spbs','spbs.id','manifest_spbs.spb_id')
        ->groupBy('manifests.id');
        
        // cabang, hanya tampilkan yang asal/tujuan cabangnya
        if($userbranch->type != 'Pusat'){
            // $manifest->where('origin_province_id',$userbranch->province_id);
            $manifest->where(function ($q) use ($userbranch) {
                $q->where('origin_province_id',$userbranch->province_id)
                    ->orWhere('destination_province_id',$userbranch->province_id)
                    ->orWhere('destination2_province_id',$userbranch->province_id)
                    ->orWhere('destination3_province_id',$userbranch->province_id)
                    ->orWhere('destination4_province_id',$userbranch->province_id)
                    ->orWhere('manifests.created_by',Auth::user()->id);
            });
        }
        
        // operasional jakarta/cabang hanya tampilkan yang dia sebagai driver
        if(Auth::user()->role_id == 6 || Auth::user()->role_id == 9){
            // $manifest->where('driver_id',Auth::user()->id);
            $manifest->where(function ($q) {
                $q->where('driver_id',Auth::user()->id)
                    ->orWhere('manifests.created_by',Auth::user()->id);
            });
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
        $userbranch = Branch::find(Auth::user()->branch_id);
        return view('manifest.createupdate',compact('cols','no_manifest','userbranch'));
    }
    
    public function next_no_manifest($branch_id){
        $branch = Branch::find($branch_id);
        // $manifest = Manifest::selectRaw('MAX(SUBSTR(no_manifest,8)) as max_manifest_no')->whereRaw('no_manifest LIKE (\'MAID'.$branch->code.'%\')')->first();
        $manifest = Manifest::selectRaw('MAX(RIGHT(no_manifest,6)) as max_manifest_no')->whereRaw('no_manifest LIKE (\'MAID'.$branch->code.'%\')')->first();
        $nextmanifest = $manifest->max_manifest_no + 1;
        $next_manifest_no = 'MAID'.$branch->code.str_pad($nextmanifest,6,'0',STR_PAD_LEFT);
        return $next_manifest_no;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {//alpha_num|max:12|min:12|
        $request->validate([
            'title' => 'required',
            'no_manifest' => 'required|unique:manifests,no_manifest,null,id,deleted_at,NULL',
        ]);

        $requestData = $request->all();
        // if create manifest from spb, remove from requestData for insert
        if(isset($request->spbids)){
            unset($requestData['spbids']);
        }
        $requestData['created_by'] = Auth::user()->id;
        $manifest = Manifest::create($requestData);

        // if create manifest from spb, add spb like setmanifestmulti
        if(isset($request->spbids)){
            $spb_add = str_replace(' ','',$request->spbids);        
            $spb_add = preg_split('@,@', $spb_add, NULL, PREG_SPLIT_NO_EMPTY);
            foreach($spb_add as $val){
                $spb = Spb::where('id',$val)->first(); // use id, not no_spb
                $spbexist = Manifest_spb::where('manifest_id',$manifest->id)->where('spb_id',$spb->id)->first();
                if($spbexist){
                    continue;
                }
                Manifest_spb::create(['manifest_id'=>$manifest->id,'spb_id'=>$spb->id]);
            }
        }

        Session::flash('message', 'Manifest dibuat'); 
        Session::flash('alert-class', 'alert-success'); 
        return redirect('manifest/'.$manifest->id.'/spb');
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
        $spb = Spb::with('items')->select('spbs.*','customer','customers.address','spbs.address as spbaddress')
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
        length*width*height*bale/1000000 as volume,packaging,no_po")
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
        // length*width*height*bale/1000000 as volume,packaging,no_po")
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
            if($val == 'created_by'){
                $cols['add_by'] = ['column'=>'add_by','dbcolumn'=>'users.name',
                    'caption'=>'Masuk Manifest',
                    'type' => 'text',
                    'B'=>1,'R'=>1,'E'=>0,'A'=>0,'D'=>1
                ];
                $cols['creator'] = ['column'=>'creator','dbcolumn'=>'creator.name',
                    'caption'=>'Created By',
                    'type' => 'text',
                    'B'=>1,'R'=>1,'E'=>0,'A'=>0,'D'=>1
                ];
            }
            if($val == 'updated_by'){
                $cols['editor'] = ['column'=>'editor','dbcolumn'=>'editor.name',
                    'caption'=>'Updated By',
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
        $cols['created_by']['B'] = 0;
        $cols['updated_by']['B'] = 0;

        $manifest = Manifest::select('manifests.*','origins.province as origin','destinations.province as destination')
        ->leftJoin('provinces as origins','origin_province_id','origins.id')
        ->leftJoin('provinces as destinations','destination_province_id','destinations.id')
        ->where('manifests.id',$manifest_id)->first();
        return view('manifest.spbindex',compact('cols','manifest'));
    }

    public function spbindexjson($manifest_id,Request $request)
    {
        $spbwhspic = Spb::select('spbs.id')->distinct()
        ->join('spb_warehouses','spbs.id','spb_id')
        ->leftJoin('manifest_spbs','manifest_spbs.spb_id','spbs.id')
        ->where('manifest_id',$manifest_id)
        ->whereNotNull('user_id')->get();

        $spb = Spb::select('spbs.*','manifest_id','customer','province','city','status_code', 'creator.name as creator', 'editor.name as editor', 'adder.name as add_by')
        ->leftJoin('customers','customer_id','customers.id')
        ->leftJoin('cities','spbs.city_id','cities.id')
        ->leftJoin('provinces','spbs.province_id','provinces.id')
        ->leftJoin('spb_statuses','spbs.spb_status_id','spb_statuses.id')
        ->leftJoin('manifest_spbs','manifest_spbs.spb_id','spbs.id')
        ->leftJoin('users as creator','spbs.created_by','creator.id')
        ->leftJoin('users as editor','spbs.updated_by','editor.id')
        ->leftJoin('users as adder','manifest_spbs.created_by','adder.id')
        ->where('manifest_id',$manifest_id);
        
        if($request->filterstatus >= 0){
            $spb->where('status_code',$request->filterstatus);
        }
        // operasional jakarta/cabang hanya tampilkan yang bukan RCV dan bukan WHS+pic
        if(Auth::user()->role_id == 6 || Auth::user()->role_id == 9){
            $spb ->where(function ($q) {
                $q->whereNull('spb_status_id')
                    ->orWhere('spb_status_id', '!=', 4);
                }); // RCV
            $spb->whereNotIn('spbs.id',$spbwhspic);
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
            $spbexist = Manifest_spb::where('manifest_id',$request->manifest_id)->where('spb_id',$spb->id)->first();
            if($spbexist){
                continue;
            }
            Manifest_spb::create(['manifest_id'=>$request->manifest_id,'spb_id'=>$spb->id, 'created_by'=> Auth::user()->id]);
        }
        Session::flash('message', 'SPB ditambahkan ke Manifest'); 
        Session::flash('alert-class', 'alert-success'); 
        return redirect('manifest/'.$request->manifest_id.'/spb');
    }

    public function spbupdatestatus(Request $request)
    {
        // dd($request->all());
        if($request->process == 'Lainnya' && !empty($request->processother)){
            $request->process = $request->processother;
        }
        if($request->process == 'Lainnya' && empty($request->processother)){
            $request->process = '';
        }

        if(!empty($request->sel_spb_id)){
            Spb::find($request->sel_spb_id)->update(['spb_status_id'=>$request->spb_status_id]);
            $track = Spb_track::create(['spb_id'=>$request->sel_spb_id,'spb_status_id'=>$request->spb_status_id,'process'=>$request->process,'city_id'=>$request->city_id,'note'=>$request->spb_status_note,'created_by'=>Auth::user()->id,'track'=>$request->track]);
            if(!empty($request->warehouse_city_id)){
                Spb_warehouse::create(['spb_id'=>$request->sel_spb_id, 'spb_track_id'=>$track->id,'city_id'=>$request->warehouse_city_id,'user_id'=>$request->user_id]);
            }
            if(!empty($request->spb_status_note)){
                Spb::find($request->sel_spb_id)->update(['note'=>$request->spb_status_note]);
            }
        }elseif(!empty($request->sel_spb_ids)){
            $sel_spb_ids = explode('%2C',$request->sel_spb_ids);
            foreach($sel_spb_ids as $key=>$val){
                Spb::find($val)->update(['spb_status_id'=>$request->spb_status_id]);
                $track = Spb_track::create(['spb_id'=>$val,'spb_status_id'=>$request->spb_status_id,'process'=>$request->process,'city_id'=>$request->city_id,'created_by'=>Auth::user()->id,'track'=>$request->track]);
                if(!empty($request->warehouse_city_id)){
                    Spb_warehouse::create(['spb_id'=>$val, 'spb_track_id'=>$track->id,'city_id'=>$request->warehouse_city_id,'user_id'=>$request->user_id]);
                }
                if(!empty($request->spb_status_note)){
                    Spb::find($val)->update(['note'=>$request->spb_status_note]);
                }
            }
        }
        // if operasional, count undelivered spb
        if(Auth::user()->role_id == 6 || Auth::user()->role_id == 9){
            $spbwhspic = Spb::select('spbs.id')->distinct()
            ->join('spb_warehouses','spbs.id','spb_id')
            ->leftJoin('manifest_spbs','manifest_spbs.spb_id','spbs.id')
            // ->where('manifest_id',$manifest_id)
            ->where('spb_warehouses.created_by',Auth::user()->id)
            // ->whereNotNull('user_id')
            ->get();
            // dd($spbwhspic);

            $manifest = Manifest::where('driver_id',Auth::user()->id)->first();
            $spb_undelivered = Spb::leftJoin('manifest_spbs','manifest_spbs.spb_id','spbs.id')
            ->where('manifest_id',$manifest->id)
            ->where('spb_status_id','!=',4)
            ->whereNotIn('spb_id',$spbwhspic)
            ->count();
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

    public function createfromspb(Request $request){
        $spbids = $request->id;
        $no_manifest = $this->next_no_manifest(Auth::user()->branch_id);
        $userbranch = Branch::find(Auth::user()->branch_id);
        $cols = $this->cols;        
        return view('manifest.createupdate',compact('cols','no_manifest','userbranch','spbids'));
    }
}
