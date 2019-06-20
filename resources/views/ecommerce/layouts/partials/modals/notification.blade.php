<div id="notification-modal" class="modal open">
    <div class="modal-content">
        <p id="resp-icon">
            <a class="check"><span class="icono icon-check1"></span></a>
        </p>
        <p id="resp-text">Se agregó correctamente el libro <b>Fracturas de hombro</b> a tu carrito de compras.</p>
        <p id="resp-desc">Este mensaje desaparecerá en unos segundos...</p>

        @if (get_option('sitecountry') == 'PERU')
            <form id="visanet-payment-form" class="" action="/checkout/response" method="post"></form>
        @endif

        <p id="resp-buttons"><a href="/carrito" class="button primary">Ver carrito</a> <a class="modal-close button gray">Cerrar</a></p>
    </div>
</div>
