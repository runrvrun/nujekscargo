<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Spb extends Model
{
    protected $guarded = ['id'];

    public function items()
    {
        return $this->hasMany('App\Item');
    }
}
