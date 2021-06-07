<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;

use App\Repositories\CustomerRepository;
use App\Models\Admin;
use App\Models\AdminInfo;

use Carbon\Carbon;
use Session;
use Hash;
use DB;

class CustomerController extends Controller
{
    protected $admin;
    protected $admin_info;

    public function __construct(Admin $admin, AdminInfo $admin_info){
        $this->admin                 = new CustomerRepository($admin);
        $this->admin_info            = new CustomerRepository($admin_info);
    }

    public function index(){
        return view ('admin.customer.index');
    }
    // Tạo tài khoản mới
    public function store(Request $request){
        $has_code       = $this->admin_info->checkCode($request->code);
        $has_email      = $this->admin->checkEmail($request->email);

        // dd($has_room);
        // kiểm tra email và số cmnd đã tồn tại chưa
        if ($has_code || $has_email) {
            return redirect()->back()->with('error', 'Email hoặc người dùng đã tồn tại');  
        }else{
            $account_data   = [
                'secret_key' => $this->admin->generateSecretKey(),
                'username'   => $request->username,
                'email'      => $request->email,
                'password'   => Hash::make($request->password),
                'status'     => '1',
                'middleware' => $request->middleware,
            ];
            $account = $this->admin->create( $account_data );
            if ($account) {

                $avatar     = $request->avatar != null ? $this->admin->uploadImage($request->avatar) : ' ' ;
                
                $account_detail_data   = [
                    'admin_id'      => $account->id,
                    'name'          => $request->name,
                    'avatar'        => $avatar,
                    'code'          => $request->code,
                    'address'       => $request->address,
                    'dob'           => $request->dob,
                    'telephone'     => $request->telephone,
                ];
                $account_detail     = $this->admin_info->create( $account_detail_data );
                // dd($account_detail);
                if ($account_detail) {
                    return redirect()->back()->with('success', 'Đăng kí thành công');  
                }else{
                    return redirect()->back()->with('error', 'Đăng kí thất bại'); 
                }
            }
            return redirect()->back()->with('error', 'Đăng kí thất bại'); 
        }
    }

    // API
    public function getall(){
        return $this->admin->getAllWith();
    }

}
