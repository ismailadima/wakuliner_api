<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';

    protected $hidden = ['updated_at'];

    public function categories()
    {
    	return $this->belongsTo('App\Categories');
    }
}
