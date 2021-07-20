<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\BaseResult;
use App\Models\PermissionRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PermissionRolesController extends Controller
{
    public function get($id = null) {
        $data = null;
        if ($id) {
            $data = PermissionRole::where(['IsDeleted' => 0, 'PERO_ID' => $id])->first();
        } else {
            $data = PermissionRole::join('roles', function ($join) {
                $join->on('roles.ROLE_ID', '=', 'permission_roles.ROLE_ID')
                    ->where(['roles.IsDeleted' => 0, 'permission_roles.IsDeleted' => 0]);
            })->join('permissions', function ($join) {
                $join->on('permissions.PER_ID', '=', 'permission_roles.PER_ID')
                    ->where(['permissions.IsDeleted' => 0, 'permission_roles.IsDeleted' => 0]);
            })->get();
        }
        return BaseResult::withData($data);
    }

    public function add(Request $request) {
        //validate the info, create rules for the inputs
        $rules = array(
            'id' => 'numeric',
            'ROLE_ID' => 'required',
            'PER_ID' => 'required',
        );
        // run the validation rules on the inputs from the form
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return BaseResult::error(400, $validator->messages()->toJson());
        } else {
            $user = Session::get('user');
            $pero = new PermissionRole();
            try {
                $pero->PER_ID = $request->PER_ID;
                $pero->ROLE_ID = $request->ROLE_ID;
                $pero->IsDeleted = 0;
                $pero->CreatedDate = now();
                $pero->CreatedBy = $user->USE_ID;
                $pero->save();

                return BaseResult::withData($pero);
            } catch (\Exception $e) {
                return BaseResult::error(500, $e->getMessage());
            }
        }
    }
    public function update(Request $request) {
        //validate the info, create rules for the inputs
        $rules = array(
            'id' => 'numeric',
            'ROLE_ID' => 'required',
            'PER_ID' => 'required',
        );
        // run the validation rules on the inputs from the form
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return BaseResult::error(400, $validator->messages()->toJson());
        } else {
            $user = Session::get('user');
            $pero = PermissionRole::find($request->input('id'));
            if ($pero) {
                try {
                    $pero->PER_ID = $request->PER_ID;
                    $pero->ROLE_ID = $request->ROLE_ID;
                    $pero->IsDeleted = 0;
                    $pero->CreatedDate = now();
                    $pero->CreatedBy = $user->USE_ID;
                    $pero->save();

                    return BaseResult::withData($pero);
                } catch (\Exception $e) {
                    return BaseResult::error(500, $e->getMessage());
                }
            } else {
                return BaseResult::error(404, 'Data not found!.');
            }
        }
    }
    public function delete($id) {
        $pero = PermissionRole::find($id);
        if ($pero) {
            $user = Session::get('user');

            $pero->IsDeleted = 1;
            $pero->UpdatedDate = now();
            $pero->UpdatedBy = $user->USE_ID;
            $pero->save();
            return BaseResult::withData($pero);
        } else {
            return BaseResult::error(404, 'Không tìm thấy dữ liệu!.');
        }
    }
}
