<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Glogbal Fashion Group API</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    GFG
                </div>
                <div class="middle-center links">
                    {!! Form::open(array('url' => '/')) !!}
                    <h1>Login</h1>

                    <!-- if there are login errors, show them here -->
                    <p>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    </p>
                    <div class="container">
                    <p>
                        {{ Form::label('email', 'E-mail') }}<br>
                        {{ Form::text('email', Input::old('email'), array('placeholder' => 'awesome@awesome.com')) }}
                    </p>

                    <p>
                        {{ Form::label('password', 'Password') }}<br>
                        {{ Form::password('password') }}
                    </p>

                    <p>{{ Form::submit('Submit', ['class' => 'btn btn-default'])  }}</p>
                    {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
