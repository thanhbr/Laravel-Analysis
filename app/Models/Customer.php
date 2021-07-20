<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'customers';
    protected $primaryKey = 'CUS_ID';
    public $timestamps = false;

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
