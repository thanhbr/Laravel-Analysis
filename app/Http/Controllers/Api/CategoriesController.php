<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\BaseResult;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    public function get($id = null) {
        $data = null;
        if ($id) {
            $data = Category::where(['IsDeleted' => 0, 'CAT_ID' => $id])->first();
        } else {
            $data = collect();
            $rows = Category::where('IsDeleted', 0)
                ->where(function ($query) {
                    $query->whereNull('PARENT_ID')->orWhere('PARENT_ID', 0);
                })
                ->orderBy('DisplayOrder', 'asc')
                ->orderBy('Name', 'asc')
                ->get();
            foreach ($rows as $value) {
                $data->push($value);
                $level1 = Category::where(['IsDeleted' => 0, 'PARENT_ID' => $value->CAT_ID])
                    ->orderBy('DisplayOrder', 'asc')
                    ->orderBy('Name', 'asc')->get();
                foreach ($level1 as $rowLevel1) {
                    $data->push($rowLevel1);
                    $level2 = Category::where(['IsDeleted' => 0, 'PARENT_ID' => $rowLevel1->CAT_ID])
                        ->orderBy('DisplayOrder', 'asc')
                        ->orderBy('Name', 'asc')->get();
                    foreach ($level2 as $rowLevel2) {
                        $data->push($rowLevel2);
                    }
                }
            }
        }
        return BaseResult::withData($data);
    }
    public function getParentList()
    {
        $categories = collect();
        $rows = Category::where('IsDeleted', 0)
            ->where(function ($query) {
                $query->whereNull('PARENT_ID')->orWhere('PARENT_ID', 0);
            })
            ->orderBy('DisplayOrder', 'asc')
            ->orderBy('Name', 'asc')
            ->get();
        foreach ($rows as $value) {
            $categories->push($value);
            $level1 = Category::where(['IsDeleted' => 0, 'PARENT_ID' => $value->CAT_ID])
                ->orderBy('DisplayOrder', 'asc')
                ->orderBy('Name', 'asc')->get();
            foreach ($level1 as $rowLevel1) {
                $categories->push($rowLevel1);
            }
        }
        return BaseResult::withData($categories);
    }
    public function add(Request $request) {
        //validate the info, create rules for the inputs
        $rules = array(
            'id' => 'numeric',
            'Name' => 'required',
            'DisplayOrder' => 'required|numeric|min:1'
        );
        // run the validation rules on the inputs from the form
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return BaseResult::error(400, $validator->messages()->toJson());
        } else {
            $user = Session::get('user');
            $category = new Category;
            try {
                $parentId = $request->PARENT_ID;
                $category->PARENT_ID = $parentId;
                // -- depth -------
                if ($parentId == 0) {
                    $category->Depth = 0;
                } else {
                    $parent = Category::find($parentId);
                    if ($parent) {
                        $category->Depth = $parent->Depth + 1;
                    } else {
                        $category->Depth = 0;
                    }
                }
                // -- end: depth --
                $category->Name = $request->Name;
                $category->DisplayOrder = $request->DisplayOrder;  
                $category->IsPublished = $request->has('IsPublished') ? true : false; 
                $category->IsDeleted = 0;
                $category->CreatedDate = now();
                $category->CreatedBy = $user->USE_ID;

                $category->save();
                return BaseResult::withData($category);
            } catch (\Exception $e) {
                return BaseResult::error(500, $e->getMessage());
            }
        }
    }
    public function update(Request $request) {
        //validate the info, create rules for the inputs
        $rules = array(
            'id' => 'numeric',
            'Name' => 'required',
            'DisplayOrder' => 'required|numeric|min:1'
        );
        // run the validation rules on the inputs from the form
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return BaseResult::error(400, $validator->messages()->toJson());
        } else {
            $user = Session::get('user');
            $category = Category::find($request->input('id'));
            if ($category) {
                try {
                    $parentId = $request->PARENT_ID;
                    $category->PARENT_ID = $parentId;
                    // -- depth -------
                    if ($parentId == 0) {
                        $category->Depth = 0;
                    } else {
                        $parent = Category::find($parentId);
                        if ($parent) {
                            $category->Depth = $parent->Depth + 1;
                        } else {
                            $category->Depth = 0;
                        }
                    }
                    // -- end: depth --

                    $category->Name = $request->Name;
                    $category->DisplayOrder = $request->DisplayOrder; 
                    $banner->IsPublished = $request->has('IsPublished') ? true : false;                
                    $category->IsDeleted = 0;
                    $category->UpdatedDate = now();
                    $category->UpdatedBy = $user->USE_ID;

                    $category->save();
                    return BaseResult::withData($category);
                } catch (\Exception $e) {
                    return BaseResult::error(500, $e->getMessage());
                }
            } else {
                return BaseResult::error(404, 'Data not found!.');
            }
        }
    }
    public function delete($id) {
        $category = Category::find($id);
        if ($category) {
            $user = Session::get('user');

            $category->IsDeleted = 1;
            $category->UpdatedDate = now();
            $category->UpdatedBy = $user->USE_ID;
            $category->save();
            return BaseResult::withData($category);
        } else {
            return BaseResult::error(404, 'Không tìm thấy dữ liệu!.');
        }
    }
}
