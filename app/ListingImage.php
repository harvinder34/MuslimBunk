<?php
namespace App;


use Illuminate\Database\Eloquent\Model;


class ListingImage extends Model

{
	protected $table = 'listing_images';
    /**
     * The attributes that are mass assignable.
     *
     * @var array

     */
    protected $fillable = [
       'listing_id','listing_images','status'
    ];
}
