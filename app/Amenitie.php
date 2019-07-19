<?php
namespace App;


use Illuminate\Database\Eloquent\Model;


class Amenitie extends Model

{
	//protected $table = 'listing';
    /**
     * The attributes that are mass assignable.
     *
     * @var array

     */
    protected $fillable = [
       'name','status'
    ];
}
