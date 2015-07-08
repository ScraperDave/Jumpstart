@extends('app')

@section('content')
    <div class="container">
        <h1 class="page-header">Laravel 5</h1>
        <blockquote class="quote">{{ Inspiring::quote() }}</blockquote>
    </div>
@stop
