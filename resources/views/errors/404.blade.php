@extends('front.partials.layout', [ 'view' => 'error404' ])

@section('content')

@include('front.partials.error', ['title'=>'PAGE NOT FOUND', 'message'=>__('front.error.desc')])

@endsection
