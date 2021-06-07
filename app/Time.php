<?php

namespace App;
use Carbon\Carbon;

class Time
{
	// danh sách các bệnh
	public $room_list 	= null;
	public $time_start 	= 8;
	public $time_end 	= 24;
	// public $room 				=	[];
	// public $time 				= 	[];
	// public $time_code 			= 	[];
	// public $time_room_start 	= 	[];
	public $time_return 		= 	[];
	public $time_count	 		= 0;
	public function __construct($room_list){
		$this->room_list 		= $room_list;
		$this->time_count 		= ($this->time_end - $this->time_start) * 60;
	}
	public function permutation(){

	}
	public function getEmptyTime($service_time, $data){
		// return $this->room_list;

		// hoán vị sắp xếp của các bệnh
		//// chỗ này đang trả về mã của phòng
		return $this->room_list;
		$room_Permutations = static::computePermutations($this->room_list);
		for ($i=0; $i < count($room_Permutations); $i++) { 
			static::get_room($i, $room_Permutations[$i], $service_time, $data);
		}

		$min_1 = 0;
		$min_value = 10000;
		foreach ($this->time_return as $key => $value) {
			$min_cache = static::time_code_next($value['end'][count($value['end']) - 1], 10);
			if ($min_cache < $min_value) {
				$min_value = $min_cache;
				$min_1 = $key;
			}
		}
		return $this->time_return[$min_1];

    }
    // mã thời gian thể hiện thời gian đặt lịch, mã thời gian tỉ lệ với số phút của bệnh và thời gian làm việc

    // trả về mã thời gian kế tiếp cần thiết theo hiện tại (truyền vào tgian tiêu tốn)
    public function time_code_next($now, $service_time){
    	$hour 	= explode(":",$now)[0] - $this->time_start;
    	$minute = explode(":",$now)[1];
    	return ceil((($hour * 60) + $minute) / $service_time);
    }
    // trả về thơi gian thực (truyền vào mã thời gian, tgian của dịch vụ) ( kết thúc )
    public function time_real($time_code, $service_time){
    	$time 	= $time_code * $service_time + $service_time;
    	$hour 	= floor( $time / 60) + 8;
    	$minute = floor( $time % 60);
    	return ($hour.':'.$minute);
    }
    // trả về thơi gian thực (truyền vào mã thời gian, tgian của dịch vụ) ( bắt đầu )
    public function time_real_start($time_code, $service_time){
    	$time 	= $time_code * $service_time;
    	$hour 	= floor( $time / 60) + 8;
    	$minute = floor( $time % 60);
    	return ($hour.':'.$minute);
    }

	// trả về mảng mã thời gian của 1 phòng
	public function return_time_code($room_array){
		$time_code = [];
		foreach ($room_array as $key => $value) {
			array_push($time_code, $value->time_set);
		}
		return $time_code;
	}
	// trả về danh sách mã thời gian theo phòng của service
	public function get_array_time_service($data){
		$data_return = [];
		foreach ($data as $key => $value) {
			if ($value->booking) {
				array_push($data_return, static::return_time_code($value->booking));
			}
		}
		return $data_return ;
	}
	// lấy ra phòng gần nhất phù hợp ( truyền vào datarôm của bệnh , loaị bệnh )
	// array_key : mã hoán vị
	// data_array: hoán vị
	public function get_room($array_key, $data_array, $service_time, $data){
		$room 				=	[];
		$time 				= 	[];
		$time_code 			= 	[];
		$time_room_start 	= 	[];

		foreach ($data_array as $key => $value_per) {

			// mã thời gian tối đa
			$time_code_max 		= static::time_code_max($service_time[$value_per - 1]->time);

			// mã thời gian cần thiết
			$time_last 	= count($time) > 0 ? $time[count($time) - 1] : Carbon::now('Asia/Ho_Chi_Minh')->toTimeString();

			$min_next_time 		= static::time_code_next($time_last, $service_time[$value_per - 1]->time);
			// return ($min_next_time);
			// danh sách code_time trong các phòng
			$time_code_room 	= static::get_array_time_service($data[$value_per - 1]);

			// return $time_code_room;
			// tìm kiếm khung thời gian phù hợp
			$code_time = $min_next_time;
			// array_push($room, static::time_real($code_time, $service_time[$value_per - 1]->time));
			while ($code_time < $time_code_max) {
				foreach ($time_code_room as $key => $value) {
					if (!in_array($code_time, $value)) {
						// tên phòng
						array_push($room, $data[$value_per - 1][$key]->name);
						// thời gian kết thúc
						array_push($time, static::time_real($code_time, $service_time[$value_per - 1]->time));
						// thời gian bắt đầu
						array_push($time_room_start, static::time_real_start($code_time, $service_time[$value_per - 1]->time));
						// mã thời gian
						array_push($time_code, $code_time);
						$code_time = 1000000;
						break;
					}else{
						$code_time++;
					}
				}
			}
		} 
		$data_return_all = [
            'room'  => $room,
            'start' => $time_room_start,
            'end'   => $time,
        ];

        $this->time_return[$array_key] = $data_return_all;
        // array_push(, $data_return_all);
	}
	// trả về mã thời gian tối đa theo bệnh
	public function time_code_max($services){
		return $this->time_count / $services ;
	}
    // tạo hoán vị
	public function computePermutations($array) {
	    $result = [];
	    $recurse = function($array, $start_i = 0) use (&$result, &$recurse) {
	        if ($start_i === count($array)-1) {
	            array_Push($result, $array);
	        }

	        for ($i = $start_i; $i < count($array); $i++) {
	            //Swap array value at $i and $start_i
	            $t = $array[$i]; $array[$i] = $array[$start_i]; $array[$start_i] = $t;

	            //Recurse
	            $recurse($array, $start_i + 1);

	            //Restore old order
	            $t = $array[$i]; $array[$i] = $array[$start_i]; $array[$start_i] = $t;
	        }
	    };

	    $recurse($array);

	    return $result;
	}
}
