<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $primaryKey = 'PRO_ID';
    public $timestamps = false;

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'BRA_ID');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
