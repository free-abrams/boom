<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
    	return view('admin.index.index');
    }
    
    public function error()
    {
    	return view('admin.302');
    }
}
