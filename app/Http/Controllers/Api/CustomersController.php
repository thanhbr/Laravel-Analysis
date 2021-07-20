<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\BaseResult;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CustomersController extends Controller
{
    public function get($id = null) {
        $data = null;
        if ($id) {
            $data = Customer::where(['IsDeleted' => 0, 'CUS_ID' => $id])->first();
        } else {
            $data = Customer::where(['IsDeleted' => 0])->get();
        }
        return BaseResult::withData($data);
    }

    public function add(Request $request) {
        //validate the info, create rules for the inputs
        $rules = array(
            'id' => 'numeric',
            'CUSNAME' => 'required',
        );
        // run the validation rules on the inputs from the form
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return BaseResult::error(400, $validator->messages()->toJson());
        } else {
            $user = Session::get('user');
            $customer = new Customer();
            try {
                $customer->CUSNAME = $request->CUSNAME;
                $customer->CUSPHONE = $request->CUSPHONE;
                $customer->CUSADDRESS = $request->CUSADDRESS;
                $customer->CUSEMAIL = $request->CUSEMAIL;
                $customer->CUSUSERNAME = $request->CUSUSERNAME;
                $customer->CUSPASSWORD = bcrypt($request->CUSPASSWORD);
                $customer->CUSTYPE = $request->CUSTYPE;
                $customer->IsDeleted = 0;
                $customer->CreatedDate = now();
                $customer->CreatedBy = $user->USE_ID;
                $customer->save();

                return BaseResult::withData($customer);
            } catch (\Exception $e) {
                return BaseResult::error(500, $e->getMessage());
            }
        }
    }

    public function update(Request $request) {
        //validate the info, create rules for the inputs
        $rules = array(
            'id' => 'numeric',
            'CUSNAME' => 'required',
        );
        // run the validation rules on the inputs from the form
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return BaseResult::error(400, $validator->messages()->toJson());
        } else {
            $user = Session::get('user');
            $customer = Customer::find($request->input('id'));
            if ($customer) {
                try {
                    $customer->CUSNAME = $request->CUSNAME;
                    $customer->CUSPHONE = $request->CUSPHONE;
                    $customer->CUSADDRESS = $request->CUSADDRESS;
                    $customer->CUSEMAIL = $request->CUSEMAIL;
                    $customer->CUSUSERNAME = $request->CUSUSERNAME;
                    $customer->CUSPASSWORD = bcrypt($request->CUSPASSWORD);
                    $customer->CUSTYPE = $request->CUSTYPE;
                    $customer->IsDeleted = 0;
                    $customer->CreatedDate = now();
                    $customer->CreatedBy = $user->USE_ID;
                    $customer->save();

                    return BaseResult::withData($customer);
                } catch (\Exception $e) {
                    return BaseResult::error(500, $e->getMessage());
                }
            } else {
                return BaseResult::error(404, 'Data not found!.');
            }
        }
    }

    public function delete($id) {
        $customer = Customer::find($id);
        if ($customer) {
            $user = Session::get('user');

            $customer->IsDeleted = 1;
            $customer->UpdatedDate = now();
            $customer->UpdatedBy = $user->USE_ID;
            $customer->save();
            return BaseResult::withData($customer);
        } else {
            return BaseResult::error(404, 'Data note found!.');
        }
    }
}
