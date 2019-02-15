@if ($show_price)
<div class="actions">
	<p class="price">{{ COPMoney($price) }}</p>
	<p class="btns">
		<input type="hidden" class="book-id" value="{{ $book->id }}">
		<input type="hidden" class="book-price" value="{{ $price }}">
		
		@if (get_option('shop_catalog_mode') != 'SI')
			<a class="cart-btn tooltipped" data-position="top" data-tooltip="Añadir al carrito">
				<span class="icon-add_shopping_cart"></span>
			</a>
			<a class="hearth-btn tooltipped" data-position="top" data-tooltip="Añadir a mi lista de deseos">
				<span class="icon-heart-outline"></span>
			</a>
		@endif
	</p>
</div>
@endif