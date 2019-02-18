@if ($show_price)
<div class="actions">
	@if ($inventory->active_offer == '1' && $inventory->offer_price > 0)
		<p class="price">
			<span class="offer-price">{{ COPMoney($price) }}</span><br/>
			{{ COPMoney($inventory->offer_price) }}
		</p>
	@else
		<p class="price">{{ COPMoney($price) }}</p>
	@endif
	<p class="btns">
		<input type="hidden" class="book-id" value="{{ $book->id }}">
		@if ($inventory->active_offer == '1' && $inventory->offer_price > 0)
			<input type="hidden" class="book-price" value="{{ $inventory->offer_price }}">
		@else
			<input type="hidden" class="book-price" value="{{ $price }}">
		@endif
		
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