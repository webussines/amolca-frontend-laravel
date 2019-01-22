<div class="top-bar">
	<div id="social-top-bar">
		<ul class="social-networks top">
			<li >
				<a target="_blank" href="https://www.facebook.com/EdAmolca/" class="waves-effect waves-light bg-blue">
					<i class="icon-facebook1"></i>
				</a>
			</li>
			<li >
				<a target="_blank" href="https://www.instagram.com/amolcacolombia/" class="waves-effect waves-light bg-blue">
					<i class="icon-instagram1"></i>
				</a>
			</li>
			<li >
				<a target="_blank" href="https://twitter.com/EAmolca" class="waves-effect waves-light bg-blue">
					<i class="icon-twitter1"></i>
				</a>
			</li>
		</ul>
	</div>
	<ul id="top-bar-btns">
		<li>
			<a class="waves-effect waves-light" id="cart-btn" routerlink="/carrito" href="/carrito">
				<i class="icon-shopping-cart1"></i>
				@if (session('cart') !== null)
					<span>{{ COPMoney(session('cart')->amount) }}</span>
				@else
					<span>{{ COPMoney(0) }}</span>
				@endif
			</a>
		</li>
		@if ( session('user') === null )
			<li>
				<a id="login-btn" href="/iniciar-sesion">
					<i class="icon-person"></i>
					<span>Iniciar sesi&oacute;n</span>
				</a>
			</li>
		@else
			<li>
				<a id="login-btn" class="dropdown-btn" data-target="user-menu-dropdown">
					<i class="icon-person"></i>
					<span>{{ session('user')->name }}</span>
				</a>
				<ul id="user-menu-dropdown" class="user-menu dropdown-content">
			        <li><a href="/mi-cuenta">Mi cuenta</a></li>
			        <li><a href="/logout">Cerrar sesi&oacute;n</a></li>
			    </ul>
			</li>
		@endif

		<li>
			<a id="contact" href="/contacto">
				<span class="icon-envelope"></span> Contacto
			</a>
		</li>

	</ul>
</div>