<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
 
use Illuminate\Http\Request;

use Validator;

use App\User;

use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
	
	 public function index()
    {
		$user = User::join('role','users.role', '=', 'role.id')->select('users.*', 'role.role')->where('users.role', '2')->orWhere('users.role', '3')->get();
        return view('admin.user.user',['title' => 'User Management'])->with(array('users' => $user));
    }
	
	
	public function edit($id)
    {
        $data = User::where('id', $id)->first();
        return view('admin.user.edit',['title' => 'Edit User'])->with(array('user' => $data));
    }
	
	public function update(Request $request, $id)
    {   

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required'
            
        ]);
		if ($validator->fails())
		{
			return redirect()->back()->withInput()->withErrors($validator->errors());
		}
		$update = array(
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
        );
		
        User::where('id',$id)->update($update);
		return redirect('admin/user')->with('status', 'User Updated Successfully!');
    }
	
	public function destroy($id)
    {
         User::where('id',$id)->delete();
		 return redirect('admin/user')->with('status', 'User Deleted Successfully!');
    }
	
	public function status($id, $status)
    {
		if( empty( $id ) ) {
			exit;
		}		
		User::where('id',$id)->update(array('status' => $status));
		return redirect('admin/user')->with('status', 'Updated Successfully!');
    }	
	
}