<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $table = 'banners';
    protected $primaryKey = 'BAN_ID';
    public $timestamps = false;
}
