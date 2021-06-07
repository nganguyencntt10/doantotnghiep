<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cookie;
use App\Models\Admin;
use Session;
use Hash;
use DB;

class AuthAdmin
{
    public function handle($request, Closure $next, $url) {   
        $token = Session('_token__') ? Session('_token__') : $request->cookie('_token__');

        // kiểm tra route có thuộc diện chưa đăng nhập : 'auth' = chưa đăng nhập
        if ($url == 'auth') {
            // kiểm tra có tồn tại token
            if ($token) {
                list($user_id, $token) = explode('$', $token, 2);
                $user = DB::table('admin')->where('id', '=', $user_id)->first();
                if ($user) {
                    $secret_key     = $user->secret_key;
                    // kiểm tra token có hợp lệ
                    if ($user->status) {
                        if (Hash::check($user_id . '$' . $secret_key, $token)) {
                            // phân quyền
                            $middleware = explode(" | ", $user->middleware);
                            if (in_array('admin', $middleware)) {
                                return redirect()->route('admin.dashboard');
                            }else if (in_array('manage', $middleware)) {
                                return redirect()->route('manage.dashboard');
                            }else{
                                return abort('403');
                            }
                        }else{
                            Cookie::queue(Cookie::forget('_token__'));
                            $request->session()->forget('_token__');
                            return redirect()->route('admin.login')->with('success', 'Token đã hết hạn');  
                        }
                    }else{
                        $request->session()->forget('_token__');
                        Cookie::queue(Cookie::forget('_token__'));
                        return redirect()->route('admin.login')->with('error', 'Tài khoản đã bị khóa!');  
                    }
                }else{
                    $request->session()->forget('_token__');
                    Cookie::queue(Cookie::forget('_token__'));
                    return redirect()->route('admin.login')->with('success', 'Tài khoản không tồn tại!');  
                }
            }else{
                return $next($request);
            }
        }else{
            // kiểm tra có tồn tại token
            if ($token) {
                list($user_id, $token) = explode('$', $token, 2);
                $user = DB::table('admin')->where('id', '=', $user_id)->first();
                if ($user->status) {
                    if ($user) {
                        $secret_key     = $user->secret_key;

                        if (Hash::check($user_id . '$' . $secret_key, $token)) {
                            // phân quyền
                            $middleware = explode(" | ", $user->middleware);
                            return in_array($url, $middleware) ? $next($request) : abort('403');
                        }else{
                            Cookie::queue(Cookie::forget('_token__'));
                            $request->session()->forget('_token__');
                            return  redirect()->route('admin.login')->with('success', 'Token đã hết hạn');  
                        }
                    }else{
                        $request->session()->forget('_token__');
                        Cookie::queue(Cookie::forget('_token__'));
                        return redirect()->route('admin.login')->with('success', 'Tài khoản không tồn tại!');  
                    }
                }else{
                    $request->session()->forget('_token__');
                    Cookie::queue(Cookie::forget('_token__'));
                    return redirect()->route('admin.login')->with('error', 'Tài khoản đã bị khóa!');  
                }
            }else{
                return redirect()->route('admin.login')->with('success', 'Bạn cần đăng nhập để thực hiện hành động này');  
            }
        }
    }
}
