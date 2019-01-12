<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItems extends Model
{
	
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'am_menus_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = [ 
		'id', 'menu_id', 'parent_id', 'content', 'link', 'state', 'target', 'icon', 'class', 'title', 'order' 
	];

	/**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

}
