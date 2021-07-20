<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\BaseResult;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    public function get($id = null) {
        $data = null;
        if ($id) {
            $data = User::where(['IsDeleted' => 0, 'USE_ID' => $id])->first();
        } else {
            $data = User::join('roles', function ($join) {
                $join->on('roles.ROLE_ID', '=', 'users.ROLE_ID')
                    ->where(['roles.IsDeleted' => 0, 'users.IsDeleted' => 0]);
            })->get();
        }
        return BaseResult::withData($data);
    }

    public function add(Request $request) {
        //validate the info, create rules for the inputs
        $rules = array(
            'id' => 'numeric',
            'username' => 'required',
            'fullname' => 'required',
            'email' => 'required'
        );
        // run the validation rules on the inputs from the form
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return BaseResult::error(400, $validator->messages()->toJson());
        } else {
            $user = Session::get('user');
            $admin = new User();
            try {
                $admin->username = $request->username;
                $admin->password = $request->password;
                $admin->fullname = $request->fullname;
                $admin->email = $request->email;
                $admin->ROLE_ID = $request->ROLE_ID;
                $admin->IsDeleted = 0;
                $admin->CreatedDate = now();
                $admin->CreatedBy = $user->USE_ID;
                $admin->save();

                return BaseResult::withData($admin);
            } catch (\Exception $e) {
                return BaseResult::error(500, $e->getMessage());
            }
        }
    }
    public function update(Request $request) {
        //validate the info, create rules for the inputs
        $rules = array(
            'id' => 'numeric',
            'username' => [
                'required',
                Rule::unique('users')->where('username', $request->get('username')),
            ],
            'fullname' => 'required',
            'email' => [
                'required',
                Rule::unique('users')->where('email', $request->get('email')),
            ],
        );
        // run the validation rules on the inputs from the form
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return BaseResult::error(400, $validator->messages()->toJson());
        } else {
            $user = Session::get('user');
            $admin = User::find($request->input('id'));
            if ($admin) {
                try {
                    $admin->username = $request->username;
                    $admin->password = $request->password;
                    $admin->fullname = $request->fullname;
                    $admin->email = $request->email;
                    $admin->ROLE_ID = $request->ROLE_ID;
                    $admin->IsDeleted = 0;
                    $admin->CreatedDate = now();
                    $admin->CreatedBy = $user->USE_ID;
                    $admin->save();

                    return BaseResult::withData($admin);
                } catch (\Exception $e) {
                    return BaseResult::error(500, $e->getMessage());
                }
            } else {
                return BaseResult::error(404, 'Data not found!.');
            }
        }
    }
    public function delete($id) {
        $admin = User::find($id);
        if ($admin) {
            $user = Session::get('user');

            $admin->IsDeleted = 1;
            $admin->UpdatedDate = now();
            $admin->UpdatedBy = $user->USE_ID;
            $admin->save();
            return BaseResult::withData($admin);
        } else {
            return BaseResult::error(404, 'Data not found!.');
        }
    }
}
