<?php

namespace App\Exports;

use App\Manifest;
use App\Spb;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ManifestsExport implements FromView
{
    public function __construct(int $manifest_id)
    {
        $this->manifest_id = $manifest_id;
    }

    public function view(): View
    {
        // return Manifest::query();
        $manifest = Manifest::select('no_manifest','title','manifests.created_at','name')->where('manifests.id',$this->manifest_id)->leftJoin('users','manifests.created_by','users.id')->first();
        $spb = Spb::with('items')->select('spbs.id','no_spb','customer','customers.address','spbs.address as spbaddress','recipient')
        ->leftJoin('customers','customer_id','customers.id')
        ->leftJoin('manifest_spbs','manifest_spbs.spb_id','spbs.id')
        ->where('manifest_id',$this->manifest_id)
        ->get();
        return view('manifest.export', [
            'manifest' => $manifest,
            'spb' => $spb,
        ]);
    }
}
