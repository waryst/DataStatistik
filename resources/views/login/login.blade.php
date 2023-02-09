<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard | Login</title>
    <link href="{{ url('/asset_adminweb/login') }}/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ url('/asset_adminweb/login') }}/js/bootstrap.bundle.min.js" rel="stylesheet">
    <link href="{{ url('/asset_adminweb/login') }}/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{ url('/asset_adminweb/login') }}/css/style.css" rel="stylesheet">
    <link href="{{ url('/asset_adminweb/login') }}/js/jquery.min.js" rel="stylesheet">


</head>

<body>
    <div class="container-fluid px-1 px-md-5 px-lg-1 px-xl-5 py-5 mx-auto">
        <div class="card card0 border-0">
            <div class="row d-flex">
                <div class="col-lg-6">
                    <div class="card1 pb-5">
                        <div class="row">
                            <img src="{{ url('/asset_adminweb/login/img/logo.png') }}" class="logo">
                        </div>
                        <div class="row px-3 justify-content-center mt-4 mb-5 border-line"> <img
                                src="{{ url('/asset_adminweb/login/img') }}/uNGdWHi.png" class="image"> </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card2 card border-0 px-4 py-5">
                        <div class="row mb-2 px-3">
                            <h6 class="mb-0 mr-4 mt-2">Halaman Login</h6>
                        </div>
                        <div class="row mb-2">
                            <div class="line"></div>
                        </div>
                        <form action="{{ url('/postlogin') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="row px-3"> <label class="mb-1">
                                    <h6 class="mb-0 text-sm">Username</h6>
                                </label> <input class="mb-4" type="text" name="email"
                                    placeholder="Enter Username">
                            </div>
                            <div class="row px-3"> <label class="mb-1">
                                    <h6 class="mb-0 text-sm">Password</h6>
                                </label> <input type="password" name="password" placeholder="Enter password"> </div>
                            <div class="row my-3 px-3"> <button type="submit"
                                    class="btn btn-blue text-center">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="bg-blue py-4">
                <div class="row px-3"> <small class="ml-4 ml-sm-5 mb-2">Copyright &copy; 2021. All rights
                        reserved.</small>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
