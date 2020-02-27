<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="assets/img/favicon.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Ospicare</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <!-- Bootstrap core CSS     -->
    <link href={{asset("assets/css/bootstrap.min.css")}} rel="stylesheet" />
    <!--  Material Dashboard CSS    -->
    <link href={{asset("assets/css/material-dashboard23cd.css?v=1.2.1")}} rel="stylesheet" />
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href={{asset("assets/css/demo.css")}} rel="stylesheet" />
    <!--     Fonts and icons     -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body class="off-canvas-sidebar">
<nav class="navbar navbar-primary navbar-transparent navbar-absolute">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{url("/hospital/login")}}"><img src="{{asset("assets/img/logo.png")}}" alt="Ospicare" height="150" width="150" /> </a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <!--<li>
                    <a href="../dashboard.html">
                        <i class="material-icons">dashboard</i> Dashboard
                    </a>
                </li>-->

                <li class=" active ">
                    <a href="{{url("/hospital/login")}}">
                        <i class="material-icons">fingerprint</i> Login
                    </a>
                </li>
                <li class="">
                    <a href="{{url("/hospital/register")}}">
                        <i class="material-icons">add_to_photos</i> Register Hospital
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="wrapper wrapper-full-page">
    <div class="full-page login-page" filter-color="green" data-image={{asset("assets/img/login.jpg")}}>
        <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">


                        <form method="POST" action="{{url("/hospital/login")}}">

                            {{ csrf_field() }}

                            <div class="card card-login card-hidden">
                                <div class="card-header text-center" data-background-color="green">
                                    <h4 class="card-title">Login</h4>
                                    <div class="social-line">
                                        <a href="#btn" class="btn btn-just-icon btn-simple">
                                            <i class="fa fa-facebook-square"></i>
                                        </a>
                                        <a href="#pablo" class="btn btn-just-icon btn-simple">
                                            <i class="fa fa-twitter"></i>
                                        </a>
                                        <a href="#eugen" class="btn btn-just-icon btn-simple">
                                            <i class="fa fa-instagram"></i>
                                        </a>
                                    </div>
                                </div>
                                <p class="category text-center">

                                </p>
                                <div class="card-content">
                                    <!--<div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">face</i>
                                            </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">First Name</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>-->
                                    <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">email</i>
                                            </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Email address</label>
                                            <input type="email" name="email" class="form-control">
                                        </div>
                                    </div>
                                    <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">lock_outline</i>
                                            </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Password</label>
                                            <input type="password" name="password" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="footer text-center">
                                    <button type="submit" class="btn btn-rose btn-simple btn-wd btn-lg">Let's go</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="container">
               <!-- <nav class="pull-left">
                    <ul>
                        <li>
                            <a href="#">
                                About ChurchApp
                            </a>
                        </li>
                        <li>
                            <a href="{{url("terms")}}">
                                Terms and Conditions
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Privacy Policy
                            </a>
                        </li>
                        <li>
                            <a href="#">

                            </a>
                        </li>
                    </ul>
                </nav>-->
                <p class="copyright pull-right">
                    &copy;
                    <script>
                        document.write(new Date().getFullYear())
                    </script>
                    <a href="https://www.myospicare.com/"> Ospicare </a>. All Rights Reserved
                </p>
            </div>
        </footer>
    </div>
</div>
</body>
<!--<div class="fixed-plugin">
    <div class="dropdown show-dropdown">
        <a href="#" data-toggle="dropdown">
            <i class="fa fa-cog fa-2x"> </i>
        </a>
        <ul class="dropdown-menu">
            <li class="header-title">Background Style</li>
            <li class="adjustments-line">
                <a href="javascript:void(0)" class="switch-trigger">
                    <p>Background Image</p>
                    <div class="togglebutton switch-sidebar-image">
                        <label>
                            <input type="checkbox" checked="">
                        </label>
                    </div>
                    <div class="clearfix"></div>
                </a>
            </li>
            <li class="adjustments-line">
                <a href="javascript:void(0)" class="switch-trigger active-color">
                    <p>Filters</p>
                    <div class="badge-colors pull-right">
                        <span class="badge filter active" data-color="black"></span>
                        <span class="badge filter badge-blue" data-color="blue"></span>
                        <span class="badge filter badge-green" data-color="green"></span>
                        <span class="badge filter badge-orange" data-color="orange"></span>
                        <span class="badge filter badge-red" data-color="red"></span>
                        <span class="badge filter badge-purple" data-color="purple"></span>
                        <span class="badge filter badge-rose" data-color="rose"></span>
                    </div>
                    <div class="clearfix"></div>
                </a>
            </li>
            <li class="header-title">Background Images</li>
            <li class="active">
                <a class="img-holder switch-trigger" href="javascript:void(0)">
                    <img src={{asset("assets/img/sidebar-1.jpg")}} data-src={{asset("assets/img/login.jpeg")}} alt="" />
                </a>
            </li>
            <li>
                <a class="img-holder switch-trigger" href="javascript:void(0)">
                    <img src={{asset("assets/img/sidebar-2.jpg")}} data-src={{asset("assets/img/lock.jpeg")}} alt="" />
                </a>
            </li>
            <li>
                <a class="img-holder switch-trigger" href="javascript:void(0)">
                    <img src={{asset("assets/img/sidebar-3.jpg")}} data-src={{asset("assets/img/header-doc.jpeg")}} alt="" />
                </a>
            </li>
            <li>
                <a class="img-holder switch-trigger" href="javascript:void(0)">
                    <img src="assets/img/sidebar-4.jpg" data-src={{asset("assets/img/bg-pricing.jpeg")}} alt="" />
                </a>
            </li>
            <li class="button-container">
                <div class="">
                    <a href="http://www.creative-tim.com/product/material-dashboard-pro" target="_blank" class="btn btn-primary btn-block btn-fill">Buy Now!</a>
                </div>
                <div class="">
                    <a href="http://www.creative-tim.com/product/material-dashboard" target="_blank" class="btn btn-info btn-block">Get Free Demo</a>
                </div>
            </li>
            <li class="header-title">Thank you for 95 shares!</li>
            <li class="button-container">
                <button id="twitter" class="btn btn-social btn-twitter btn-round"><i class="fa fa-twitter"></i> &middot; 45</button>
                <button id="facebook" class="btn btn-social btn-facebook btn-round"><i class="fa fa-facebook-square"></i> &middot; 50</button>
            </li>
        </ul>
    </div>
</div>-->
</body>
<!--   Core JS Files   -->
<script src={{asset("assets/js/jquery-3.2.1.min.js")}} type="text/javascript"></script>
<script src={{asset("assets/js/bootstrap.min.js")}} type="text/javascript"></script>
<script src={{asset("assets/js/material.min.js")}} type="text/javascript"></script>
<script src={{asset("assets/js/perfect-scrollbar.jquery.min.js")}} type="text/javascript"></script>
<!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
<script src="cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
<!-- Library for adding dinamically elements -->
<script src={{asset("assets/js/arrive.min.js")}} type="text/javascript"></script>
<!-- Forms Validations Plugin -->
<script src={{asset("assets/js/jquery.validate.min.js")}}></script>
<!--  Plugin for Date Time Picker and Full Calendar Plugin-->
<script src={{asset("assets/js/moment.min.js")}}></script>
<!--  Charts Plugin, full documentation here: https://gionkunz.github.io/chartist-js/ -->
<script src={{asset("assets/js/chartist.min.js")}}></script>
<!--  Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
<script src={{asset("assets/js/jquery.bootstrap-wizard.js")}}></script>
<!--  Notifications Plugin, full documentation here: http://bootstrap-notify.remabledesigns.com/    -->
<script src={{asset("assets/js/bootstrap-notify.js")}}></script>
<!--   Sharrre Library    -->
<script src={{asset("assets/js/jquery.sharrre.js")}}></script>
<!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
<script src={{asset("assets/js/bootstrap-datetimepicker.js")}}></script>
<!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
<script src={{asset("assets/js/jquery-jvectormap.js")}}></script>
<!-- Sliders Plugin, full documentation here: https://refreshless.com/nouislider/ -->
<script src={{asset("assets/js/nouislider.min.js")}}></script>
<!--  Google Maps Plugin    -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD1_8C5Xz9RpEeJSaJ3E_DeBv8i7j_p6Aw"></script>
<!--  Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
<script src={{asset("assets/js/jquery.select-bootstrap.js")}}></script>
<!--  DataTables.net Plugin, full documentation here: https://datatables.net/    -->
<script src={{asset("assets/js/jquery.datatables.js")}}></script>
<!-- Sweet Alert 2 plugin, full documentation here: https://limonte.github.io/sweetalert2/ -->
<script src={{asset("assets/js/sweetalert2.js")}}></script>
<!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script src={{asset("assets/js/jasny-bootstrap.min.js")}}></script>
<!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
<script src={{asset("assets/js/fullcalendar.min.js")}}></script>
<!-- Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
<script src={{asset("assets/js/jquery.tagsinput.js")}}></script>
<!-- Material Dashboard javascript methods -->
<script src={{asset("assets/js/material-dashboard23cd.js?v=1.2.1")}}></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src={{asset("assets/js/demo.js")}}></script>
<script type="text/javascript">
    $().ready(function() {
        demo.checkFullPageBackgroundImage();

        setTimeout(function() {
            // after 1000 ms we add the class animated to the login/register card
            $('.card').removeClass('card-hidden');
        }, 700)
    });
</script>

@include('vendor.sweetalert.cdn')
@include('vendor.sweetalert.view')

</html>