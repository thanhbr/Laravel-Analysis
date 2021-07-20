<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'permissions';
    protected $primaryKey = 'PER_ID';
    public $timestamps = false;

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
