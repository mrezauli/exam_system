@extends('admin::layouts.master')
@section('sidebar')
@parent
@include('admin::layouts.sidebar')
@stop

@section('content')

<!-- page start-->


@if($errors->any())
<ul class="alert alert-danger">
    @foreach($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
</ul>
@endif
@if(Session::has('error'))
<div class="alert alert-danger">
    <p>{{ Session::get('error') }}</p>
</div>
@endif

<div class="modal-header">
    <h4 class="modal-title" id="myModalLabel"> {{ $page_title }} </h4>
</div>


<div class="page-inner-wrapper create-contact-page">

    @include('admin::exam_code._form')

</div>
@stop