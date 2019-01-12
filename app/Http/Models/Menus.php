<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Menus extends Model
{

	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'am_menus';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'title', 'slug', 'description', 'state',
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
