@extends('admin.layouts.account')

@section('title', 'Autor: ' . $author->name . ' - Admin Amolca')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin/single-author.css') }}">
<link rel="stylesheet" href="{{ asset('libs/select2/css/select2.min.css') }}">
@endsection

@section('scripts')
<script src='https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=1icfygu7db6ym5ibmufjkk2myppelx6v827sc9rq8xt1eo2n'></script>
<script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('js/admin/single-author.js') }}"></script>
@endsection

@section('contentClass', 'single single-author')
@section('content')

    <div class="loader hidde">
        <div class="progress">
            <div class="indeterminate"></div>
        </div>
    </div>

    <div class="fixed-action-btn">
        <a class="btn-floating btn-large green save-resource">
            <span class="icon-save1"></span>
        </a>
        <a class="btn-floating btn-large red go-all-resources" href="/am-admin/autores">
            <span class="icon-cross"></span>
        </a>
    </div>

    <div class="row single section-header valign-wrapper">
		<div class="col s12 m10 l10">
			<p class="title"> {{$author->name}} </p>
		</div>
		<div class="col s12 m2 l2 actions">
            <a class="btn-floating btn-large green save-resource">
                <span class="icon-save1"></span>
            </a>
            <a class="btn-floating btn-large red go-all-resources" href="/am-admin/autores">
                <span class="icon-cross"></span>
            </a>
		</div>
	</div>
@endsection