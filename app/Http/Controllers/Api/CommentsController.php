<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\BaseResult;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CommentsController extends Controller
{
    public function get($id = null)
    {
        $data = null;
        if ($id) {
            $data = Comment::where(['IsDeleted' => 0, 'COM_ID' => $id])->first();
        } else {
            $data = Comment::join('products', function ($join) {
                $join->on('products.PRO_ID', '=', 'comments.PRO_ID')
                    ->where(['products.IsDeleted' => 0, 'comments.IsDeleted' => 0]);
            })->join('customers', function ($join) {
                $join->on('customers.CUS_ID', '=', 'comments.CUS_ID')
                    ->where(['customers.IsDeleted' => 0, 'comments.IsDeleted' => 0]);
            })->get();
        }
        return BaseResult::withData($data);
    }

    public function add(Request $request)
    {
        //validate the info, create rules for the inputs
        $rules = array(
            'id' => 'numeric',
            'COMTITLE' => 'required',
            'CUS_ID' => 'required',
            'PRO_ID' => 'required',
        );


        // run the validation rules on the inputs from the form
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return BaseResult::error(400, $validator->messages()->toJson());
        } else {
            $now = Carbon::now();
            $user = Session::get('user');
            $comment = new Comment();
            try {
                $comment->COMTITLE = $request->COMTITLE;
                $comment->CUS_ID = $request->CUS_ID;
                $comment->PRO_ID = $request->PRO_ID;
                $comment->COMDESC = $request->COMDESC;
                $comment->COMDATE = $request->COMDATE;
                $comment->IsDeleted = 0;
                $comment->CreatedDate = $now;
                $comment->CreatedBy = $user->USE_ID;
                $comment->save();

                return BaseResult::withData($comment);
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
            'COMTITLE' => 'required',
            'CUS_ID' => 'required',
            'PRO_ID' => 'required',
        );

        // run the validation rules on the inputs from the form
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return BaseResult::error(400, $validator->messages()->toJson());
        } else {
            $now = Carbon::now();
            $user = Session::get('user');
            $comment = Comment::find($request->input('id'));
            if ($comment) {
                try {
                    $comment->COMTITLE = $request->COMTITLE;
                    $comment->CUS_ID = $request->CUS_ID;
                    $comment->PRO_ID = $request->PRO_ID;
                    $comment->COMDESC = $request->COMDESC;
                    $comment->COMDATE = $request->COMDATE;
                    $comment->IsDeleted = 0;
                    $comment->CreatedDate = $now;
                    $comment->CreatedBy = $user->USE_ID;
                    $comment->save();

                    return BaseResult::withData($comment);
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
        $comment = Comment::find($id);
        if ($comment) {
            $comment->IsDeleted = 1;
            $comment->UpdatedDate = now();
            $comment->CreatedBy = $user->USE_ID;
            $comment->save();
            return BaseResult::withData($comment);
        } else {
            return BaseResult::error(404, 'Data not found!.');
        }
    }
}
