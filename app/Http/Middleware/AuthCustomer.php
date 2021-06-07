<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cookie;
use App\Models\Customer;
use Session;
use Hash;
use DB;

class AuthCustomer
{
    public function handle($request, Closure $next, $url) {   
        $token = Session('_token_') ? Session('_token_') : $request->cookie('_token_');

        // kiểm tra route có thuộc diện chưa đăng nhập : 'auth' = chưa đăng nhập
        if ($url == 'auth') {
            // kiểm tra có tồn tại token
            if ($token) {
                list($user_id, $token) = explode('$', $token, 2);
                $user = DB::table('customer')->where('id', '=', $user_id)->first();
                if ($user) {
                    $secret_key     = $user->secret_key;
                    // kiểm tra token có hợp lệ
                    if ($user->status) {
                        if (Hash::check($user_id . '$' . $secret_key, $token)) {
                            return redirect()->route('customer.order');
                        }else{
                            Cookie::queue(Cookie::forget('_token_'));
                            $request->session()->forget('_token_');
                            return redirect()->route('customer.login')->with('success', 'Token đã hết hạn');  
                        }
                    }else{
                        $request->session()->forget('_token_');
                        Cookie::queue(Cookie::forget('_token_'));
                        return redirect()->route('customer.login')->with('error', 'Tài khoản đã bị khóa!');  
                    }
                }else{
                    $request->session()->forget('_token_');
                    Cookie::queue(Cookie::forget('_token_'));
                    return redirect()->route('customer.login')->with('success', 'Tài khoản không tồn tại!');  
                }
            }else{
                return $next($request);
            }
        }else{
            // kiểm tra có tồn tại token
            if ($token) {
                list($user_id, $token) = explode('$', $token, 2);
                $user = DB::table('customer')->where('id', '=', $user_id)->first();
                if ($user->status) {
                    if ($user) {
                        $secret_key     = $user->secret_key;

                        if (Hash::check($user_id . '$' . $secret_key, $token)) {
                            return $next($request);
                        }else{
                            Cookie::queue(Cookie::forget('_token_'));
                            $request->session()->forget('_token_');
                            return  redirect()->route('customer.login')->with('success', 'Token đã hết hạn');  
                        }
                    }else{
                        $request->session()->forget('_token_');
                        Cookie::queue(Cookie::forget('_token_'));
                        return redirect()->route('customer.login')->with('success', 'Tài khoản không tồn tại!');  
                    }
                }else{
                    $request->session()->forget('_token_');
                    Cookie::queue(Cookie::forget('_token_'));
                    return redirect()->route('customer.login')->with('error', 'Tài khoản đã bị khóa!');  
                }
            }else{
                return redirect()->route('customer.login')->with('success', 'Bạn cần đăng nhập để thực hiện hành động này');  
            }
        }
    }
}
