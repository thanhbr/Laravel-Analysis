<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\BaseResult;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    public function get($id = null)
    {
        $data = null;
        if ($id) {
            $data = Product::where(['IsDeleted' => 0, 'PRO_ID' => $id])->first();
        } else {
            $data = Product::join('brands', function ($join) {
                $join->on('brands.BRA_ID', '=', 'products.BRA_ID')
                    ->where(['brands.IsDeleted' => 0, 'products.IsDeleted' => 0]);
            })->get();
        }
        return BaseResult::withData($data);
    }

    public function add(Request $request)
    {
        //validate the info, create rules for the inputs
        $rules = array(
            'id' => 'numeric',
            'PRONAME' => 'required',
            'BRA_ID' => 'required',
            'PROIMAGE' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
        );

        $customMessages = [
            'required' => 'Name not found.'
        ];

        // run the validation rules on the inputs from the form
        $validator = Validator::make($request->all(), $rules, $customMessages);
        if ($validator->fails()) {
            return BaseResult::error(400, $validator->messages()->toJson());
        } else {
            $now = Carbon::now();
            $user = Session::get('user');
            $product = new Product();
            try {
                $product->PRONAME = $request->PRONAME;
                $product->BRA_ID = $request->BRA_ID;
                $product->PRODESCRIPTION = $request->PRODESCRIPTION;
                $product->PROSTATUS = $request->PROSTATUS;
                $product->PROMODEL = $request->PROMODEL;
                $product->PROTYPE = $request->PROTYPE;
                $product->PROSIZE = $request->PROSIZE;
                $product->PROWEIGHT = $request->PROWEIGHT;
                $product->IsDeleted = 0;
                $product->CreatedDate = $now;
                $product->CreatedBy = $user->USE_ID;
                $product->save();

                if ($request->hasFile('PROIMAGE')) {
                    $filename = pathinfo($request->PROIMAGE->getClientOriginalName(), PATHINFO_FILENAME);
                    $imageName = $product->PRO_ID . '_' . $filename . '_' . time() . '.' . $request->PROIMAGE->extension();
                    $request->PROIMAGE->move(public_path('data/products'), $imageName);
                    $product->PROIMAGE = $imageName;
                    $product->save();
                }

                return BaseResult::withData($product);
            } catch (\Exception $e) {
                return BaseResult::error(500, $e->getMessage());
            }
        }
    }

    public function update(Request $request)
    {
        //validate the info, create rules for the inputs
        $rules = array(
            'id' => 'numeric',
            'PRONAME' => 'required',
            'BRA_ID' => 'required',
            'PROIMAGE' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
        );

        // run the validation rules on the inputs from the form
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return BaseResult::error(400, $validator->messages()->toJson());
        } else {
            $now = Carbon::now();
            $user = Session::get('user');
            $product = Product::find($request->input('id'));
            if ($product) {
                try {
                    $product->PRONAME = $request->PRONAME;
                    $product->BRA_ID = $request->BRA_ID;
                    $product->PRODESCRIPTION = $request->PRODESCRIPTION;
                    $product->PROSTATUS = $request->PROSTATUS;
                    $product->PROMODEL = $request->PROMODEL;
                    $product->PROTYPE = $request->PROTYPE;
                    $product->PROSIZE = $request->PROSIZE;
                    $product->PROWEIGHT = $request->PROWEIGHT;
                    $product->IsDeleted = 0;
                    $product->CreatedDate = $now;
                    $product->CreatedBy = $user->USE_ID;
                    $product->save();

                    if ($request->hasFile('PROIMAGE')) {
                        // delete old file
                        $oldFile = $product->PROIMAGE;
                        if (File::exists(public_path('data/products/' . $oldFile))) {
                            File::delete(public_path('data/products/' . $oldFile));
                        }

                        $filename = pathinfo($request->PROIMAGE->getClientOriginalName(), PATHINFO_FILENAME);
                        $imageName = $product->PRO_ID . '_' . $filename . '_' . time() . '.' . $request->PROIMAGE->extension();
                        $request->PROIMAGE->move(public_path('data/products'), $imageName);
                        $product->PROIMAGE = $imageName;
                        $product->save();
                    }

                    return BaseResult::withData($product);
                } catch (\Exception $e) {
                    return BaseResult::error(500, $e->getMessage());
                }
            }else {
                return BaseResult::error(404, 'Data not found!.');
            }
        }
    }

    public function delete($id) {
        $user = Session::get('user');
        $product = Product::find($id);
        if ($product) {
            $product->IsDeleted = 1;
            $product->UpdatedDate = now();
            $product->CreatedBy = $user->USE_ID;
            $product->save();
            return BaseResult::withData($product);
        } else {
            return BaseResult::error(404, 'Data not found!.');
        }
    }
}
