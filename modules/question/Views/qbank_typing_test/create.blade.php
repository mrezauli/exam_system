@extends('admin::layouts.master')
@section('sidebar')
@parent
@include('admin::layouts.sidebar')
@stop

@section('content')

<!-- page start-->

<div class="inner-wrapper create-contact-page">

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


    <header class="panel-heading">
    
        {{ $page_title }}

        <a href="{{route('qbank-typing-test')}}" class="btn btn-default pull-right" data-placement="top" data-content="click close button for close this entry form">Back</a>

    </header>


    {!! Form::open(['route' => 'store-qbank-typing-test','id' => 'jq-validation-form','class' => 'default-form typing-test-form mt-30']) !!}

    @include('question::qbank_typing_test._form')
    {!! Form::close() !!}
</div>
@stop

