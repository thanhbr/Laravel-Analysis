<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\BaseResult;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RolesController extends Controller
{
    public function get($id = null) {
        $data = null;
        if ($id) {
            $data = Role::where(['IsDeleted' => 0, 'ROLE_ID' => $id])->first();
        } else {
            $data = Role::where(['IsDeleted' => 0])->with('permissions')->get();
        }
        return BaseResult::withData($data);
    }
    public function find(Request $request)
    {
        $term = trim($request->q);

        $permissions = Permission::search($term)->limit(5)->get();

        $formatted_tags = [];

        foreach ($permissions as $permission) {
            $formatted_tags[] = ['id' => $permission->PER_ID, 'text' => $permission->PERNAME];
        }

        return BaseResult::withData($formatted_tags);
    }
    public function add(Request $request) {
        //validate the info, create rules for the inputs
        $rules = array(
            'id' => 'numeric',
            'ROLENAME' => [
                'required',
                Rule::unique('roles')
                    ->where('IsDeleted', 0)
            ],
//            'ROLENOTE' => [
//                'required',
//                Rule::unique('roles', 'ROLENOTE')
//                    ->where('ROLENAME', $request->get('ROLENAME'))
//                    ->where('ROLEDESC', $request->get('ROLEDESC'))
//                    ->where('IsDeleted', 0)
//            ],
//            'ROLEDESC' => [
//                Rule::unique('roles', 'ROLEDESC')
//                    ->where('ROLENAME', $request->get('ROLENAME'))
//                    ->where('ROLENOTE', $request->get('ROLENOTE'))
//                    ->where('IsDeleted', 0)
//            ],
        );
        // run the validation rules on the inputs from the form
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return BaseResult::error(400, $validator->messages()->toJson());
        } else {
            $user = Session::get('user');
            $role = new Role();
            try {
                $role->ROLENAME = $request->ROLENAME;
                $role->ROLENOTE = $request->ROLENOTE;
                $role->IsDeleted = 0;
                $role->CreatedDate = now();
                $role->CreatedBy = $user->USE_ID;
                $role->save();

                $role->permissions()->attach($request->permissions);

                return BaseResult::withData($role);
            } catch (\Exception $e) {
                return BaseResult::error(500, $e->getMessage());
            }
        }
    }
    public function update(Request $request) {
        //validate the info, create rules for the inputs
        $rules = array(
            'id' => 'numeric',
            'ROLENAME' => [
                'required',
                Rule::unique('roles')->where('IsDeleted', 0)
            ],
        );
        // run the validation rules on the inputs from the form
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return BaseResult::error(400, $validator->messages()->toJson());
        } else {
            $user = Session::get('user');
            $role = Role::find($request->input('id'));
            if ($role) {
                try {
                    $role->ROLENAME = $request->ROLENAME;
                    $role->ROLENOTE = $request->ROLENOTE;
                    $role->IsDeleted = 0;
                    $role->CreatedDate = now();
                    $role->CreatedBy = $user->USE_ID;
                    $role->save();

                    $role->permissions()->detach();
                    $role->permissions()->attach($request->permissions);

                    return BaseResult::withData($role);
                } catch (\Exception $e) {
                    return BaseResult::error(500, $e->getMessage());
                }
            } else {
                return BaseResult::error(404, 'Data not found!.');
            }
        }
    }
    public function delete($id) {
        $role = Role::find($id);
        if ($role) {
            $user = Session::get('user');

            $role->IsDeleted = 1;
            $role->UpdatedDate = now();
            $role->UpdatedBy = $user->USE_ID;
            $role->save();
            return BaseResult::withData($role);
        } else {
            return BaseResult::error(404, 'Data not found!.');
        }
    }
}
