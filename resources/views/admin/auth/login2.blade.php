<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="{{asset('admin/login_files/images/icons/favicon.ico')}}"/>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('admin/login_files/vendor/bootstrap/css/bootstrap.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('admin/login_files/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('admin/login_files/fonts/iconic/css/material-design-iconic-font.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('admin/login_files/vendor/animate/animate.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('admin/login_files/vendor/css-hamburgers/hamburgers.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('admin/login_files/vendor/animsition/css/animsition.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('admin/login_files/vendor/select2/select2.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('admin/login_files/vendor/daterangepicker/daterangepicker.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('admin/login_files/css/util.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/login_files/css/main.css')}}">
    <!--===============================================================================================-->
</head>
<body>

<div class="limiter">
    <div class="container-login100" >
        <div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54" style="box-shadow: 0 19px 38px rgba(0,0,0,0.30), 0 15px 12px rgba(0,0,0,0.22); display: flex; width: 55%">
            <div style="width: 60%; float: left;" >
                <img src="{{asset('admin/login_files/images/login.gif')}}" alt="IMG">
            </div>



            <form action="{{ route('admin.do_login') }}" method="post" class="login100-form validate-form" style="width: 40%; float: right;">
                @csrf
                <div class=" text-center mb-2">
                    <span class="login100-form-title" >Modern City Services</span>
                </div>

                <span class="login100-form-sub-title mb-1">Login</span>

                @include('admin/components/errors')
                <div class="wrap-input100 validate-input m-b-23" data-validate="Email is required">
                    <span class="label-input100" style="size: 20px">Email</span>
                    <input class="input100" type="email" name="email" placeholder="Type your email" required>
                    <span class="focus-input100" data-symbol="&#xf206;"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate="Password is required">
                    <span class="label-input100">Password</span>
                    <input class="input100" type="password" name="password" placeholder="Type your password" id="show_pass" required>
                    <span class="focus-input100" data-symbol="&#xf190;"></span>
                </div>

                <div class="text-left p-t-8 p-b-31 mb-5">
                    <input type="checkbox" onclick="showPassword()" style="height: 16px;width: 16px">
                    <span style="size: 15px"> Show Password</span>
                </div>



                <div class="container-login100-form-btn">
                    <div class="wrap-login100-form-btn">
                        <div class="login100-form-bgbtn"></div>
                        <button type="submit" class="login100-form-btn" >Login</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<div id="dropDownSelect1"></div>

<!--===============================================================================================-->
<script src="{{asset('admin/login_files/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
<!--===============================================================================================-->
<script src="{{asset('admin/login_files/vendor/animsition/js/animsition.min.js')}}"></script>
<!--===============================================================================================-->
<script src="{{asset('admin/login_files/vendor/bootstrap/js/popper.js')}}"></script>
<script src="{{asset('admin/login_files/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<!--===============================================================================================-->
<script src="{{asset('admin/login_files/vendor/select2/select2.min.js')}}"></script>
<!--===============================================================================================-->
<script src="{{asset('admin/login_files/vendor/daterangepicker/moment.min.js')}}"></script>
<script src="{{asset('admin/login_files/vendor/daterangepicker/daterangepicker.js')}}"></script>
<!--===============================================================================================-->
<script src="{{asset('admin/login_files/vendor/countdowntime/countdowntime.js')}}"></script>
<!--===============================================================================================-->
<script src="{{asset('admin/login_files/js/main.js')}}"></script>

<script>
    function showPassword() {
        var val = document.getElementById("show_pass");
        if (val.type === "password") {
            val.type = "text";
        } else {
            val.type = "password";
        }
    }

</script>

</body>
</html>