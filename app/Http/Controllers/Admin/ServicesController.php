<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

use App\Repositories\ServicesRepository;
use App\Models\Services;
use App\Repositories\ServicesProcedureRepository;
use App\Models\ServicesProcedure;


use Carbon\Carbon;
use Session;
use Hash;
use DB;

class ServicesController extends Controller
{
    protected $services;
    protected $services_procedure;

    public function __construct(Services $services, ServicesProcedure $services_procedure){
        $this->services             = new ServicesRepository($services);
        $this->services_procedure   = new ServicesProcedureRepository($services_procedure);
    }

    public function index(){
    	return view ('admin.services.index');
    }
    // Tạo service
    public function store(Request $request){
        // dd($request);
        $slug           = $this->services->to_slug($request->name);
        $has_service    = $this->services->checkSlug($slug);

        // kiểm tra tên đã tồn tại hay chưa
        if ($has_service) {
            return redirect()->back()->with('error', 'Tên đã tồn tại');  
        }else{
            $image_avatar   = $this->services->uploadImage($request->image);
            $image_array    = $this->services->uploadImageList($request->images);

            $data       = [
                "name"          => $request->name,
                "slug"          => $slug,
                "image"         => $image_avatar,
                "images"        => $image_array,
                "description"   => $request->description,
                "detail"        => $request->detail,
            ];
            $service    = $this->services->create($data);

            for ($i = 0; $i < count($request->procedure_name); $i++) { 
                $sub_data   = [
                    "service_id"    => $service->id,
                    "name"          => $request->procedure_name[$i],  
                    "time"          => $request->procedure_time[$i],
                    "prices"        => $request->procedure_prices[$i],
                ];
                $services_procedure    = $this->services_procedure->create($sub_data);
            }

            return redirect()->back()->with('success', 'Tạo thành công');  
        }
    }

    //  API
    public function getall(){
        return $this->services->getAll();
    }
    public function getallwith(){
        return $this->services->getAllWith();
    }
    
    public function getallprocedure(){
        return $this->services_procedure->getAll();
    }

}
