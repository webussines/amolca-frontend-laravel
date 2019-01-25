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
			<span class="icon-location-outline"></span> Dirección
		</a>
	</li>
	<li @if ($active == 'information') class="active" @endif>
		<a class="waves-effect waves-light" href="/mi-cuenta/informacion">
			<span class="icon-cog-outline"></span> Mi información
		</a>
	</li>
	<li>
		<a class="waves-effect waves-light" href="/logout">
			<span class="icon-exit"></span> Cerrar sesión
		</a>
	</li>
</ul>