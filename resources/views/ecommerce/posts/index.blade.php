@extends('ecommerce.layouts.site')

@section('title', "Blog - Amolca Editorial Médica y Odontológica")

@section('contentClass', 'page-container blog-index')
@section('content')
<div class="section-title">
	<h2>Blog Amolca</h2>
</div>

<div class="content-container">

	@include('ecommerce.loops.posts.loop', ['posts' => $posts, 'type' => 'loop', 'items_per_row' => 4])

</div>
@endsection