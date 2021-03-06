@extends('admin.layouts.account')

@section('title', 'Todos los carritos de compra - Admin Amolca')

@section('styles')
<link rel="stylesheet" href="{{ asset('libs/datatables/css/jquery.dataTables.min.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('js/admin/orders/carts.js') }}"></script>
<script src="{{ asset('libs/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('libs/datatables/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('libs/datatables/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('libs/datatables/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('libs/datatables/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('libs/datatables/js/jszip.min.js') }}"></script>
@endsection

@section('contentClass', 'all-carts')
@section('content')

    <div class="loader hidde">
        <div class="progress">
            <div class="indeterminate"></div>
        </div>
    </div>

    <input type="hidden" id="_token" value="{{ csrf_token() }}">

    <table class="table data-table carts">
        <thead>
            <tr>
                <th class="image">ID.</th>
                <th class="country">Pa&iacute;s:</th>
                <th class="products"># de productos:</th>
                <th class="state">Estado:</th>
                <th class="actions"></th>
            </tr>
        </thead>

        <tbody>
        </tbody>

        <tfoot>
            
        </tfoot>
    </table>

@endsection