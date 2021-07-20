<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $role = Role::all();
        $names = $role->where('IsDeleted', 0)->sortBy('ROLENAME')->pluck('ROLENAME')->unique();
        return view('admin.role', compact('names'));
    }
}
