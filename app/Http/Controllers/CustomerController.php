<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;
use Schema;
use Session;
use Validator;

class CustomerController extends Controller
{
    private $cols;

    public function __construct()
    {
        //setup cols
        $dbcols = Schema::getColumnListing('customers');;//get all columns from DB
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
            if($val == 'branch_id'){
                $cols['branch'] = ['column'=>'branch','dbcolumn'=>'branches.branch',
                'caption'=>'Branch',
                'type' => 'text',
                'B'=>1,'R'=>1,'E'=>0,'A'=>0,'D'=>1
                ];
            }
            if($val == 'marketinguser_id'){
                $cols['name'] = ['column'=>'name','dbcolumn'=>'users.name',
                'caption'=>'Marketing',
                'type' => 'text',
                'B'=>1,'R'=>1,'E'=>0,'A'=>0,'D'=>1
                ];
            }
        } 
        // modify defaults
        $cols['address']['type'] = 'textarea';
        $cols['phone']['type'] = 'number';
        $cols['pic_phone']['type'] = 'number';
        $cols['fax']['type'] = 'number';
        $cols['email']['type'] = 'email';
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
        $cols['branch_id']['caption'] = 'Branch';
        $cols['branch_id']['type'] = 'dropdown';
        $cols['branch_id']['dropdown_model'] = 'App\Branch';
        $cols['branch_id']['dropdown_value'] = 'id';
        $cols['branch_id']['dropdown_caption'] = 'branch';
        $cols['branch_id']['B'] = 0;
        $cols['marketinguser_id']['caption'] = 'Marketing';
        $cols['marketinguser_id']['type'] = 'dropdown';
        $cols['marketinguser_id']['dropdown_model'] = 'App\User';
        $cols['marketinguser_id']['dropdown_value'] = 'id';
        $cols['marketinguser_id']['dropdown_caption'] = 'name';
        $cols['marketinguser_id']['B'] = 0;

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
        return view('customer.index',compact('cols'));
    }

    public function indexjson()
    {
        return datatables(Customer::select('customers.*','province','city','name','branch')
        ->leftJoin('provinces','province_id','provinces.id')
        ->leftJoin('cities','city_id','cities.id')
        ->leftJoin('users','marketinguser_id','users.id')
        ->leftJoin('branches','customers.branch_id','branches.id')
        )->addColumn('action', function ($dt) {
            return view('customer.action',compact('dt'));
        })
        ->toJson();
    }

    public function csvall()
    {
        $export = Customer::all();
        $filename = 'nujeks-customer.csv';
        $temp = 'temp/'.$filename;
        (new FastExcel($export))->export('temp/nujeks-customer.csv');
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
        return view('customer.createupdate',compact('cols'));
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
            'customer' => array('required','regex:(^[a-zA-Z0-9\(\)\s]*$)','unique:customers'),
        ]);

        $requestData = $request->all();
        $requestData['customer'] = strtoupper($requestData['customer']);
        Customer::create($requestData);
        Session::flash('message', 'Kantor Cabang ditambahkan'); 
        Session::flash('alert-class', 'alert-success'); 
        return redirect('customer');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        $cols = $this->cols;        
        $item = customer::find($customer->id);
        return view('customer.createupdate',compact('cols','item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'customer' => array('required','regex:(^[a-zA-Z0-9\(\)\s]*$)','unique:customers,customer,'.$customer->id),
        ],[
            'customer.regex' => 'Format nama pelanggan tidak valid. Hanya huruf, angka, dan tanda kurung yang diperbolehkan (tulis PT tanpa tanda titik).',
        ]);

        $requestData = $request->all();
        $requestData['customer'] = strtoupper($requestData['customer']);
        Customer::find($customer->id)->update($requestData);
        Session::flash('message', 'Kantor Cabang diubah'); 
        Session::flash('alert-class', 'alert-success'); 
        return redirect('customer');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        Customer::destroy($customer->id);
        Session::flash('message', 'Kantor Cabang dihapus'); 
        Session::flash('alert-class', 'alert-success'); 
        return redirect('customer');
    }
    
    public function destroymulti(Request $request)
    {
        $ids = htmlentities($request->id);
        Customer::whereRaw('id in ('.$ids.')')->delete();
        Session::flash('message', 'Kantor Cabang dihapus'); 
        Session::flash('alert-class', 'alert-success'); 
        return redirect('customer');
    }
}
