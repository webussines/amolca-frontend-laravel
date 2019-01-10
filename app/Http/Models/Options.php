<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Options extends Model
{

	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'am_options';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'option_name', 'option_value', 'autoload',
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
