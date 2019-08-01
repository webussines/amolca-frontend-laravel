@extends('ecommerce.layouts.site')

@section('title', 'Respuesta medio de pago - Amolca Editorial Médica y Odontológica')

<!--Add checkout styles-->
@section('styles')
<link rel="stylesheet" href="{{ asset('css/ecommerce/checkout.css') }}">
@endsection

@section('contentClass', 'payment-response')
@section('content')

	<table class="payment-response striped">
		<thead>
			<tr>
				<th colspan="2">Respuesta de pago - Pedido # {{ $response['orden_id'] }}</th>
			</tr>
		</thead>

		<tbody>

			@if ( isset($response['error_code']) )
				<tr class="authorization_code code_{{ $response['error_code'] }}">
					<th>
						Código de error:
					</th>
					<td>
						{{ $response['error_code'] }}
					</td>
				</tr>
			@endif

			@if ( isset($response['error_message']) )
				<tr class="response_text">
					<th>
						Respuesta de transacción:
					</th>
					<td>
						{{ $response['error_message'] }}
					</td>
				</tr>
			@endif

			@if ( isset($response['error_motive']) )
				<tr class="response_text">
					<th>
						Motivo de la denegación:
					</th>
					<td>
						{{ $response['error_motive'] }}
					</td>
				</tr>
			@endif

			@if ( isset($response['orden_id']) )
				<tr>
					<th>
						Referencía única del pedido:
					</th>
					<td>
						{{ $response['orden_id'] }}
					</td>
				</tr>
			@endif

			@if ( isset($response['transaction_date']) )
				<tr>
					<th>
						Fecha y hora de la transacción:
					</th>
					<td>
						@php
						$timestamp=(int) $response['transaction_date'] / 1000;
						@endphp
						{{ print_r(date('j F, Y', $timestamp)) }}
					</td>
				</tr>
			@endif

			@if ( isset($response['transaction_id']) )
				<tr>
					<th>
						Número ID de la transacción:
					</th>
					<td>
						{{ $response['transaction_id'] }}
					</td>
				</tr>
			@endif

			<tr class="finish-row">
				<td colspan="2">
					<a href="/" class="button primary">Regresar al inicio</a>
				</td>
			</tr>

		</tbody>

	</table>

@endsection
