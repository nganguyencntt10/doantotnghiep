<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Cookie;

use App\Repositories\AuthAdminRepository;
use App\Models\Admin;
use Carbon\Carbon;
use Session;
use Hash;
use DB;

class AuthAdminController extends Controller
{
	protected $admin;

    public function __construct(Admin $admin){
        $this->admin 		= new AuthAdminRepository($admin);
    }


	public function login(LoginRequest $request){
		// kiểm tra tài khoản đăng nhập
		$admin_id = $this->admin->checkAccount($request->email, $request->password);
		if ($admin_id) {
			$name_cookie = Cookie::queue('_token__', $this->admin->createTokenClient($admin_id), 2628000);
			return redirect()->back()->with('success', 'Đăng nhập thành công');  
		}else{
			return redirect()->back()->with('error', 'Tên tài khoản hoặc mật khẩu không chính xác'); 
		}
	}
	

	// # đăng xuất
	public function logout(Request $request){
		Cookie::queue(Cookie::forget('_token__'));
		return redirect()->route('admin.login')->with('success', 'Đăng xuất thành công');  
	}

}
