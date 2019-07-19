<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
 
use Illuminate\Http\Request;

use App\User;

use App\Listing;

use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
	
	 public function index()
    {
		$user = User::count();
		$listing = Listing::count();
		
        return view('admin.dashboard',['title' => 'Dashboard'])->with(array('users' => $user,'listings' => $listing));
    }
	
}