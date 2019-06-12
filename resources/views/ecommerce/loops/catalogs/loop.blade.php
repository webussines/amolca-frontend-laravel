@php
	$type = (isset($type)) ? $type : 'loop';
	$items_per_row = (isset($items_per_row)) ? $items_per_row : 2;
	$show_links = (isset($show_links)) ? $show_links : 'si';
    $btn_text = (isset($btn_text)) ? $btn_text : 'Descargar catálogo';
@endphp

<div class="catalogs-list">
    @for ($i = 0; $i < count($catalogs); $i++)
        @php
        $catalog = $catalogs[$i];
        $pdf = '#';

        foreach ($catalog->meta as $key => $value) {

            switch ($value->key) {
                case 'catalog_pdf_url':
                        $pdf = $value->value;
                    break;
            }

        }
        @endphp

        <div class="item">
            <a @if($pdf != '#') href="{!! $pdf !!}" target="_blank" @endif>
                <img src="{!! $catalog->thumbnail !!}" alt="Descargar catalogo de {!! $catalog->title !!}">
            </a>
            <h2 class="title">{!! $catalog->title !!}</h2>
            <p>
                <a class="button primary" @if($pdf != '#') href="{!! $pdf !!}" target="_blank" @endif><?php echo $btn_text; ?></a>
            </p>
        </div>
    @endfor

    @if( count($catalogs) < 1)

        <h2 class="center">Lo sentimos. No hay catálogos de la especialidad: {!! $specialty !!}</h2>

    @endif
</div>
