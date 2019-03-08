<?php 

use App\Repositories\Countries;
use App\Http\Models\Options;
use App\Http\Models\Menus;
use App\Http\Models\MenuItems;

function get_banners_src($banners, $src, $id) {
	return $banners->findByResource($src, $id);
}

function get_sitecountry_id() {

	if (get_option('sitecountry_id') !== 'NULL') {
		return get_option('sitecountry_id');
	} else {
		return 0;
	}

}

function COPMoney($money) {

	switch (get_option('sitecountry')) {
		case 'COLOMBIA':
			return '$' . number_format($money, 0, ',', '.') . ' COP';
			break;

		case 'PANAMA':
			return '$' . number_format($money, 2, '.', ',') . ' USD';
			break;

		case 'ARGENTINA':
			return '$' . number_format($money, 2, ',', '.') . ' ARS';
			break;

		case 'MEXICO':
			return '$' . number_format($money, 2, '.', ',') . ' MXN';
			break;

		case 'PERU':
			//return 'S/ ' . number_format($money, 2, '.', ',');
			return '$' . number_format($money, 2, '.', ',') . 'USD';
			break;

		case 'DOMINICAN REPUBLIC':
			return 'DOP$ ' . number_format($money, 2, ',', '.');
			break;
	}
}

//Mailer country
function mailer_get_country() {

    if(get_option('sitecountry') == 'DOMINICAN REPUBLIC') {
    	return 'REPUBLICA DOMINICANA';
    } else {
    	get_option('sitecountry');
    }

}

//Mailer domain
function mailer_get_domain() {
    
    switch (get_option('sitecountry')) {
		case 'COLOMBIA':
			return "www.amolca.com.co";
			break;

		case 'PANAMA':
			return "www.amolca.com.pa";
			break;

		case 'ARGENTINA':
			return "www.amolca.com.ar";
			break;

		case 'MEXICO':
			return "www.amolca.com.mx";
			break;

		case 'PERU':
			return "www.amolca.com.pe";
			break;

		case 'DOMINICAN REPUBLIC':
			return "www.amolca.com.do";
			break;

		default:
			return "www.amolca.com";
			break;
	}

}

function mailer_get_name() {
    switch (get_option('sitecountry')) {
		case 'COLOMBIA':
			return "Amolca Colombia";
			break;

		case 'PANAMA':
			return "Amolca Panamá";
			break;

		case 'ARGENTINA':
			return "Amolca Argentina";
			break;

		case 'MEXICO':
			return "Amolca México";
			break;

		case 'PERU':
			return "Amolca Perú";
			break;

		case 'DOMINICAN REPUBLIC':
			return "Amolca Republica Dominicana";
			break;

		default:
			return "Amolca Casa Matriz";
			break;
	}
}

function mailer_get_me() {
    switch (get_option('sitecountry')) {
		case 'COLOMBIA':
			return "ventas@amolca.com.co";
			break;

		case 'PANAMA':
			return "ventas@amolca.com.pa";
			break;

		case 'ARGENTINA':
			return "ventas@amolca.com.ar";
			break;

		case 'MEXICO':
			return "ventas@amolca.com.mx";
			break;

		case 'PERU':
			return "ventas@amolca.com.pe";
			break;

		case 'DOMINICAN REPUBLIC':
			return "ventas@amolca.com.do";
			break;

		default:
			return "contacto@amolca.com";
			break;
	}
}

function mailer_get_cc() {
	switch (get_option('sitecountry')) {
		case 'COLOMBIA':
			return ["gerencia@amolca.com.co", "asistentepresidencia@amolca.us", "contacto@amolca.com"];
			break;

		case 'PANAMA':
			return ["asistentepresidencia@amolca.us", "contacto@amolca.com"];
			break;

		case 'ARGENTINA':
			return ["asistentepresidencia@amolca.us", "contacto@amolca.com"];
			break;

		case 'MEXICO':
			return ["asistentepresidencia@amolca.us", "contacto@amolca.com"];
			break;

		case 'PERU':
			return ["asistentepresidencia@amolca.us", "contacto@amolca.com"];
			break;

		case 'DOMINICAN REPUBLIC':
			return ["asistentepresidencia@amolca.us", "contacto@amolca.com"];
			break;

		default:
			return ["asistentepresidencia@amolca.us"];
			break;
	}
}

function format_date($str) {
	$date = new Date($str);
	$date = $date->format('j F, Y');

	return $date;
}

//Global function to get option of this single database
function get_option($name) {
	$option = Options::where('option_name', '=', $name)->first();

	if($option == null) {
        return 'NULL';
    }

    return $option->option_value;
}

//GLobal function to get an menu by slug
function get_nav_menu($slug, $class = 'hmenu', $id = 'hmenu') {

	$menu = Menus::where('slug', '=', $slug)->first();

	if($menu == null) {
        return response()->json(['status' => 404, 'message' => 'El recurso que estas buscando no existe'], 404);
    }

    $items = MenuItems::where([ ['menu_id', '=', $menu->id], ['parent_id', '=', 0] ])
    					->orderBy('order', 'asc')
    					->get();

    //Recorrer parent items y agregar los items hijos si es que existen
    for ($i = 0; $i < count($items); $i++) { 

    	$childs = MenuItems::where([ ['menu_id', '=', $menu->id], ['parent_id', '=', $items[$i]->id] ])
    					->orderBy('order', 'asc')
    					->get();

    	if( $childs !== null && count($childs) > 0 ) {
    		$items[$i]->childs = $childs;
    	}

    } ?>

    <ul class="<?php echo $class; ?>" id="<?php echo $id; ?>">

		<?php foreach ($items as $item) { ?>

			<?php if ($item->state == 'PUBLISHED' && $item->parent_id == 0) { ?>

			<li class="<?php echo 'item-menu-' . $class . ' item-' . $item->id; ($item->class !== null) ? ' ' . $item->class : ''; ?>" id="item-<?php echo $item->id; ?>">

				<a href="<?php echo $item->link ?>" target="<?php echo $item->target_link ?>">

					<?php if($item->icon !== null) { ?>
					<img src="<?php echo $item->icon ?>" alt="<?php echo $item->title ?>">
					<?php } ?>
					<span><?php echo $item->title; ?></span>

				</a>

				<?php if ( $item->childs && count($item->childs) > 0 ) { ?>

				<ul class="submenu" id="submenu-item-<?php echo $item->id; ?>">
					
					<?php foreach ($item->childs as $child) { ?>

					<li class="<?php echo 'item-menu-' . $class . ' item-' . $child->id; ($child->class !== null) ? ' ' . $child->class : ''; ?>" id="item-<?php echo $child->id; ?>">

						<a href="<?php echo $child->link; ?>" target="<?php echo $child->target_link; ?>">

							<?php if($child->icon !== null) { ?>
							<img src="<?php echo $child->icon; ?>" alt="<?php echo $child->title; ?>">
							<?php } ?>

							<span><?php echo $child->title; ?></span>
						</a>

					</li>

					<?php }; ?>

				</ul>

				<?php } ?>
			</li>

			<?php } ?>
			
		<?php }; ?>
		
	</ul>

	<?php

}