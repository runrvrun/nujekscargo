<?php

namespace App\Http\Controllers;

use App\Vehicle;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;
use Schema;
use Session;
use Validator;

class VehicleController extends Controller
{
    private $cols;

    public function __construct()
    {
        // setup cols
        $dbcols = Schema::getColumnListing('vehicles');//get all columns from DB
        foreach($dbcols as $key=>$val){
            // add bread props
            $cols[$val] = ['column'=>$val,'dbcolumn'=>$val,
                    'caption'=>ucwords(str_replace('_',' ',$val)),
                    'type' => 'text', 
                    'B'=>1,'R'=>1,'E'=>1,'A'=>1,'D'=>1
                ];
            // add joined columns, if any
            if($val == 'vbrand_id'){
                $cols['brand'] = ['column'=>'brand','dbcolumn'=>'vbrands.brand',
                    'caption'=>'Brand',
                    'type' => 'text',
                    'B'=>1,'R'=>1,'E'=>0,'A'=>0,'D'=>1
                ];
            }
            if($val == 'vtype_id'){
                $cols['type'] = ['column'=>'type','dbcolumn'=>'vtypes.type',
                    'caption'=>'Type',
                    'type' => 'text',
                    'B'=>1,'R'=>1,'E'=>0,'A'=>0,'D'=>1
                ];
            }
            if($val == 'vorigin_id'){
                $cols[] = ['column'=>'origin','dbcolumn'=>'vorigins.origin',
                    'caption'=>'Origin',
                    'type' => 'text',
                    'B'=>1,'R'=>1,'E'=>0,'A'=>0,'D'=>1
                ];
            }
        } 
        // modify defaults
        $cols['vbrand_id']['caption'] = 'Brand';
        $cols['vbrand_id']['type'] = 'dropdown';
        $cols['vbrand_id']['dropdown_model'] = 'App\Vbrand';
        $cols['vbrand_id']['dropdown_value'] = 'id';
        $cols['vbrand_id']['dropdown_caption'] = 'brand';
        $cols['vbrand_id']['B'] = 0;
        $cols['vtype_id']['caption'] = 'Type';
        $cols['vtype_id']['type'] = 'dropdown';
        $cols['vtype_id']['dropdown_model'] = 'App\Vtype';
        $cols['vtype_id']['dropdown_value'] = 'id';
        $cols['vtype_id']['dropdown_caption'] = 'type';
        $cols['vtype_id']['B'] = 0;
        $cols['vorigin_id']['caption'] = 'Origin';
        $cols['vorigin_id']['type'] = 'dropdown';
        $cols['vorigin_id']['dropdown_model'] = 'App\Vorigin';
        $cols['vorigin_id']['dropdown_value'] = 'id';
        $cols['vorigin_id']['dropdown_caption'] = 'origin';
        $cols['vorigin_id']['B'] = 0;

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
        return view('vehicle.index',compact('cols'));
    }

    public function indexjson()
    {
        return datatables(Vehicle::select('vehicles.*','brand','type','origin')
        ->leftJoin('vbrands','vbrand_id','vbrands.id')
        ->leftJoin('vtypes','vtype_id','vtypes.id')
        ->leftJoin('vorigins','vorigin_id','vorigins.id')
        )->addColumn('action', function ($dt) {
            return view('vehicle.action',compact('dt'));
        })
        ->toJson();
    }

    public function csvall()
    {
        $export = Vehicle::all();
        $filename = 'nujeks-vehicle.csv';
        $temp = 'temp/'.$filename;
        (new FastExcel($export))->export('temp/nujeks-vehicle.csv');
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
        return view('vehicle.createupdate',compact('cols'));
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
            'no_plate' => 'required|unique:vehicles',
        ]);

        $requestData = $request->all();
        Vehicle::create($requestData);
        Session::flash('message', __('Vehicle').' ditambahkan'); 
        Session::flash('alert-class', 'alert-success'); 
        return redirect('vehicle');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function show(Vehicle $vehicle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function edit(Vehicle $vehicle)
    {
        $cols = $this->cols;        
        $item = Vehicle::find($vehicle->id);
        return view('vehicle.createupdate',compact('cols','item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'no_plate' => 'required|unique:vehicles,no_plate,'.$vehicle->id,
        ]);

        $requestData = $request->all();
        Vehicle::find($vehicle->id)->update($requestData);
        Session::flash('message', __('Vehicle').' diubah'); 
        Session::flash('alert-class', 'alert-success'); 
        return redirect('vehicle');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vehicle $vehicle)
    {
        Vehicle::destroy($vehicle->id);
        Session::flash('message', __('Vehicle').' dihapus'); 
        Session::flash('alert-class', 'alert-success'); 
        return redirect('vehicle');
    }
    
    public function destroymulti(Request $request)
    {
        $ids = htmlentities($request->id);
        Vehicle::whereRaw('id in ('.$ids.')')->delete();
        Session::flash('message', __('Vehicle').' dihapus'); 
        Session::flash('alert-class', 'alert-success'); 
        return redirect('vehicle');
    }
}
