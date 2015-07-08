@extends('app')

@section('content')
<html>
	<head>
		<title>Laravel</title>


		<style>
			.content {
                color: #B0BEC5;
				text-align: center;
                font-weight: 100;
                font-family: 'Lato';
			}

			.title {
				font-size: 96px;
				margin-bottom: 40px;
			}

			.quote {
				font-size: 24px;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="content">
				<div class="title">Laravel 5</div>
				<div class="quote">{{ Inspiring::quote() }}</div>
			</div>
		</div>
	</body>
</html>
@stop
