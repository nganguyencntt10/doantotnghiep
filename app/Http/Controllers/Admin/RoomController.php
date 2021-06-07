<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

use App\Time;
use App\Repositories\ServicesRepository;
use App\Models\Services;
use App\Repositories\ServicesProcedureRepository;
use App\Models\ServicesProcedure;
use App\Repositories\RoomRepository;
use App\Models\Room;

use Carbon\Carbon;
use Session;
use Hash;
use DB;

class RoomController extends Controller
{
    protected $room;
    protected $services;
    protected $services_procedure;

    public function __construct(Services $services, ServicesProcedure $services_procedure, Room $room){
        $this->room                 = new RoomRepository($room);
        $this->services             = new ServicesRepository($services);
        $this->services_procedure   = new ServicesProcedureRepository($services_procedure);
    }

    public function index(){
        return view ('admin.room.index');
    }
    // Tạo service
    public function store(Request $request){
        $has_room    = $this->room->checkRoom($request->name);
        // dd($has_room);
        // kiểm tra phòng đã tồn tại hay chưa
        if ($has_room) {
            return redirect()->back()->with('error', 'Phòng đã tồn tại');  
        }else{
            $data       = [
                "name"                  => $request->name,
                "services_procedure_id" => $request->services_procedure_id,
                "status"                => '1',
            ];
            $this->room->create($data);
            return redirect()->back()->with('success', 'Tạo thành công');  
        }
    }

    //  API
    public function getall(){
        return $this->room->getAllWith();
    }
    public function getById(Request $request){

        // lấy ra các liệu trình
        $services = [];
        foreach ($request->room_list as $key => $value) {
            array_push($services, $this->services_procedure->find($value));
        }

        // lấy ra các phòng của liệu trình hôm nay
        $room_data = [];
        foreach ($request->room_list as $key => $value) {
            array_push($room_data, $this->room->getById($value));
        }

        $time       = new Time($request->room_list);
        return $time->getEmptyTime($services, $room_data);
        $time->get_room($services, $room_data);
        return [
            'room'  => $time->room,
            'start' => $time->time_room_start,
            'end'   => $time->time,
        ];
    }

}
