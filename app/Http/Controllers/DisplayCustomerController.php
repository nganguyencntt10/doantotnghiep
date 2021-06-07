<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

use App\Repositories\ServicesRepository;
use App\Models\Services;


use Carbon\Carbon;
use Session;
use Hash;
use DB;

class DisplayCustomerController extends Controller
{
    protected $services;

    public function __construct(Services $services){
        $this->services             = new ServicesRepository($services);
    }
	public function index(){
		$services = $this->services->getAll();
		return view('customer.index', compact('services'));
	}
	public function services(){
		$services = $this->services->getAllWith();
		return view('customer.services', compact('services'));
	}
	public function service($slug){
		$service 	= $this->services->getAllOfWith($slug);
		$image_list = explode(" | ", $service->images);
		$prices 	= $this->services->getPrices($service->id);

		return view('customer.service', compact('service', 'image_list', 'prices'));
	}


}
