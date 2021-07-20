<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\BaseResult;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BrandsController extends Controller
{
    public function get($id = null) {
        $data = null;
        if ($id) {
            $data = Brand::where(['IsDeleted' => 0, 'BRA_ID' => $id])->first();
        } else {
            $data = Brand::where(['IsDeleted' => 0])->get();
        }
        return BaseResult::withData($data);
    }

    public function add(Request $request) {
        //validate the info, create rules for the inputs
        $rules = array(
            'id' => 'numeric',
            'BRANAME' => 'required',
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
            $brand = new Brand();
            try {
                $brand->BRANAME = $request->BRANAME;
                $brand->BRAADDRESS = $request->BRAADDRESS;
                $brand->BRAEMAIL = $request->BRAEMAIL;
                $brand->BRAPHONE = $request->BRAPHONE;
                $brand->IsDeleted = 0;
                $brand->CreatedDate = now();
                $brand->CreatedBy = $user->USE_ID;
                $brand->save();

                return BaseResult::withData($brand);
            } catch (\Exception $e) {
                return BaseResult::error(500, $e->getMessage());
            }
        }
    }

    public function update(Request $request) {
        //validate the info, create rules for the inputs
        $rules = array(
            'id' => 'numeric',
            'BRANAME' => 'required',
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
            $brand = Brand::find($request->input('id'));
            if ($brand) {
                try {
                    $brand->BRANAME = $request->BRANAME;
                    $brand->BRAADDRESS = $request->BRAADDRESS;
                    $brand->BRAEMAIL = $request->BRAEMAIL;
                    $brand->BRAPHONE = $request->BRAPHONE;
                    $brand->IsDeleted = 0;
                    $brand->CreatedDate = now();
                    $brand->CreatedBy = $user->USE_ID;
                    $brand->save();

                    return BaseResult::withData($brand);
                } catch (\Exception $e) {
                    return BaseResult::error(500, $e->getMessage());
                }
            } else {
                return BaseResult::error(404, 'Data not found!.');
            }
        }
    }

    public function delete($id) {
        $brand = Brand::find($id);
        if ($brand) {
            $user = Session::get('user');

            $brand->IsDeleted = 1;
            $brand->UpdatedDate = now();
            $brand->UpdatedBy = $user->USE_ID;
            $brand->save();
            return BaseResult::withData($brand);
        } else {
            return BaseResult::error(404, 'Data not found!.');
        }
    }
}
