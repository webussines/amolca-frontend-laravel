@php
    $complete = explode('\\', Route::getCurrentRoute()->getActionName());
    $controller = $complete[count($complete) - 1];
    $active = explode('@', $controller)[0];

    $submenu_show = "display: block;";
@endphp

<ul class="nav-menu" id="nav-menu">
    <ul class="vmenu">

        @if (session('user')->role == 'SUPERADMIN')
            <li>
                <a data-id="books" @if ($active == 'AdminBooksController') class="actived" @endif>
                    <span class="icon icon-books"></span> <span class="text">Libros</span>
                </a>

                <ul class="submenu" data-menu="books" style="@if ($active == 'AdminBooksController') {{$submenu_show}} @endif">
                    <li><a href="/am-admin/libros">Todos los libros</a></li>
                    <li><a href="/am-admin/libros/create">Añadir libro</a></li>
                    <li><a href="/am-admin/libros/inventario">Inventario</a></li>
                </ul>
            </li>
            <li>
                <a data-id="lots" @if ($active == 'AdminLotsController') class="actived" @endif>
                    <span class="icon icon-list-alt"></span> <span class="text">Lotes de novedades</span>
                </a>

                <ul class="submenu" data-menu="lots" style="@if ($active == 'AdminLotsController') {{$submenu_show}} @endif">
                    <li><a href="/am-admin/lotes">Todos los lotes</a></li>
                    <li><a href="/am-admin/lotes/create">Añadir lote</a></li>
                </ul>
            </li>
            <li>
                <a data-id="specialties" @if ($active == 'AdminSpecialtiesController') class="actived" @endif>
                    <span class="icon icon-folder-open"></span> <span class="text">Especialidades</span>
                </a>

                <ul class="submenu" data-menu="specialties" style="@if ($active == 'AdminSpecialtiesController') {{$submenu_show}} @endif">
                    <li><a href="/am-admin/especialidades">Todos las especialidades</a></li>
                    <li><a href="/am-admin/especialidades/create">Añadir especialidad</a></li>
                </ul>
            </li>
            <li>
                <a data-id="authors" @if ($active == 'AdminAuthorsController') class="actived" @endif>
                    <span class="icon icon-profile"></span> <span class="text">Autores</span>
                </a>

                <ul class="submenu" data-menu="authors" style="@if ($active == 'AdminAuthorsController') {{$submenu_show}} @endif">
                    <li><a href="/am-admin/autores">Todos los autores</a></li>
                    <li><a href="/am-admin/autores/create">Añadir autor</a></li>
                </ul>
            </li>
            <li>
                <a data-id="sliders" @if ($active == 'AdminSlidersController') class="actived" @endif>
                    <span class="icon icon-images"></span> <span class="text">Sliders</span>
                </a>

                <ul class="submenu" data-menu="sliders" style="@if ($active == 'AdminSlidersController') {{$submenu_show}} @endif">
                    <li><a href="/am-admin/sliders">Todos los slider</a></li>
                    <li><a>Añadir slider</a></li>
                </ul>
            </li>
        @endif

        @if (session('user')->role == 'SUPERADMIN' || session('user')->role == 'ADMIN')
            <li>
                <a data-id="coupons" @if ($active == 'AdminCouponsController') class="actived" @endif>
                    <span class="icon icon-price-tags"></span> <span class="text">Cupones</span>
                </a>

                <ul class="submenu" data-menu="coupons" style="@if ($active == 'AdminCouponsController') {{$submenu_show}} @endif">
                    <li><a>Todos los cupones</a></li>
                    <li><a>Añadir cupón</a></li>
                </ul>
            </li>
            
            <li>
                <a data-id="orders" @if ($active == 'AdminOrdersController') class="actived" @endif>
                    <span class="icon icon-database"></span> <span class="text">Pedidos</span>
                </a>

                <ul class="submenu" data-menu="orders" style="@if ($active == 'AdminOrdersController') {{$submenu_show}} @endif">
                    <li><a href="/am-admin/pedidos">Ver pedidos</a></li>
                    <li><a href="/am-admin/carritos">Carritos de compra</a></li>
                </ul>
            </li>

            <li>
                <a data-id="blog" @if ($active == 'AdminBlogsController') class="actived" @endif>
                    <span class="icon icon-newspaper"></span> <span class="text">Blog</span>
                </a>

                <ul class="submenu" data-menu="blog" style="@if ($active == 'AdminBlogsController') {{$submenu_show}} @endif">
                    <li><a href="/am-admin/blog">Ver publicaciones</a></li>
                    <li><a href="/am-admin/blog/create">Añadir publicación</a></li>
                </ul>
            </li>

            <li>
                <a data-id="form" @if ($active == 'AdminFormsController') class="actived" @endif>
                    <span class="icon icon-contacts"></span> <span class="text">Formularios</span>
                </a>

                <ul class="submenu" data-menu="form" style="@if ($active == 'AdminFormsController') {{$submenu_show}} @endif">
                    <li><a href="/am-admin/formularios">Ver formularios</a></li>
                </ul>
            </li>
        @endif

        @if (session('user')->role == 'SUPERADMIN')
            <li>
                <a data-id="users" @if ($active == 'AdminUsersController') class="actived" @endif>
                    <span class="icon icon-users"></span> <span class="text">Usuarios</span>
                </a>

                <ul class="submenu" data-menu="users" style="@if ($active == 'AdminUsersController') {{$submenu_show}} @endif">
                    <li><a href="/am-admin/usuarios">Ver todos los usuarios</a></li>
                    <li><a href="/am-admin/clientes">Ver clientes</a></li>
                    <li><a>Direcciones</a></li>
                    <li><a href="/am-admin/usuarios/create">Añadir usuario</a></li>
                </ul>
            </li>
        @endif

        <li>
            <a data-id="settings" @if ($active == 'AdminSettingsController') class="actived" @endif>
                <span class="icon icon-equalizer"></span> <span class="text">Ajustes</span>
            </a>

            <ul class="submenu" data-menu="settings" style="@if ($active == 'AdminSettingsController') {{$submenu_show}} @endif">
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