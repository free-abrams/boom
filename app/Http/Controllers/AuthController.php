<?php

namespace App\Http\Controllers;

use App\Models\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
	
	public function getLoginForm()
	{
		return view('admin.login.login');
	}
	
	public function login(Request $request)
	{
		$param = $request->all(['username', 'password']);
		
		$validate = Validator::make($param, [
			'username' => 'required',
			'password' => 'required'
		]);
		
		if ($validate->fails()) {
			
			$request->session()->flash('danger', '账号或密码为空');
			
			return redirect()->back()->withInput();
		}
		
		$res = Auth::guard('admin')->attempt($param, isset($param['remember']) && $param['remember'] == 'on');
		if ($res) {
			return redirect()->route('index');
		} else {
			$request->session()->flash('danger', '账号或密码错误');
			return redirect()->back()->withInput();
		}
	}
	
	public function logout()
	{
		Auth::guard('admin')->logout();
		
		return redirect()->route('login');
	}
}
