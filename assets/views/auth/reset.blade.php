@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Reset Password</div>
                    <div class="panel-body">
                        {!! Form::bs_open(['route' => 'password-reset', 'class' => 'form-horizontal', 'role' => 'form'], $errors, 4, 6) !!}
                        {!! Form::hidden('token', $token) !!}
                        {!! Form::bs_email('E-Mail Address', 'email', old('email'), ['class' => 'form-control']) !!}
                        {!! Form::bs_password('Password', 'password', ['class' => 'form-control']) !!}
                        {!! Form::bs_password('Confirm Password', 'password_confirmation', ['class' => 'form-control']) !!}
                        {!! Form::bs_submit('Reset Password', null, ['class' => 'btn btn-primary']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
