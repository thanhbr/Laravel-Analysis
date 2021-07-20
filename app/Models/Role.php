<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'roles';
    protected $primaryKey = 'ROLE_ID';
    public $timestamps = false;

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_roles', 'ROLE_ID', 'PER_ID');
    }

    public function permissionRoles()
    {
        return $this->hasMany(PermissionRole::class);
    }
}
