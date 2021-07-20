<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments';
    protected $primaryKey = 'COM_ID';
    public $timestamps = false;

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'CUS_ID');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'PRO_ID');
    }
}
