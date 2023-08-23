<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Right Medical</title>
    <link rel="stylesheet" href="{{asset('frontend_assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('frontend_assets/css/bootstrap.min.css')}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="js/style.js"></script>
</head>

<body>



    <section class="main-loginpage">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5">
                    <div class="rightSide">
                        <div class="logo">
                            <img src="{{asset('frontend_assets/image/sin.png')}}" alt="">
                            <h1>Right Medical</h1>
                        </div>
                        <div class="innerTxt">
                            <h3>Welcome to Right Medical!</h3>
                            <p>Please sign-in to your account and start the adventure</p>
                        </div>
                        <div class="form-section">
                            @include('layouts.partials.messages')
                            <form method="POST" action="{{ route('frontend.login') }}">
                                @csrf
                                <div class="form-group bold">
                                    <label for="exampleInputEmail1">Email or username</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1" name="email"  value="{{ old('email') }}" placeholder="Enter your email" aria-describedby="emailHelp">
                                </div>
                                <div class="form-group bold">
                                    <label for="exampleInputPassword1">Password</label>
                                    <input type="password" class="form-control" id="exampleInputPassword1" name="password" value="{{ old('password') }}" placeholder="Password">
                                </div>
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">Remember me</label>
                                </div>
                                <div class="btn-2">
                                    <button type="submit" class="btn btn-primary btn-block">SIGN IN</button>
                                </div>
                            </form>
                        </div>
                        <div class="copyrightSection">
                            <p> Copyright © 2023, made with ❤️ by
                                <a href="https://banttech.com/" target="_blank">Banttech.com</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="leftSide">
                        <div class="imgsection">
                            <img src="{{asset('frontend_assets/image/M3.jpg')}}" alt="Right Medical" class="img">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- <div class="container-fluid">
        <div class="row">
            <div class="col-md-3" id="margin">
                <div class="row ">
                    <div class="col text-center">
                        <h1><img src="image/sin.png" alt=""> Right Medical</h1>
                    </div>
                </div>
                <div class="row ">
                    <div class="col pl-5 py-3" id="center">
                        <h3>Welcome to Right Medical!</h3>
                        <p>Please sign-in to your account and start the adventure</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col " id="center-1">
                        <form>
                            <div class="form-group bold">
                                <label for="exampleInputEmail1">Email or username</label>
                                <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter your email" aria-describedby="emailHelp">
                            </div>
                            <div class="form-group bold">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1">Remember me</label>
                            </div>
                            <div class="btn-2">
                                <button type="submit" class="btn btn-primary">SIGN IN</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-9" id="zero">
                <img src="image/M3.jpg" alt="" class="img">
            </div>
        </div>
        <div class="row">
            <div class="col footer text-center btn-primary">
                <p> Copyright © 2023 Right Medical Pvt. Ltd. All Rights Reserved.</p>
            </div>
        </div>

        </div> -->










    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>

</body>

</html>

</html>