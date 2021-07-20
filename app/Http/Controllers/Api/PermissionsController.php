<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\BaseResult;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PermissionsController extends Controller
{
    public function get($id = null) {
        $data = null;
        if ($id) {
            $data = Permission::where(['IsDeleted' => 0, 'PER_ID' => $id])->first();
        } else {
            $data = Permission::where(['IsDeleted' => 0])->get();
        }
        return BaseResult::withData($data);
    }

    public function add(Request $request) {
        //validate the info, create rules for the inputs
        $rules = array(
            'id' => 'numeric',
            'PERNAME' => [
                'required',
                Rule::unique('permissions')->where('IsDeleted', 0)
            ],
        );
        $customMessages = [
            'unique' => 'Tên không được trùng.'
        ];
        // run the validation rules on the inputs from the form
        $validator = Validator::make($request->all(), $rules, $customMessages);
        if ($validator->fails()) {
            return BaseResult::error(400, $validator->messages()->toJson());
        } else {
            $user = Session::get('user');
            $permission = new Permission();
            try {
                $permission->PERNAME = $request->PERNAME;
                $permission->PERNOTE = $request->PERNOTE;
                $permission->IsDeleted = 0;
                $permission->CreatedDate = now();
                $permission->CreatedBy = $user->USE_ID;
                $permission->save();

                return BaseResult::withData($permission);
            } catch (\Exception $e) {
                return BaseResult::error(500, $e->getMessage());
            }
        }
    }

    public function update(Request $request) {
        //validate the info, create rules for the inputs
        $rules = array(
            'id' => 'numeric',
            'PERNAME' => [
                'required',
                Rule::unique('permissions')->where('IsDeleted', 0)
            ],
        );
        $customMessages = [
            'unique' => 'Tên không được trùng.'
        ];
        // run the validation rules on the inputs from the form
        $validator = Validator::make($request->all(), $rules, $customMessages);
        if ($validator->fails()) {
            return BaseResult::error(400, $validator->messages()->toJson());
        } else {
            $user = Session::get('user');
            $permission = Permission::find($request->input('id'));
            if ($permission) {
                try {
                    $permission->PERNAME = $request->PERNAME;
                    $permission->PERNOTE = $request->PERNOTE;
                    $permission->IsDeleted = 0;
                    $permission->CreatedDate = now();
                    $permission->CreatedBy = $user->USE_ID;
                    $permission->save();

                    return BaseResult::withData($permission);
                } catch (\Exception $e) {
                    return BaseResult::error(500, $e->getMessage());
                }
            } else {
                return BaseResult::error(404, 'Data not found!.');
            }
        }
    }

    public function delete($id) {
        $permission = Permission::find($id);
        if ($permission) {
            $user = Session::get('user');

            $permission->IsDeleted = 1;
            $permission->UpdatedDate = now();
            $permission->UpdatedBy = $user->USE_ID;
            $permission->save();
            return BaseResult::withData($permission);
        } else {
            return BaseResult::error(404, 'Data note found!.');
        }
    }
}
