<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href={{asset("assets/img/apple-icon.png")}} />
    <link rel="icon" type="image/png" href="assets/img/favicon.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Ospicare</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <!-- Canonical SEO -->

    <!-- Bootstrap core CSS     -->
    <link href={{asset("assets/css/bootstrap.min.css")}} rel="stylesheet" />
    <!--  Material Dashboard CSS    -->
    <link href={{asset("assets/css/material-dashboard23cd.css?v=1.2.1")}} rel="stylesheet" />
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href={{asset("assets/css/demo.css")}} rel="stylesheet" />
    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>

    <link href={{asset("assets/dt/css/datatables.min.css")}} rel="stylesheet" />
    <link href={{asset("assets/dt/css/datatables.bootstrap.css")}} rel="stylesheet" />


    <style type="text/css">

        .fileinput-remove,
        .fileinput-upload{
            display: none;
        }
    </style>


</head>

<body>
<div class="wrapper">
    <div class="sidebar" data-active-color="rose" data-background-color="black" data-image="assets/img/sidebar-1.jpg">
        <!--
    Tip 1: You can change the color of active element of the sidebar using: data-active-color="purple | blue | green | orange | red | rose"
    Tip 2: you can also add an image using data-image tag
    Tip 3: you can change the color of the sidebar with data-background-color="white | black"
-->
        <div class="logo">
            <a href="#" class="simple-text logo-mini">

            </a>
            <a href="#" class="simple-text logo-normal">
                Ospicare
            </a>
        </div>
        <div class="sidebar-wrapper">
            <div class="user">
                <div class="photo">
                    <img src={{asset("assets/img/faces/noface.jpeg")}} />
                </div>
                <div class="info">
                    <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                            <span>
                                @if(Session::has('ospicareFullNames'))
                                    {{ strtoupper(trans(Session::get('ospicareFullNames')))}}
                                @endif
                                <b class="caret"></b>
                            </span>
                    </a>
                    <div class="clearfix"></div>
                    <div class="collapse" id="collapseExample">
                        <ul class="nav">
                           <!-- <li>
                                <a href="{{url("/hospital/profile/edit")}}">
                                    <span class="sidebar-mini"> MP </span>
                                    <span class="sidebar-normal"> My Profile </span>
                                </a>
                            </li>-->

                            <li>
                                <a href="{{url("hospital/profile/changepassword")}}">
                                    <span class="sidebar-mini"> CP </span>
                                    <span class="sidebar-normal"> Change Password </span>
                                </a>
                            </li>


                        </ul>
                    </div>
                </div>
            </div>
            <ul class="nav">



                <li>
                    <a href="{{url("hospital/index")}}">
                        <i class="material-icons">dashboard</i>
                        <p> Dashboard </p>
                    </a>
                </li>

                <li>
                    <a data-toggle="collapse" href="#admin">
                        <i class="material-icons">perm_identity</i>
                        <p> Management Admin
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="admin">
                        <ul class="nav">

                            <li>
                                <a href="{{url("hospital/admin/")}}">
                                    <span class="sidebar-mini"> LA </span>
                                    <span class="sidebar-normal"> List Of Admin </span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>

                <li>
                    <a data-toggle="collapse" href="#doctor">
                        <i class="material-icons">perm_identity</i>
                        <p> Doctors
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="doctor">
                        <ul class="nav">

                            <li>
                                <a href="{{url("/hospital/doctor")}}">
                                    <span class="sidebar-mini"> LA </span>
                                    <span class="sidebar-normal"> List Of Doctors </span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>

                <li>
                    <a data-toggle="collapse" href="#nurse">
                        <i class="material-icons">perm_identity</i>
                        <p> Nurses
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="nurse">
                        <ul class="nav">

                            <li>
                                <a href="{{url("/hospital/nurse")}}">
                                    <span class="sidebar-mini"> LA </span>
                                    <span class="sidebar-normal"> List Of Nurses </span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>

                <li>
                    <a data-toggle="collapse" href="#patient">
                        <i class="material-icons">perm_identity</i>
                        <p> Patients
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="patient">
                        <ul class="nav">

                            <li>
                                <a href="{{url("/hospital/patient")}}">
                                    <span class="sidebar-mini"> LA </span>
                                    <span class="sidebar-normal"> List Of Patients </span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>

                <li>
                    <a data-toggle="collapse" href="#parameter">
                        <i class="material-icons">account_balance</i>
                        <p> Wallet History
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="parameter">
                        <ul class="nav">

                            <li>
                                <a href="{{url("/hospital/fund/history")}}">
                                    <span class="sidebar-mini"> LA </span>
                                    <span class="sidebar-normal"> Wallet Fund History </span>
                                </a>
                            </li>

                            <li>
                                <a href="{{url("/hospital/wallet/transaction")}}">
                                    <span class="sidebar-mini"> LA </span>
                                    <span class="sidebar-normal"> Usage History </span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>






            </ul>
        </div>
    </div>
    <div class="main-panel">
        <nav class="navbar navbar-transparent navbar-absolute">
            <div class="container-fluid">
                <div class="navbar-minimize">
                    <button id="minimizeSidebar" class="btn btn-round btn-white btn-fill btn-just-icon">
                        <i class="material-icons visible-on-sidebar-regular">more_vert</i>
                        <i class="material-icons visible-on-sidebar-mini">view_list</i>
                    </button>
                </div>
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#"> Ospicare Admin Portal </a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <!--<li>
                            <a href="#pablo" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="material-icons">dashboard</i>
                                <p class="hidden-lg hidden-md">Dashboard</p>
                            </a>
                        </li>-->

                        <li>
                            <a href="{{url("hospital/logout")}}">
                                <i class="fa fa-sign-out">logout</i>
                                <p class="hidden-lg hidden-md">Profile</p>
                            </a>
                        </li>
                        <li class="separator hidden-lg hidden-md"></li>
                    </ul>
                    <!--<form class="navbar-form navbar-right" role="search">
                        <div class="form-group form-search is-empty">
                            <input type="text" class="form-control" placeholder=" Search ">
                            <span class="material-input"></span>
                        </div>
                        <button type="submit" class="btn btn-white btn-round btn-just-icon">
                            <i class="material-icons">search</i>
                            <div class="ripple-container"></div>
                        </button>
                    </form>-->
                </div>
            </div>
        </nav>
        @section('body')
        @show
        <footer class="footer">
            <div class="container-fluid">
                <nav class="pull-left">

                </nav>
                <p class="copyright pull-right">
                    &copy;
                    <script>
                        document.write(new Date().getFullYear())
                    </script>
                    <a href="#"> Ospicare </a>. All rights reserved.
                </p>
            </div>
        </footer>
    </div>
</div>

</body>
<!--   Core JS Files   -->
<script src={{asset("assets/js/jquery-3.2.1.min.js")}} type="text/javascript"></script>
<script src={{asset("assets/js/bootstrap.min.js")}} type="text/javascript"></script>



<script src={{asset("assets/js/material.min.js")}} type="text/javascript"></script>
<script src={{asset("assets/js/perfect-scrollbar.jquery.min.js")}} type="text/javascript"></script>
<!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
<script src="http://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
<!-- Library for adding dinamically elements -->
<script src={{asset("assets/js/arrive.min.js")}} type="text/javascript"></script>
<!-- Forms Validations Plugin -->
<script src={{asset("assets/js/jquery.validate.min.js")}}></script>
<!--  Plugin for Date Time Picker and Full Calendar Plugin-->
<script src={{asset("assets/js/moment.min.js")}}></script>

<!--	Plugin for the Datepicker, full documentation here: https://github.com/Eonasdan/bootstrap-datetimepicker -->
<script src="{{asset("assets/js/bootstrap-datetimepicker.js")}}"></script>

<!--  Charts Plugin, full documentation here: https://gionkunz.github.io/chartist-js/ -->
<script src={{asset("assets/js/chartist.min.js")}}></script>

<script src="{{asset("https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js")}}"></script>
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

<script src={{asset("assets/dt/js/datatables.min.js")}}></script>
<script src={{asset("assets/dt/js/datatables.bootstrap.js")}}></script>
<script src={{asset("assets/dt/js/script/datatable.js")}}></script>
<script src={{asset("assets/dt/js/script/table-datatables-buttons.min.js")}}></script>




<script type="text/javascript">
    $(document).ready(function() {

        // Javascript method's body can be found in assets/js/demos.js
        demo.initDashboardPageCharts();

        demo.initVectorMap();
    });
</script>

<script type="text/javascript">
    $(function () {
        $('#datetimepicker5').datetimepicker({
            format:'YYYY-MM-DD',
            defaultDate: "2018-05-20",
        });



    });
</script>


</html>