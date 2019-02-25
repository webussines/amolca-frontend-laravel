<div class="header" id="header">

    <p class="site-title">Amolca {{  get_option('sitecountry') }}</p>

    <a class="view-site-btn" href="/" target="_blank">Ver sitio</a>
    
    <a class="user-btn dropdown-btn" data-target="user-menu-dropdown">
        <span class="icon-user"></span> {{ session('user')->name }} {{ session('user')->lastname }}
    </a>

    <ul id="user-menu-dropdown" class="user-menu dropdown-content">
        <li><a href="/am-admin/mi-cuenta">Mi cuenta</a></li>
        <li><a href="/am-admin/logout">Cerrar sesión</a></li>
    </ul>

</div>