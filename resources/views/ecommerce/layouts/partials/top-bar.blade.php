<div class="top-bar">
	<div id="social-top-bar">
		<ul class="social-networks top">
			<li >
				<a target="_blank" href="#" class="waves-effect waves-light bg-blue">
					<i class="icon-facebook1"></i>
				</a>
			</li>
			<li >
				<a target="_blank" href="#" class="waves-effect waves-light bg-blue">
					<i class="icon-instagram1"></i>
				</a>
			</li>
			<li >
				<a target="_blank" href="#" class="waves-effect waves-light bg-blue">
					<i class="icon-twitter1"></i>
				</a>
			</li>
		</ul>
	</div>
	<ul id="top-bar-btns">
		<li>
			<a class="waves-effect waves-light" id="cart-btn" routerlink="/carrito" href="/carrito">
				<i class="icon-shopping-cart1"></i>
				<span>$0.000</span>
			</a>
		</li>
		@if ( session('user') === null )
			<li>
				<a id="login-btn" routerlink="/iniciar-sesion" class="waves-effect waves-light normal" href="/iniciar-sesion">
					<i class="icon-person"></i>
					<span>Inicar sesión</span>
				</a>
			</li>
		@else
			<li>
				<a id="login-btn dropdown-btn" class="dropdown-btn" data-target="user-menu-dropdown">
					<i class="icon-person"></i>
					<span>{{ session('user')->name }}</span>
				</a>
				<ul id="user-menu-dropdown" class="user-menu dropdown-content">
			        <li><a href="/mi-cuenta">Mi cuenta</a></li>
			        <li><a href="/logout">Cerrar sesión</a></li>
			    </ul>
			</li>
		@endif

	</ul>
</div>