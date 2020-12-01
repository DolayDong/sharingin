<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Sharingin(Login)</title>
    <link rel="stylesheet" href="{{url('/css/style.shareaja.css')}}">

    <style>
        #app {
            background-color: rgba(196, 196, 196, 0.5);
            z-index: -999;
            height: 100vh;
        }
    </style>

    </head>
    <body>
      <div id="app">
      <example-component csrf="{{ csrf_token() }}"/>
      </div>

    <script src="{{url('/js/app.js')}}"></script>
    </body>
</html>
