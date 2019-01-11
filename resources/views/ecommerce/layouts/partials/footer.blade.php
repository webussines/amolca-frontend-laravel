	<div class="footer">
		<div class="custom-row">
			<div class="custom-col block-contact" id="block-principal">
				<p class="title">Casa Matriz</p>
				<p><span id="direction">
					<a href="{{ get_option('casa_matriz_address_link') }}" target="_blank">
						{!! get_option('casa_matriz_address') !!}
					</a>
				</span></p>
				<p><span id="mobile">
					<a href="{{ get_option('casa_matriz_phone_link') }}">
						{!! get_option('casa_matriz_phone') !!}
					</a>
				</span></p>
				<p><span id="email">
					<a href="mailto:{{ get_option('casa_matriz_email') }}">
						{!! get_option('casa_matriz_email') !!}
					</a>
				</span></p>
			</div>
			<div class="custom-col" id="block-about">
				<p class="title">Acerca de</p>
				<p>
					<a href="/amolca">Amolca</a>
				</p>
				<p>
					<a href="/novedades">Novedades</a>
				</p>
				<p>
					<a href="/eventos">Eventos</a>
				</p>
				<p>
					<a href="/terminos-y-condiciones">Términos y condiciones</a>
				</p>
				<p>
					<a href="/politicas-de-privacidad">Políticas de privacidad</a>
				</p>
			</div>
			<div class="custom-col" id="block-help">
					<p class="title">Ayuda</p>
					<p>
						<a href="/como-comprar">¿Cómo comprar?</a>
					</p>
					<p>
						<a href="/preguntas-frecuentes">Preguntas frecuentes</a>
					</p>
					<p>
						<a href="/terminos-y-condiciones/%23envios">Información de envío</a>
					</p>
					<p>
						<a href="/terminos-y-condiciones/%23pagos">Medios de pago</a>
					</p>
					<p>
						<a href="/contacto">Contacto</a>
					</p>
				</div>
				<div class="custom-col block-contact" id="block-country">
					<p class="title">Amolca Colombia</p>
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
					<p>
						<span id="email">
							<a href="mailto:{{ get_option('amolca_email') }}">
								{!! get_option('amolca_email') !!}
							</a>
						</span>
					</p>
				</div>
			</div>
		</div>


	</body>
</html>