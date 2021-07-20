<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\BaseResult;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class BannersController extends Controller
{
    public function get($id = null) {
        $data = null;
        if ($id) {
            $data = Banner::where(['IsDeleted' => 0, 'BAN_ID' => $id])->first();
        } else {
            $data = Banner::where(['IsDeleted' => 0])->get();
        }
        return BaseResult::withData($data);
    }
    public function add(Request $request) {
        //validate the info, create rules for the inputs
        $rules = array(
            'id' => 'numeric',
            'Title' => 'required',
            'DisplayOrder' => 'required|numeric|min:1',
            'Image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        );
        // run the validation rules on the inputs from the form
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return BaseResult::error(400, $validator->messages()->toJson());
        } else {
            $user = Session::get('user');
            $banner = new Banner;
            try {
                $banner->Title = $request->Title;
                $banner->DisplayOrder = $request->DisplayOrder;  
                $banner->IsPublished = $request->has('IsPublished') ? true : false; 
                $banner->IsDeleted = 0;
                $banner->CreatedDate = now();
                $banner->CreatedBy = $user->USE_ID;
                $banner->save();

                if ($request->hasFile('Image')) {
                    $filename = pathinfo($request->Image->getClientOriginalName(), PATHINFO_FILENAME);
                    $imageName = $banner->BAN_ID . '_' . $filename . '_' . time() . '.' . $request->Image->extension();
                    $request->Image->move(public_path('data/banners'), $imageName);
                    $banner->Banner = $imageName;
                    $banner->save();
                }

                return BaseResult::withData($banner);
            } catch (\Exception $e) {
                return BaseResult::error(500, $e->getMessage());
            }
        }
    }
    public function update(Request $request) {
        //validate the info, create rules for the inputs
        $rules = array(
            'id' => 'numeric',
            'Title' => 'required',
            'DisplayOrder' => 'required|numeric|min:1',
            'Image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        );
        // run the validation rules on the inputs from the form
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return BaseResult::error(400, $validator->messages()->toJson());
        } else {
            $user = Session::get('user');
            $banner = Banner::find($request->input('id'));
            if ($banner) {
                try {
                    $banner->Title = $request->Title;
                    $banner->DisplayOrder = $request->DisplayOrder;                
                    $banner->IsDeleted = 0;
                    $banner->UpdatedDate = now();
                    $banner->UpdatedBy = $user->USE_ID;

                    $banner->save();

                    if ($request->hasFile('Image')) {
                        
                        // delete old file
                        $oldFile = $banner->Banner;
                        if (File::exists(public_path('data/banners/' . $oldFile))) {
                            File::delete(public_path('data/banners/' . $oldFile));
                        }

                        $filename = pathinfo($request->Image->getClientOriginalName(), PATHINFO_FILENAME);
                        $imageName = $banner->BAN_ID . '_' . $filename . '_' . time() . '.' . $request->Image->extension();
                        $request->Image->move(public_path('data/banners'), $imageName);
                        $banner->Banner = $imageName;
                        $banner->save();
                    }

                    return BaseResult::withData($banner);
                } catch (\Exception $e) {
                    return BaseResult::error(500, $e->getMessage());
                }
            } else {
                return BaseResult::error(404, 'Data not found!.');
            }
        }
    }
    public function delete($id) {
        $banner = Banner::find($id);
        if ($banner) {
            $user = Session::get('user');

            $banner->IsDeleted = 1;
            $banner->UpdatedDate = now();
            $banner->UpdatedBy = $user->USE_ID;
            $banner->save();
            return BaseResult::withData($banner);
        } else {
            return BaseResult::error(404, 'Không tìm thấy dữ liệu!.');
        }
    }
}
