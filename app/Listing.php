<?php
namespace App;


use Illuminate\Database\Eloquent\Model;


class Listing extends Model

{
	protected $table = 'listing';
    /**
     * The attributes that are mass assignable.
     *
     * @var array

     */
    protected $fillable = [
       'user_id','title','description','city','address','size_of_property','currently_lives_here','amenitie_ids','house_rules','bed_type','size_of_room','room_availability','monthly_rent','bills_included','deposit','tell_us_more','status'
    ];
}
