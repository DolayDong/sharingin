<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <base href="{{url('/')}}">

    <script type="text/javascript">
        if (typeof Storage !== undefined) {
            var data = <?php echo json_encode($userdata) ?>;

            console.log(data);
            sessionStorage.setItem("__user", JSON.stringify(data));
        }
    </script>

    <title>Home</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .__background__app__1 {
            position: fixed;
            z-index: -999;
            opacity: .3;
            top: 0;
            left: -400px;

        }

        .__background__app__2 {
            position: fixed;
            top: 0;
            opacity: 0.01;
            z-index: -999;
        }

        .__background__app__3 {
            position: fixed;
            top: 10%;
            right: 0;
            z-index: -999;
            opacity: .1;
        }
    </style>

    <link rel="stylesheet" href="{{url('/css/style.shareaja.css')}}">
</head>

<body>
    <div id="app">
        <home-component />
    </div>
    <div id="tema">
        <button-tema-component />
    </div>
    <img src="{{asset('images/background-app/background-1.jpg')}}" alt="Background Modern" class="__background__app__1">
    <img src="{{asset('images/background-app/background-2.jpg')}}" alt="Background Modern" class="__background__app__2">
    <img src="{{asset('images/background-app/background-3.jpg')}}" alt="Background Modern 3" class="__background__app__3">
    <script src="{{asset('/js/app.js')}}"></script>
    <script>
        // if (typeof Storage !== undefined) {
        //     const tema = new Vue({
        //         el: '#tema'
        //     });
        // }
    </script>

</body>

</html>