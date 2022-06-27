<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 Custom Error Page Example</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

    <style>

        button {
            margin: 20px;
        }
        .custom-btn {
            width: 300px;
            height: 40px;
            color: #fff;
            border-radius: 5px;
            font-family: 'Lato', sans-serif;
            font-weight: bold;
            font-size: 22px;

            background: transparent;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            display: inline-block;
            box-shadow:inset 2px 2px 2px 0px rgba(255,255,255,.5),
            7px 7px 20px 0px rgba(0,0,0,.1),
            4px 4px 5px 0px rgba(0,0,0,.1);
            outline: none;
        }
        /* 15 */
        .btn-15 {
            background: #b621fe;
            border: none;
            z-index: 1;
        }
        .btn-15:after {
            position: absolute;
            content: "";
            width: 0;
            height: 100%;
            top: 0;
            right: 0;
            z-index: -1;
            background-color: #663dff;
            border-radius: 5px;
            box-shadow:inset 2px 2px 2px 0px rgba(255,255,255,.5),
            7px 7px 20px 0px rgba(0,0,0,.1),
            4px 4px 5px 0px rgba(0,0,0,.1);
            transition: all 0.3s ease;
        }
        .btn-15:hover {
            color: #fff;
        }
        .btn-15:hover:after {
            left: 0;
            width: 100%;
        }
        .btn-15:active {
            top: 2px;
        }


    </style>
</head>
<body>
<div class="container mt-5">

    <div class="text-center">
        <img src="{{asset('admin/site_imgs/error_404.gif')}}" alt="IMG">
        <br>

        <button type="submit" class="custom-btn btn-15" href="{{route('admin.home')}}" style="align-items: center">
            <a href="{{route('admin.home')}}" style="color: white;text-decoration: none;">
                Go To Home
            </a>

        </button>





    </div>
</div>
</body>
</html>