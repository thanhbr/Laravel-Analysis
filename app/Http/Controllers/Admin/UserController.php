<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index() {
        //check login from cookie
		$userCookie = Cookie::get('userCredential');
		// attempt to do the login
		if ($userCookie) {
			$userCookie = json_decode($userCookie);
			$userdata = array(
				'username' => $userCookie->username,
				'password' => $userCookie->password
			);
			$user = User::where(['IsDeleted' => 0, 'username' => $userCookie->username])->first();
			if ($user) {
				if ($user->IsLocked == false) {
					if (Auth::attempt($userdata)) {
						Session::put('user', Auth::user());
						return Redirect::action([DashboardController::class, 'index']);
					}
				}
			}
		}

        return view('admin.login');
    }

    public function indexUser() {
        return view('admin.user');
    }

    public function doLogin(Request $request) {
        //validate the info, create rules for the inputs
        $rules = array(
            'username' => 'required',
            'password' => 'required'
        );
        // run the validation rules on the inputs from the form
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            Session::flash('message', 'Hãy nhập tên tài khoản hoặc mật khẩu!');
            return Redirect::action('Admin\UserController@index')
				->withErrors($validator) // send back all errors to the login form
				->withInput($request->except('password')); // send back the input (not the password) so that we can repopulate the form
        } else {
            $user = User::where(['IsDeleted' => 0, 'username' => $request->username])->first();
			if ($user) {
                // create our user data for the authentication
                $userdata = array(
                    'username'  => $request->username,
                    'password'  => $request->password
                );

                // attempt to do the login
                if (Auth::attempt($userdata)) {
                    if ($request->has('rememberMe')) {
                        Cookie::queue(Cookie::make('userCredential', json_encode($userdata), 60 * 24 * 365)); // cookie 1 year
                    }

                    Session::put('user', Auth::user());
                    return Redirect::action([DashboardController::class, 'index']);
                } else {
                    Session::flash('message', 'Tên tài khoản hoặc mật khẩu không đúng!');
                    return Redirect::action([UserController::class, 'index'])
                        ->withInput($request->except('password'));
                }
			} else {
				Session::flash('message', 'Tài khoản không tồn tại!');
				return Redirect::action([UserController::class, 'index'])
					->withInput($request->except('password'));
			}
        }
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Cookie::queue(Cookie::forget('userCredential'));
        return redirect('/user/login');
    }
}
