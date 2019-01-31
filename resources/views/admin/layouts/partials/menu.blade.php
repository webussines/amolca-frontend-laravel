<ul class="nav-menu" id="nav-menu">
    <ul class="vmenu">

        @if (session('user')->role == 'SUPERADMIN')
            <li>
                <a data-id="books">
                    <span class="icon icon-books"></span> <span class="text">Libros</span>
                </a>

                <ul class="submenu" data-menu="books">
                    <li><a href="/am-admin/libros">Todos los libros</a></li>
                    <li><a href="/am-admin/libros/create">Añadir libro</a></li>
                    <li><a href="/am-admin/libros/inventario">Inventario</a></li>
                </ul>
            </li>
            <li>
                <a data-id="specialties">
                    <span class="icon icon-folder-open"></span> <span class="text">Especialidades</span>
                </a>

                <ul class="submenu" data-menu="specialties">
                    <li><a href="/am-admin/especialidades">Todos las especialidades</a></li>
                    <li><a href="/am-admin/especialidades/create">Añadir especialidad</a></li>
                </ul>
            </li>
            <li>
                <a data-id="authors">
                    <span class="icon icon-profile"></span> <span class="text">Autores</span>
                </a>

                <ul class="submenu" data-menu="authors">
                    <li><a href="/am-admin/autores">Todos los autores</a></li>
                    <li><a href="/am-admin/autores/create">Añadir autor</a></li>
                </ul>
            </li>
            <li>
                <a data-id="sliders">
                    <span class="icon icon-images"></span> <span class="text">Sliders</span>
                </a>

                <ul class="submenu" data-menu="sliders">
                    <li><a href="/am-admin/sliders">Todos los slider</a></li>
                    <li><a>Añadir slider</a></li>
                </ul>
            </li>
        @endif

        @if (session('user')->role == 'SUPERADMIN' || session('user')->role == 'ADMIN')
            <li>
                <a data-id="coupons">
                    <span class="icon icon-price-tags"></span> <span class="text">Cupones</span>
                </a>

                <ul class="submenu" data-menu="coupons">
                    <li><a>Todos los cupones</a></li>
                    <li><a>Añadir cupón</a></li>
                </ul>
            </li>
            
            <li>
                <a data-id="orders">
                    <span class="icon icon-database"></span> <span class="text">Pedidos</span>
                </a>

                <ul class="submenu" data-menu="orders">
                    <li><a href="/am-admin/pedidos">Ver pedidos</a></li>
                    <li><a href="/am-admin/carritos">Carritos de compra</a></li>
                </ul>
            </li>

            <li>
                <a data-id="blog">
                    <span class="icon icon-newspaper"></span> <span class="text">Blog</span>
                </a>

                <ul class="submenu" data-menu="blog">
                    <li><a href="/am-admin/blog">Ver publicaciones</a></li>
                    <li><a href="/am-admin/blog/create">Añadir publicación</a></li>
                </ul>
            </li>

            <li>
                <a data-id="form">
                    <span class="icon icon-contacts"></span> <span class="text">Formularios</span>
                </a>

                <ul class="submenu" data-menu="form">
                    <li><a href="/am-admin/formularios">Ver formularios</a></li>
                </ul>
            </li>
        @endif

        @if (session('user')->role == 'SUPERADMIN')
            <li>
                <a data-id="users">
                    <span class="icon icon-users"></span> <span class="text">Usuarios</span>
                </a>

                <ul class="submenu" data-menu="users">
                    <li><a href="/am-admin/usuarios">Ver todos los usuarios</a></li>
                    <li><a href="/am-admin/clientes">Ver clientes</a></li>
                    <li><a>Direcciones</a></li>
                    <li><a href="/am-admin/usuarios/create">Añadir usuario</a></li>
                </ul>
            </li>
        @endif

        <li>
            <a data-id="settings">
                <span class="icon icon-equalizer"></span> <span class="text">Ajustes</span>
            </a>

            <ul class="submenu" data-menu="settings">
                <li><a href="/am-admin/ajustes">Ajustes generales</a></li>

                @if (session('user')->role == 'SUPERADMIN')
                    <li><a>Plantilla</a></li>
                @endif
            </ul>
        </li>

        <li>
            <a href="/am-admin/logout">
                <span class="icon icon-exit"></span> <span class="text">Cerrar sesión</span>
            </a>
        </li>
    </ul>
</ul>