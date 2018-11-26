@extends('layouts.site')

@section('title', 'Amolca Editorial Médica y Odontológica')

@section('contentClass', 'home')
@section('content')

<div class="searcher-block">
	@include('layouts.partials.big-searcher')
</div>

<div class="content-block books-block">
	<div class="row">
		<div class="col s12 l6 col-left">
			<h2 class="title">
				<span>Novedades</span> Médicas
			</h2>

			<div class="books-loop items-per-page-2">
				<div class="item">
					<a class="contain-img" href="/libro/intervencion-cardiovascular">
						<img alt="" src="https://amolca.webussines.com/uploads/books/40.png">
					</a>
					<div class="versions">
						<a class="version-btn tooltipped" data-position="top" data-tooltip="Papel">
							<span class="icon-book"></span>
						</a>
					</div>
					<div class="info">
						<h3 class="name">
						<a href="/libro/intervencion-cardiovascular">Intervención Cardiovascular</a></h3>
						<p class="authors">
							<span>
								<a href="/autor/deepak-l-bhatt">Deepak L. Bhatt </a>
							</span>
						</p>
						<div class="actions">
							<p class="price">$920.000</p>
							<p class="btns">
								<a class="cart-btn tooltipped" data-position="top" data-tooltip="Añadir al carrito">
									<span class="icon-add_shopping_cart"></span>
								</a>
								<a class="hearth-btn tooltipped" data-position="top" data-tooltip="Añadir a mi lista de deseos">
									<span class="icon-heart-outline"></span>
								</a>
							</p>
						</div>
					</div>
				</div>
				<div class="item">
					<a class="contain-img" href="/libro/maestria-en-cirugia-cardiotoracica-tercera-edicion">
						<img alt="" src="https://amolca.webussines.com/uploads/books/50.png">
					</a>
					<div class="versions">
						<a class="version-btn tooltipped" data-position="top" data-tooltip="Papel">
							<span class="icon-book"></span>
						</a>
					</div>
					<div class="info">
						<h3 class="name">
							<a href="/libro/maestria-en-cirugia-cardiotoracica-tercera-edicion">Maestría en Cirugía Cardiotorácica / Tercera Edición</a>
						</h3>
						<p class="authors">
							<span>
								<a href="/autor/larry-r-kaiser">Larry R. Kaiser</a>
							</span>
						</p>
						<div class="actions">
							<p class="price">$1.395.000</p>
							<p class="btns">
								<a class="cart-btn tooltipped" data-position="top" data-tooltip="Añadir al carrito">
									<span class="icon-add_shopping_cart"></span>
								</a>
								<a class="hearth-btn tooltipped" data-position="top" data-tooltip="Añadir a mi lista de deseos">
									<span class="icon-heart-outline"></span>
								</a>
							</p>
						</div>
					</div>
				</div>
			</div>

		</div>
		<div class="col s12 l6 col-right">
			<h2 class="title">
				<span>Novedades</span> odontológicas
			</h2>

			<div class="books-loop items-per-page-2">
				<div class="item">
					<a class="contain-img" href="/libro/tecnicas-quirurgicas-de-colon-y-recto">
						<img alt="" src="https://amolca.webussines.com/uploads/books/66.png">
					</a>
					<div class="versions">
						<a class="version-btn tooltipped" data-position="top" data-tooltip="Papel">
							<span class="icon-book"></span>
						</a>
					</div>
					<div class="info">
						<h3 class="name">
						<a href="/libro/tecnicas-quirurgicas-de-colon-y-recto">Técnicas Quirúrgicas de Colon y Recto</a></h3>
						<p class="authors">
							<span>
								<a href="/autor/daniel-albo">Daniel Albo </a>
							</span>
						</p>
						<div class="actions">
							<p class="price">$665.000</p>
							<p class="btns">
								<a class="cart-btn tooltipped" data-position="top" data-tooltip="Añadir al carrito">
									<span class="icon-add_shopping_cart"></span>
								</a>
								<a class="hearth-btn tooltipped" data-position="top" data-tooltip="Añadir a mi lista de deseos">
									<span class="icon-heart-outline"></span>
								</a>
							</p>
						</div>
					</div>
				</div>
				<div class="item">
					<a class="contain-img" href="/libro/manejo-de-las-imagenes-en-la-practica-quirurgica-generalidades-paredes-y-tubo-digestivo">
						<img alt="" src="https://amolca.webussines.com/uploads/books/79.png">
					</a>
					<div class="versions">
						<a class="version-btn tooltipped" data-position="top" data-tooltip="Papel">
							<span class="icon-book"></span>
						</a>
					</div>
					<div class="info">
						<h3 class="name">
						<a href="/libro/manejo-de-las-imagenes-en-la-practica-quirurgica-generalidades-paredes-y-tubo-digestivo">Manejo de las Imágenes en la Práctica Quirúrgica / Generalidades, paredes y tubo digestivo</a></h3>
						<p class="authors">
							<span>
								<a href="/autor/guillermo-e-duza">Guillermo E. Duza</a>
							</span>
						</p>
						<div class="actions">
							<p class="price">$614.000</p>
							<p class="btns">
								<a class="cart-btn tooltipped" data-position="top" data-tooltip="Añadir al carrito">
									<span class="icon-add_shopping_cart"></span>
								</a>
								<a class="hearth-btn tooltipped" data-position="top" data-tooltip="Añadir a mi lista de deseos">
									<span class="icon-heart-outline"></span>
								</a>
							</p>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>

<div class="content-block authors-block">
	<h2 class="title">
		Autores <span class="color-blue-light">destacados</span>
	</h2>
</div>

@endsection