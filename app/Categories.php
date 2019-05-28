<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $table = 'categories';

    protected $hidden = ['updated_at'];

    public function product()
    {
    	return $this->hasMany('App\Product');
    }
}
