<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $table = 'order';
    public $timestamps = false;
    public $guarded = [];
}
