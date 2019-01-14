<header class="header">

	<div class="site-logo">
		<a href="/">
			<img src="{{ asset('img\common\logo.png') }}" alt="Amolca" >
		</a>
	</div>

	<div id="nav-menu">
		<a id="login-btn" class="waves-effect waves-light view-mobile" href="/iniciar-sesion">
			<i class="icon-person"></i>
		</a>

		<div class="mobile-btn" id="mobile-btn"><span></span></div>

		<?php get_nav_menu('menu-principal', 'hmenu'); ?>
	</div>
</header>