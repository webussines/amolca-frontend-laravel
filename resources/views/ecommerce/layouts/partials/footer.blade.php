	<div class="footer">
		<div class="custom-row">
			<div class="custom-col block-contact" id="block-principal">
				<p class="title">Casa Matriz</p>
				<p><span id="direction">
					<a href="{{ get_option('casa_matriz_address_link') }}" target="_blank">
						{!! get_option('casa_matriz_address') !!}
					</a>
				</span></p>
				@if(get_option('casa_matriz_phone') !== null && get_option('casa_matriz_phone') !== 'NULL')
				<p><span id="mobile">
					<a href="{{ get_option('casa_matriz_phone_link') }}">
						{!! get_option('casa_matriz_phone') !!}
					</a>
				</span></p>
				@endif
				<p><span id="email">
					<a href="mailto:{{ get_option('casa_matriz_email') }}">
						{!! get_option('casa_matriz_email') !!}
					</a>
				</span></p>
			</div>
			<div class="custom-col" id="block-about">
				<p class="title">Acerca de</p>
				<p>
					<a>Amolca</a>
				</p>
				<p>
					<a>Novedades</a>
				</p>
				<p>
					<a>Eventos</a>
				</p>
				<p>
					<a href="/terminos-y-condiciones">Términos y condiciones</a>
				</p>
				<p>
					<a href="/terminos-y-condiciones#privacidad">Políticas de privacidad</a>
				</p>
			</div>
			<div class="custom-col" id="block-help">
					<p class="title">Ayuda</p>
					<p>
						<a>¿Cómo comprar?</a>
					</p>
					<p>
						<a>Preguntas frecuentes</a>
					</p>
					<p>
						<a href="/terminos-y-condiciones#envios">Información de envío</a>
					</p>
					<p>
						<a href="/terminos-y-condiciones#pagos">Medios de pago</a>
					</p>
					<p>
						<a href="/contacto">Contacto</a>
					</p>
				</div>
				
				@if (get_option('sitecountry') !== 'CASA MATRIZ')
					<div class="custom-col block-contact" id="block-country">
						<p class="title">Amolca {!! strtolower( get_option('sitecountry') ) !!}</p>
						<p>
							<span id="direction">
								<a href="{{ get_option('amolca_address_link') }}" target="_blank">
									{!! get_option('amolca_address') !!}
								</a>
							</span>
						</p>
						<p>
							<span id="mobile">
								<a href="{{ get_option('amolca_phone_link') }}">
									{!! get_option('amolca_phone') !!}
								</a>
							</span>
						</p>
						@if(get_option('amolca_phone_fixed') !== null && get_option('amolca_phone_fixed') !== 'NULL')
	    				<p><span id="mobile">
	    					<a href="{{ get_option('amolca_phone_fixed_link') }}">
	    						{!! get_option('amolca_phone_fixed') !!}
	    					</a>
	    				</span></p>
	    				@endif
						<p>
							<span id="email">
								<a href="mailto:{{ get_option('amolca_email') }}">
									{!! get_option('amolca_email') !!}
								</a>
							</span>
						</p>
					</div>
				@endif
				
			</div>
		</div>


	</body>
</html>