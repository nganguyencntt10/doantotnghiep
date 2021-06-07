<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DisplayAdminController extends Controller
{
	
	public function dashboard(){
		return view('admin.dashboard.index');
	}
	public function manager(){
		return view('manage.dashboard.index');
	}
	public function login(){
		return view('admin.auth.login');
	}
}
