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

class CustomeritemController extends Controller
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
            if($val == 'weight'){
                $cols['total_weight'] = ['column'=>'total_weight','dbcolumn'=>'total_weight',
                    'caption'=>'T.Weight',
                    'type' => 'text',
                    'B'=>1,'R'=>1,'E'=>0,'A'=>0,'D'=>1
                ];
            }
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
        $cols['volume']['type'] = 'decimal';

        $this->cols = $cols;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($spb_id)
    {
        $customer = session('customer');
        $cols = $this->cols;        
        $spb = Spb::select('spbs.*','customer', 'customers.address as caddress', 'status_code',
        'cities.city as city','provinces.province as province', 'cc.city as ccity',
        'cp.province as cprovince','payment_type','name')
        ->leftJoin('spb_statuses','spb_status_id','spb_statuses.id')
        ->leftJoin('customers','customer_id','customers.id')
        ->leftJoin('cities','spbs.city_id','cities.id')
        ->leftJoin('provinces','spbs.province_id','provinces.id')
        ->leftJoin('cities as cc','customers.city_id','cc.id')
        ->leftJoin('provinces as cp','customers.province_id','cp.id')
        ->leftJoin('spb_payment_types','spbs.spb_payment_type_id','spb_payment_types.id')
        ->leftJoin('users','spbs.created_by','users.id')
        ->where('spbs.id',$spb_id)->where('customer_id',$customer->id)->first();
        return view('customerspb.item',compact('cols','spb'));
    }

    public function indexjson($spb_id)
    {
        // return datatables(Item::selectRaw('items.*, CONCAT_WS(\'x\',length,width,height) as dimension, cast(length*width*height/bale as decimal(10,2))/1000 as volume')
        return datatables(Item::selectRaw('items.*, weight*bale as total_weight, CONCAT_WS(\'x\',length,width,height) as dimension, cast(length*width*height*bale as decimal(10,3))/1000000 as volume')
        ->where('spb_id',$spb_id)
        )->toJson();
    }
}
