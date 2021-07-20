<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\BaseResult;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class InventoriesController extends Controller
{
    public function get($id = null) {
        $data = null;
        if ($id) {
            $data = Inventory::where(['IsDeleted' => 0, 'INV_ID' => $id])->first();
        } else {
            $data = Inventory::where(['IsDeleted' => 0])->get();
        }
        return BaseResult::withData($data);
    }

    public function add(Request $request) {
        //validate the info, create rules for the inputs
        $rules = array(
            'id' => 'numeric',
            'INVNAME' => 'required',
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
            $inventory = new Inventory();
            try {
                $inventory->INVID = $request->INVID;
                $inventory->INVNAME = $request->INVNAME;
                $inventory->IsDeleted = 0;
                $inventory->CreatedDate = now();
                $inventory->CreatedBy = $user->USE_ID;
                $inventory->save();

                return BaseResult::withData($inventory);
            } catch (\Exception $e) {
                return BaseResult::error(500, $e->getMessage());
            }
        }
    }

    public function update(Request $request) {
        //validate the info, create rules for the inputs
        $rules = array(
            'id' => 'numeric',
            'INVNAME' => 'required',
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
            $inventory = Inventory::find($request->input('id'));
            if ($inventory) {
                try {
                    $inventory->INVID = $request->INVID;
                    $inventory->INVNAME = $request->INVNAME;
                    $inventory->IsDeleted = 0;
                    $inventory->CreatedDate = now();
                    $inventory->CreatedBy = $user->USE_ID;
                    $inventory->save();

                    return BaseResult::withData($inventory);
                } catch (\Exception $e) {
                    return BaseResult::error(500, $e->getMessage());
                }
            } else {
                return BaseResult::error(404, 'Data not found!.');
            }
        }
    }

    public function delete($id) {
        $inventory = Inventory::find($id);
        if ($inventory) {
            $user = Session::get('user');

            $inventory->IsDeleted = 1;
            $inventory->UpdatedDate = now();
            $inventory->UpdatedBy = $user->USE_ID;
            $inventory->save();
            return BaseResult::withData($inventory);
        } else {
            return BaseResult::error(404, 'Data not found!.');
        }
    }
}
