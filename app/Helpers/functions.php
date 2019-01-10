<?php 

use App\Http\Models\Options;

//Global function to get option of this single database
function get_option($name) {
	$option = Options::where('option_name', '=', $name)->first();

	if($option == null) {
        return 'NULL';
    }

    return $option->option_value;
}