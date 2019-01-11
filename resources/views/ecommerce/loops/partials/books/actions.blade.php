@if ($show_price)
<p class="price">@COPMoney($price)</p>
<p class="btns">
	<a class="cart-btn tooltipped" data-position="top" data-tooltip="Añadir al carrito">
		<span class="icon-add_shopping_cart"></span>
	</a>
	<a class="hearth-btn tooltipped" data-position="top" data-tooltip="Añadir a mi lista de deseos">
		<span class="icon-heart-outline"></span>
	</a>
</p>
@else
<p class="btns">
	<a class="hearth-btn tooltipped" data-position="top" data-tooltip="Añadir a mi lista de deseos">
		<span class="icon-heart-outline"></span> Lista de deseos
	</a>
</p>
@endif