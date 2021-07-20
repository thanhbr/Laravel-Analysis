<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'permission_roles';
    protected $primaryKey = 'PERO_ID';
    public $timestamps = false;

    public function permission()
    {
        return $this->belongsTo(Permission::class, 'PER_ID');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'ROLE_ID');
    }
}
