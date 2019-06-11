@php
	$active = explode('@', Route::getCurrentRoute()->getActionName())[1];
@endphp

<ul class="vmenu">
	<li @if ($active == 'account') class="active" @endif>
		<a class="waves-effect waves-light" href="/mi-cuenta">
			<span class="icon-user-outline"></span> Escritorio
		</a>
	</li>
	<li @if ($active == 'orders') class="active" @endif>
		<a class="waves-effect waves-light" href="/mi-cuenta/pedidos">
			<span class="icon-document-text"></span> Pedidos
		</a>
	</li>
	<li @if ($active == 'direction') class="active" @endif>
		<a class="waves-effect waves-light" href="/mi-cuenta/direccion">
			<span class="icon-location-outline"></span> Direcci&oacute;n
		</a>
	</li>
	<li @if ($active == 'information') class="active" @endif>
		<a class="waves-effect waves-light" href="/mi-cuenta/informacion">
			<span class="icon-cog-outline"></span> Mi informaci&oacute;n
		</a>
	</li>
	<li>
		<a class="waves-effect waves-light" id="go-to-sws" data-user-email="{!! session('user')->email !!}">
			<span class="icon-books"></span> Biblioteca virtual
		</a>
	</li>
	<li>
		<a class="waves-effect waves-light" href="/logout">
			<span class="icon-exit"></span> Cerrar sesi&oacute;n
		</a>
	</li>
</ul>
