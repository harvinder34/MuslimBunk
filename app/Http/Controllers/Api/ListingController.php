<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\Listing; 
use App\ListingImage; 
use App\Amenitie; 
use Illuminate\Support\Facades\Auth; 
use Validator;
use DB;
use File;
use Illuminate\Support\Facades\URL;
class ListingController extends Controller

{

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
	
	public function getAmenities($id)
	{      
		$amenitiesData = DB::select('select name from amenities where id IN('.$id.')');
		$dataArr = array();
		foreach($amenitiesData as $data){
			$dataArr[] = $data->name;
		}
		
		return $dataArr;
	}
	
	public function getHouseRules($id)
	{      
		$houseRulesData = DB::select('select name from house_rules where id IN('.$id.')');
		$dataArr = array();
		foreach($houseRulesData as $data){
			$dataArr[] = $data->name;
		}
		
		return $dataArr;
	}
	
	public function getImages($listId,$userId)
	{      
		$imagesData = DB::select('select listing_images from listing_images where listing_id  = '.$listId.'');
        
		$imgDataArr = array();
		foreach($imagesData as $data){
			$imgDataArr[] = URL::asset('/public/images/user/'.$userId.'/'.$listId.'/'.$data->listing_images);
		}
		
		return $imgDataArr;
		
	}
	
	
    public function index()
    {

        $listings = Listing::all();
		
		foreach($listings as $listing){
			
	        $listing['amenities'] = array();
			if(!empty($listing->amenitie_ids)){
				$listing['amenities'] = $this->getAmenities($listing->amenitie_ids);
			}
			if(!empty($listing->house_rules)){
				$listing['house_rules'] = $this->getHouseRules($listing->house_rules);
			}
			$listing['listing_images'] = $this->getImages($listing->id,$listing->user_id);
			$data[] = $listing;
		}
		
        return $this->sendResponse($data, 'Listing retrieved successfully.');

    }


    public function store(Request $request)
    {
		
        $input = $request->all();
		
        $validator = Validator::make($input, [

            'user_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'city' => 'required',
            'address' => 'required',
            'size_of_property' => 'required',
            'currently_lives_here' => 'required',
            'currently_no_of_persons_lives' => 'required',
            'amenitie_ids' => 'required',
            'house_rules' => 'required',
            'bed_type' => 'required',
            'size_of_room' => 'required',
            'room_availability' => 'required',
            'monthly_rent' => 'required',
            'bills_included' => 'required',
            'deposit' => 'required',
            'tell_us_more' => 'required',
            'listing_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:15000'
        ]);
		

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
 
        $formData = array(
            'user_id' => $request->user_id,
            'title' => $request->title,
            'description' => $request->description,
            'city' => $request->city,
            'address' => $request->address,
            'size_of_property' => $request->size_of_property,
            'currently_lives_here' => $request->currently_lives_here,
            'currently_no_of_persons_lives' => $request->currently_no_of_persons_lives,
            'amenitie_ids' => $request->amenitie_ids,
            'house_rules' => $request->house_rules,
            'bed_type' => $request->bed_type,
            'size_of_room' => $request->size_of_room,
            'room_availability' => $request->room_availability,
            'monthly_rent' => $request->monthly_rent,
            'bills_included' => $request->bills_included,
            'deposit' => $request->deposit,
            'tell_us_more' => $request->tell_us_more,
            'status' => '1',
        );
		
	
        $listing = Listing::create($formData);
		$lastId = $listing->id;
		
		if (! File::exists(public_path()."/images/user/".$request->user_id."/".$lastId)) {
			File::makeDirectory(public_path()."/images/user/".$request->user_id."/".$lastId,0777,true);
		}
		
		$ImageName = 'list'.str_random(64).'.'.request()->listing_image->getClientOriginalExtension();
        request()->listing_image->move(public_path()."/images/user/".$request->user_id."/".$lastId, $ImageName);
		
		 $listingData = array(
		      'listing_id' => $lastId,
		      'listing_images' => $ImageName
		 );
		$listingImages = ListingImage::create($listingData);
        return $this->sendResponse($listing, 'Listing created successfully.');

    }

    public function show($id)
    {
        $listings = Listing::join('users', 'users.id', '=', 'listing.user_id')->select('listing.*')->where('listing.user_id',$id)->get();
		
		if(is_null($listings)){
			 return $this->sendError('Listing not found.');
		}
		
		foreach($listings as $listing){
			
	        $listing['amenities'] = array();
			if(!empty($listing->amenitie_ids)){
				$listing['amenities'] = $this->getAmenities($listing->amenitie_ids);
			}
			if(!empty($listing->house_rules)){
				$listing['house_rules'] = $this->getHouseRules($listing->house_rules);
			}
			
			$listing['listing_images'] = $this->getImages($listing->id,$listing->user_id);
			$data[] = $listing;
		}
		
        return $this->sendResponse($data, 'Listing retrieved successfully.');

    }
	
	public function getListingByCity($city)
    {
		
        $listings = Listing::where('city',$city)->get();
		
		if(is_null($listings)){
			 return $this->sendError('Listing not found.');
		}
		
		foreach($listings as $listing){
			
	        $listing['amenities'] = array();
			if(!empty($listing->amenitie_ids)){
				$listing['amenities'] = $this->getAmenities($listing->amenitie_ids);
			}
			if(!empty($listing->house_rules)){
				$listing['house_rules'] = $this->getHouseRules($listing->house_rules);
			}
			
			$listing['listing_images'] = $this->getImages($listing->id,$listing->user_id);
			$data[] = $listing;
		}
		
        return $this->sendResponse($data, 'Listing retrieved successfully.');

    }
	
	public function getListingByFlatmates($gender,$maxFlatmates)
    {
		
        $listings = Listing::where('currently_lives_here',$gender)->where('currently_no_of_persons_lives',$maxFlatmates)->get();
		
		if(is_null($listings)){
			 return $this->sendError('Listing not found.');
		}
		
		foreach($listings as $listing){
			
	        $listing['amenities'] = array();
			if(!empty($listing->amenitie_ids)){
				$listing['amenities'] = $this->getAmenities($listing->amenitie_ids);
			}
			if(!empty($listing->house_rules)){
				$listing['house_rules'] = $this->getHouseRules($listing->house_rules);
			}
			
			$listing['listing_images'] = $this->getImages($listing->id,$listing->user_id);
			$data[] = $listing;
		}
		
        return $this->sendResponse($data, 'Listing retrieved successfully.');

    }
	
	public function getListingByMonthlyBudget(Request $request)
    {
		$input = $request->all();
        $listings = Listing::whereBetween('monthly_rent', array($input['min'], $input['max']))->get();
		
		if(is_null($listings)){
			 return $this->sendError('Listing not found.');
		}
		
		foreach($listings as $listing){
			
	        $listing['amenities'] = array();
			if(!empty($listing->amenitie_ids)){
				$listing['amenities'] = $this->getAmenities($listing->amenitie_ids);
			}
			if(!empty($listing->house_rules)){
				$listing['house_rules'] = $this->getHouseRules($listing->house_rules);
			}
			
			$listing['listing_images'] = $this->getImages($listing->id,$listing->user_id);
			$data[] = $listing;
		}
		
        return $this->sendResponse($data, 'Listing retrieved successfully.');

    }
	
	public function getListingByOrder(Request $request, $orderBy, $order)
    {
		
		switch ($orderBy) {
			case "price":
				$orderBy = 'monthly_rent';
				break;
			case "recent":
				$orderBy = 'id';
				break;
			default:
			  $orderBy = $orderBy;
			 	
		}
        $listings = Listing::orderByRaw($orderBy .' '.strtoupper($order))->get();
		
		if(empty($listings)){
			 return $this->sendError('Listing not found.');
		}
		
		foreach($listings as $listing){
			
	        $listing['amenities'] = array();
			if(!empty($listing->amenitie_ids)){
				$listing['amenities'] = $this->getAmenities($listing->amenitie_ids);
			}
			if(!empty($listing->house_rules)){
				$listing['house_rules'] = $this->getHouseRules($listing->house_rules);
			}
			
			$listing['listing_images'] = $this->getImages($listing->id,$listing->user_id);
			$data[] = $listing;
		}
		
        return $this->sendResponse($data, 'Listing retrieved successfully.');

    }
	

}
