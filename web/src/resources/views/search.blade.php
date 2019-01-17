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
                height: 100%;
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
                font-size: 72px;
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

            form label {font-weight:bold}

            #header {
                font-size: 20px;
                margin-bottom: 0px;
                margin-top: 0px;
                margin-left: 10px;
                min-height: 30px !important;
            }

            .divTable{
                display: table;
                width: 100%;
            }
            .divTableRow {
                display: table-row;
            }
            .divTableHeading {
                background-color: #EEE;
                display: table-header-group;
            }
            .divTableCell, .divTableHead {
                display: table-cell;
                padding: 3px 10px;
                font-weight: bold;
            }
            .divTableBody {
                display: table-row-group;
            }

            .wrapper div {
            min-height: 100%;
            padding: 10px;
            }

            select.picker option:first-child {
                color: gray;
            }

            .input_number {
                width: 100px !important;
            }

        </style>
    </head>
    <body>

<div class="wrapper">
    <div class="divTable">
        <div class="divTableBody">
            <div class="divTableRow">
                <div id="header" class="divTableCell">
                    GFG Products Search
                </div>
                <div class="divTableCell">
                    <!-- Info: -->
                    <ul style="font-size: 12px">
                        <li>All filter and sorting fields are optional.
                        <li>API "v1" uses "LIKE" for Title search, "v2" uses Full Text Search.</li>
                        <li>API is exposed on port 8000 for external calls, internally (on this UI for example) port 80 is used.</li>
                        <li>API calls carry header containing Authorization Bearer {token} for authentication.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div style="font-weight: bold; border: 1px solid #000;">
        {!! Form::open(array('url' => '/dosearch', 'id' => 'form_search')) !!}
        http://localhost:8000/api/
        {{ Form::select('api_version', array('v1' => 'v1', 'v2' => 'v2')) }}
        /products?q={{ Form::text('filter_title', Input::old('filter_title'), array('placeholder' => 'Product title', 'size'=>16)) }}
        <br><br>
        &filter=
        brand:{{ Form::text('filter_brand', Input::old('filter_brand'), array('placeholder' => 'Brand name', 'size'=>12)) }}
        ,pricemin:{{ Form::number('filter_pricemin', Input::old('filter_pricemin'), array('placeholder' => '00.00', 'class'=>'input_number')) }}
        ,pricemax:{{ Form::number('filter_pricemax', Input::old('filter_pricemax'), array('placeholder' => '99.99', 'class'=>'input_number')) }}
        ,stock:{{ Form::number('filter_stock', Input::old('filter_stock'), array('placeholder' => 'Stock amount', 'class'=>'input_number')) }}
        <br><br>
        &sort=
        {{ Form::select('sort_title', array('' => 'Title ↑↓', 'title:asc' => 'title:asc', 'title:desc' => 'title:desc'), Input::old('sort_title'), ['id' => 's_sort_title', 'class' => 'picker']) }},
        {{ Form::select('sort_brand', array('' => 'Brand ↑↓', 'brand:asc' => 'brand:asc', 'brand:desc' => 'brand:desc'), Input::old('sort_brand'), ['id' => 's_sort_brand', 'class' => 'picker']) }},
        {{ Form::select('sort_price', array('' => 'Price ↑↓', 'price:asc' => 'price:asc', 'price:desc' => 'price:desc'), Input::old('sort_price'), ['id' => 's_sort_price', 'class' => 'picker']) }},
        {{ Form::select('sort_stock', array('' => 'Stock ↑↓', 'stock:asc' => 'stock:asc', 'stock:desc' => 'stock:desc'), Input::old('sort_stock'), ['id' => 's_sort_stock', 'class' => 'picker']) }},
        &page=
        {{ Form::number('page', Input::old('page'), array('placeholder' => '1', 'class'=>'input_number')) }}
        {{ Form::submit('Submit Request', ['class' => 'btn btn-primary'])  }}
        {{ Form::close() }}<br>
    </div>

    <div id="two">
        @if (isset($response) ? true : false)
            <div style="font-family:courier;">
                Requested URL:<br>
                {{ Form::textarea('requestUrl', $requestUrl, ['id' => 't_requesturl', 'rows' => 1, 'cols' => 120, 'style' => 'resize:all']) }}
            </div>
            <div style="font-family:courier;">
                Response:<br>
                {{ Form::textarea('response', $response, ['id' => 't_response', 'rows' => 26, 'cols' => 120, 'style' => 'resize:all']) }}
            </div>
        @endif
    </div>
</div>

    </body>
</html>
