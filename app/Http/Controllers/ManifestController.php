<?php

namespace App\Http\Controllers;

use App\Manifest;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;
use Auth;
use Schema;
use Session;
use Validator;

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
            if($val == 'origin_id'){
                $cols['origin'] = ['column'=>'origin','dbcolumn'=>'ori.province',
                    'caption'=>'Origin',
                    'type' => 'text',
                    'B'=>1,'R'=>1,'E'=>0,'A'=>0,'D'=>1
                ];
            }
            if($val == 'destination_id'){
                $cols['destination'] = ['column'=>'destination','dbcolumn'=>'des.province',
                    'caption'=>'Destination',
                    'type' => 'text',
                    'B'=>1,'R'=>1,'E'=>0,'A'=>0,'D'=>1
                ];
            }
        } 
        // modify defaults
        $cols['origin_id']['caption'] = 'Origin';
        $cols['origin_id']['type'] = 'dropdown';
        $cols['origin_id']['dropdown_model'] = 'App\Province';
        $cols['origin_id']['dropdown_value'] = 'id';
        $cols['origin_id']['dropdown_caption'] = 'province';
        $cols['origin_id']['B'] = 0;
        $cols['destination_id']['caption'] = 'Destination';
        $cols['destination_id']['type'] = 'dropdown';
        $cols['destination_id']['dropdown_model'] = 'App\Province';
        $cols['destination_id']['dropdown_value'] = 'id';
        $cols['destination_id']['dropdown_caption'] = 'province';
        $cols['destination_id']['B'] = 0;
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
        return view('manifest.index',compact('cols'));
    }

    public function indexjson()
    {
        return datatables(Manifest::select('manifests.*','ori.province as origin','des.province as destination')
        ->leftJoin('provinces as ori','origin_id','ori.id')
        ->leftJoin('provinces as des','destination_id','des.id')
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
        $cols = $this->cols;        
        return view('manifest.createupdate',compact('cols'));
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
}
