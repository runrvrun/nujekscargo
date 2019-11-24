<?php

namespace App\Http\Controllers;

use App\Item;
use App\Spb;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;
use Carbon\Carbon;
use Schema;
use Session;
use Validator;

class ItemController extends Controller
{
    private $cols;

    public function __construct()
    {
        // setup cols
        $dbcols = Schema::getColumnListing('items');//get all columns from DB
        foreach($dbcols as $key=>$val){
            // add bread props
            $cols[$val] = ['column'=>$val,'dbcolumn'=>$val,
                    'caption'=>ucwords(str_replace('_',' ',$val)),
                    'type' => 'text', 
                    'B'=>1,'R'=>1,'E'=>1,'A'=>1,'D'=>1
                ];
            // add joined columns, if any
            if($val == 'height'){
                $cols['dimension'] = ['column'=>'dimension','dbcolumn'=>'dimension',
                    'caption'=>'Dimension',
                    'type' => 'text',
                    'B'=>1,'R'=>1,'E'=>0,'A'=>0,'D'=>1
                ];
                $cols['volume'] = ['column'=>'volume','dbcolumn'=>'volume',
                    'caption'=>'Volume',
                    'type' => 'number',
                    'B'=>1,'R'=>1,'E'=>0,'A'=>0,'D'=>1
                ];
            }
        } 
        // modify defaults
        $cols['length']['B'] = 0;
        $cols['width']['B'] = 0;
        $cols['height']['B'] = 0;
        $cols['id']['E'] = 0;
        $cols['id']['A'] = 0;
        $cols['spb_id']['B'] = 0;
        $cols['spb_id']['E'] = 0;
        $cols['spb_id']['A'] = 0;
        $cols['created_at']['E'] = 0;
        $cols['created_at']['A'] = 0;
        $cols['updated_at']['E'] = 0;
        $cols['updated_at']['A'] = 0;
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
        $cols['bale']['type'] = 'number';
        $cols['weight']['type'] = 'number';
        $cols['length']['type'] = 'number';
        $cols['width']['type'] = 'number';
        $cols['height']['type'] = 'number';

        $this->cols = $cols;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($spb_id)
    {
        $cols = $this->cols;        
        $spb = Spb::select('spbs.*','customer')
        ->leftJoin('customers','customer_id','customers.id')
        ->where('spbs.id',$spb_id)->first();
        return view('item.index',compact('cols','spb'));
    }

    public function indexjson($spb_id)
    {
        // return datatables(Item::selectRaw('items.*, CONCAT_WS(\'x\',length,width,height) as dimension, cast(length*width*height/bale as decimal(10,2))/1000 as volume')
        return datatables(Item::selectRaw('items.*, CONCAT_WS(\'x\',length,width,height) as dimension, cast(length*width*height/bale as decimal(10,2))/1000 as volume')
        ->where('spb_id',$spb_id)
        )->addColumn('action', function ($dt) {
            return view('item.action',compact('dt'));
        })
        ->toJson();
    }

    public function csvall($spb_id)
    {
        $export = Item::all();
        $filename = 'nujeks-item.csv';
        $temp = 'temp/'.$filename;
        (new FastExcel($export))->export('temp/nujeks-item.csv');
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
    public function create($spb_id)
    {
        $spb = Spb::find($spb_id);
        $cols = $this->cols;        
        return view('item.createupdate',compact('cols','spb'));
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
            'item' => 'required',
        ]);

        $requestData = $request->all();
        unset($requestData['saveadd']);
        Item::create($requestData);
        Session::flash('message', __('Item').' ditambahkan'); 
        Session::flash('alert-class', 'alert-success'); 
        if(isset($request->saveadd)){
            return redirect('spb/'.$request->spb_id.'/item/create');
        }else{
            return redirect('spb/'.$request->spb_id.'/item');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item,$spb_id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        $cols = $this->cols;        
        $item = Item::find($item->id);
        $spb = Spb::find($item->spb_id);
        return view('item.createupdate',compact('cols','item','spb'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        $request->validate([
            'item' => 'required',
        ]);

        $requestData = $request->all();
        Item::find($item->id)->update($requestData);
        Session::flash('message', __('Item').' diubah'); 
        Session::flash('alert-class', 'alert-success'); 
        return redirect('spb/'.$request->spb_id.'/item');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $spb_id = $item->spb_id;
        Item::destroy($item->id);
        Session::flash('message', __('Item').' dihapus'); 
        Session::flash('alert-class', 'alert-success'); 
        return redirect('spb/'.$spb_id.'/item');
    }
    
    public function destroymulti(Request $request, $spb_id)
    {
        $ids = htmlentities($request->id);
        Item::whereRaw('id in ('.$ids.')')->delete();
        Session::flash('message', __('Item').' dihapus'); 
        Session::flash('alert-class', 'alert-success'); 
        return redirect('spb/'.$spb_id.'/item');
    }
}
