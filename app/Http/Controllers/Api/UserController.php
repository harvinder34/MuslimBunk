<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\User;  
use Illuminate\Support\Facades\Auth; 
use Validator;
use DB;
use File;
use URL;
class UserController extends Controller
{
	
	private const IMGPATH = '/images/users/profile/';
	
	public function sendResponse($result, $message)
    {
    	$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
			'error' => false
        ];

        return response()->json($response, 200);
    }
	
    public function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
			'error' => true
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);

    }
	
	/**
	  * @register
	  */
	public function register(Request $request) 
	{    
		$requestJson = $request->json()->all(); 
		$validator = Validator::make($requestJson, ['email' => 'required|email|unique:users']);   
		if ($validator->fails()) 			
		{   
			return $this->sendJsonResponse($validator->errors()->first(), 0);	
		}   
		
		/**
     	  *	@role customer 3
		  */
		$requestJson['password'] = bcrypt($requestJson['password']);		    
		$user = User::create($requestJson);
		
		return $this->sendJsonResponse('User Registered Successfully', 1, $user->only(['id', 'email', 'first_name', 'last_name','type']));
		
	}
	
	/**
	  * @login
	  */
    public function login()
	{ 
		if(Auth::attempt(['email' => request('email'), 'password' => request('password')]))
		{	
			$user = Auth::user();				
			return $this->sendJsonResponse('User login Successfully', 1, $user->only(['id', 'email', 'first_name', 'last_name'])); 			
		} else { 
			return $this->sendJsonResponse('These credentials do not match our records', 0);
		} 
	}
	
    public function getUserImages($userId)
	{      
		$imagesData = DB::select('SELECT image FROM user_images WHERE user_id  = '.$userId.' ORDER BY id DESC');
        
		$imgDataArr = array();
		foreach($imagesData as $data){
			$imgDataArr[] = URL::asset('/public/images/users/'.$userId.'/'.$data->image);
		}
		
		return $imgDataArr;
		
	}
	
	/**
	  * @index get all users 
	  */
	public function index()
	{
		$users = User::where('users.role','!=', '1')->get();  
		
		if( empty( $users->count() ) ) {
			return $this->sendJsonResponse('No records found', 0);
		} 
		
		foreach($users as $user){
			
			if(!empty($user->occupation)) {
				$user['occupation'] = $this->getUserMeta('occupations', $user->occupation);
			}
			if(!empty($user->languages)){
				$user['languages'] = $this->getUserMeta('languages', $user->languages);
			}
			if(!empty($user->personality)) {
				$user['personality'] = $this->getUserMeta('personalities', $user->personality);
			}
			if(!empty($user->lifestyle)) {
				$user['lifestyle'] = $this->getUserMeta('lifestyle', $user->lifestyle);
			}
			if(!empty($user->music)) {
				$user['music'] = $this->getUserMeta('music', $user->music);
			}
			if(!empty($user->sports)) {
				$user['sports'] = $this->getUserMeta('sports', $user->sports);
			}
			if(!empty($user->movies)) {
				$user['movies'] = $this->getUserMeta('movies', $user->movies);
			}
			$data[] = $user;
		}
		        
		return $this->sendJsonResponse('Users retrieved successfully', 1, $data);
	}
	
	
	public function show($id)
	{
		$user = User::Where('id', $id)->first();
		if( empty( $user->count() ) ) {
			return $this->sendJsonResponse('Something went wrong', 0);
		} 
						
		$user['images'] = $this->getUserImages($id);
		if(!empty($user->occupation)) {
			$user['occupation'] = $this->getUserMeta('occupations', $user->occupation);
		}
		if(!empty($user->languages)){
			$user['languages'] = $this->getUserMeta('languages', $user->languages);
		}
		if(!empty($user->personality)) {
			$user['personality'] = $this->getUserMeta('personalities', $user->personality);
		}
		if(!empty($user->lifestyle)) {
			$user['lifestyle'] = $this->getUserMeta('lifestyle', $user->lifestyle);
		}
		if(!empty($user->music)) {
			$user['music'] = $this->getUserMeta('music', $user->music);
		}
		if(!empty($user->sports)) {
			$user['sports'] = $this->getUserMeta('sports', $user->sports);
		}
		if(!empty($user->movies)) {
			$user['movies'] = $this->getUserMeta('movies', $user->movies);
		}
		
		$data[] = $user;  
			
        return $this->sendJsonResponse('User retrieved successfully', 1, $data);
	}
	
	
	
	public function update(Request $request)
    {
				
		$requestPost = $request->all();
		
		$userID = $requestPost['user_id'];
		unset($requestPost['user_id']);
		
        $validator = Validator::make($requestPost, [
            'first_name' => 'required',
            'last_name' => 'required',
            'dob' => 'required',
            'gender' => 'required',
            'work' => 'required',
            'occupation' => 'required',   
            'languages' => 'required',
            'personality' => 'required',
            'lifestyle' => 'required',
            'music' => 'required',
            'sports' => 'required',
            'movies' => 'required',
            'about' => 'required',
            //'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
		
        ]);
 
        if($validator->fails()){
            return response()->json(['message' => 'Validation Error', 'status' => 0, 'errors' => $validator->errors()]);
		}
				
		$user = User::where('id', $userID)->update($requestPost);        
		
		/* if (!File::exists(public_path().self::$imgPath.$userID)) {
			File::makeDirectory(public_path().self::$imgPath.$userID, 0777, true);
		}
		
		$ImageName = str_random(64).'.'.request()->image->getClientOriginalExtension();
        request()->image->move(public_path().self::$imgPath.$userID, $ImageName);
		
		$userData = array(
		      'user_id' => $userID,
		      'image'   => $ImageName
		);
		
		DB::table('user_images')->insert($userData); */
		$userData = User::where('id', $userID)->first();
		return $this->sendJsonResponse('User updated successfully', 1, $userData->only(['id', 'email', 'first_name', 'last_name']));		
        

    }
		
	/**
	  *@getUserMeta @table name and ids
	  */
	private function getUserMeta($table, $ids) {
		
		$getData = DB::select("SELECT name FROM ".$table." WHERE id IN(".$ids.")");
		
		$dataArr = array();
		foreach($getData as $data){
			$dataArr[] = $data->name;
		}		
		return $dataArr;
		
	}
	
	/**
	  * @return JSON Response
	  */	
	private function sendJsonResponse( $message, $status = null, $response = [] ) {
		
		return response()->json(array('message' => $message, 'status' => $status, 'response' => (object)$response));
		
	}	
}
