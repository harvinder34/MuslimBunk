<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
 
use Illuminate\Http\Request;

use Validator;

use URL;

use App\Listing;

use Illuminate\Support\Facades\DB;

class ListingController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
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
	
	public function getImages($listId,$userId)
	{      
		$imagesData = DB::select('select listing_images from listing_images where listing_id  = '.$listId.'');
        
		$imgDataArr = array();
		foreach($imagesData as $data){
			$imgDataArr[] = URL::asset('/public/images/user/'.$userId.'/'.$listId.'/'.$data->listing_images);
		}
		
		return $imgDataArr;
		
	}
	
	public function getRules($ruleId)
	{      
		$rulesData = DB::select('select name from house_rules where id IN('.$ruleId.')');
		$rulesDataArr = array();
		foreach($rulesData as $data){
			$rulesDataArr[] = $data->name;
		}
		
		return $rulesDataArr;
	}
	
	 public function index()
    {
		$listings = Listing::join('users', 'users.id', '=', 'listing.user_id')->select('listing.*','users.first_name')->get();
		
		foreach($listings as $listing){
			
	        $listing['amenities'] = array();
			if(!empty($listing->amenitie_ids)){
				$listing['amenities'] = implode(',',$this->getAmenities($listing->amenitie_ids));
			}
			
			$listing['listing_images'] = $this->getImages($listing->id,$listing->user_id);
			$data[] = $listing;
			}
        return view('admin.listing.listing',['title' => 'Listing Management'])->with(array('listings' => $data));
    
	}
	
	public function status($id, $status)
    {
		if( empty( $id ) ) {
			exit;
		}		
		Listing::where('id',$id)->update(array('status' => $status));
		return redirect('admin/listing')->with('status', 'Updated Successfully!');
    }
		
	public function view($id)
    {
         $listing =  Listing::where('id',$id)->first();
		 
		 if(!empty($listing->amenitie_ids)){
				$listing['amenities'] = implode(',',$this->getAmenities($listing->amenitie_ids));
			}
			
		 $listing['listing_images'] = $this->getImages($listing->id,$listing->user_id);
		 
		 $listing['rules'] = implode(',',$this->getRules($listing->house_rules));
		 
		 return view('admin.listing.view',['title' => 'View Listing'])->with(array('listing' => $listing));
    }
	
	public function destroy($id)
    {
         //Listing::where('id',$id)->delete();
		 //return redirect('admin/listing')->with('status', 'Listing Deleted Successfully!');
    }
}