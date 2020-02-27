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




    <!-- Canonical SEO -->
    <link rel="canonical" href="http://www.creative-tim.com/product/material-dashboard-pro"/>

    <!--  Social tags      -->
    <meta name="keywords" content="">

    <meta name="description" content=" ">




    <!--     Fonts and icons     -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
          rel="stylesheet">


</head>


<body >

<nav class="navbar navbar-primary navbar-transparent navbar-absolute">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{url("hospital/login")}}"><img src="{{asset("assets/img/logo.png")}}" alt="Ospicare" height="150" width="150" /> </a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <!--<li>
                    <a href="../dashboard.html">
                        <i class="material-icons">dashboard</i> Dashboard
                    </a>
                </li>-->

                <li class=" ">
                    <a href="{{url("/hospital/login")}}">
                        <i class="material-icons">fingerprint</i> Login
                    </a>
                </li>
                <li class="active">
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

        <div class="content">
            <div class="container-fluid">
                <div class="col-sm-12">
                    <!--      Wizard container        -->
                    <div class="wizard-container">
                        <div class="card wizard-card" data-color="green" id="wizardProfile">
                            <form method="POST" action="{{url("/hospital/register")}}">
                                <!--        You can switch " data-color="purple" "  with one of the next bright colors: "green", "orange", "red", "blue"       -->

                                {{ csrf_field() }}
                                
                                <div class="wizard-header">
                                    <h3 class="wizard-title">
                                        Register Hospital
                                    </h3>
                                    <h5>Register Your Hospital On Ospicare</h5>
                                </div>
                                <div class="wizard-navigation">
                                    <ul>
                                        <li><a href="#account" data-toggle="tab">Hospital</a></li>
                                        <li><a href="#about" data-toggle="tab">Add Management Administrator</a></li>
                                   </ul>
                                </div>

                                <div class="tab-content">

                                    <div class="tab-pane" id="account">
                                        <h4 class="info-text"> </h4>
                                        <div class="row">



                                                <div class="col-lg-10 col-lg-offset-1">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">apartment</i>
                                                        </span>
                                                        <div class="form-group label-floating">
                                                            <label class="control-label">Hospital Name <small>(required)</small></label>
                                                            <input name="name" type="text" class="form-control" required>
                                                        </div>
                                                    </div>
                                                </div>

                                            <div class="col-lg-10 col-lg-offset-1">
                                                <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">apartment</i>
                                                        </span>
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Hospital Address <small>(required)</small></label>
                                                        <input name="address" type="text" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-10 col-lg-offset-1">
                                                <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">apartment</i>
                                                        </span>
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Hospital Local Govt Area <small>(required)</small></label>
                                                        <input name="lga" type="text" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-10 col-lg-offset-1">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">State</label>
                                                    <select name="state" class="form-control">
                                                        <option disabled="" selected=""></option>
                                                        <option value="Lagos"> Lagos </option>
                                                        <option value="Abuja"> Abuja </option>
                                                        <option value="PH"> PH </option>
                                                        <option value="Enugu"> Enugu </option>
                                                        <option value="Benin"> Benin </option>
                                                    </select>
                                                </div>



                                            </div>



                                            </div>
                                    </div>
                                    <div class="tab-pane" id="about">
                                        <div class="row">
                                            <h4 class="info-text"> Enter Hospital Administrator Info</h4>
                                            <div class="col-sm-4 col-sm-offset-1">
                                                <div class="picture-container">
                                                    <div class="picture">
                                                        <img src="../../assets/img/default-avatar.png" class="picture-src" id="wizardPicturePreview" title=""/>
                                                        <input type="file" id="wizard-picture">
                                                    </div>
                                                    <h6>Choose Picture</h6>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">face</i>
                                        </span>
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Full Name <small>(required)</small></label>
                                                        <input name="fullname" type="text" class="form-control" required>
                                                    </div>
                                                </div>

                                                <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">email</i>
                                        </span>
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Email <small>(required)</small></label>
                                                        <input name="email" type="email" class="form-control" required>
                                                    </div>
                                                </div>

                                                <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">lock</i>
                                        </span>
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Password <small>(required)</small></label>
                                                        <input name="password" type="password" class="form-control" required>
                                                    </div>
                                                </div>

                                                <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">lock</i>
                                        </span>
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Confirm Password <small>(required)</small></label>
                                                        <input name="confirmpassword" type="password" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-10 col-lg-offset-1">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="address">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h4 class="info-text"> Are you living in a nice area? </h4>
                                            </div>
                                            <div class="col-sm-7 col-sm-offset-1">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Street Name</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Street No.</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm-5 col-sm-offset-1">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">City</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm-5">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Country</label>
                                                    <select name="country" class="form-control">
                                                        <option disabled="" selected=""></option>
                                                        <option value="Afghanistan"> Afghanistan </option>
                                                        <option value="Albania"> Albania </option>
                                                        <option value="Algeria"> Algeria </option>
                                                        <option value="American Samoa"> American Samoa </option>
                                                        <option value="Andorra"> Andorra </option>
                                                        <option value="Angola"> Angola </option>
                                                        <option value="Anguilla"> Anguilla </option>
                                                        <option value="Antarctica"> Antarctica </option>
                                                        <option value="...">...</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="wizard-footer">
                                    <div class="pull-right">
                                        <input type='button' class='btn btn-next btn-fill btn-rose btn-wd' name='next' value='Next' />
                                        <input  type="submit"  class='btn btn-finish btn-fill btn-rose btn-wd' name='finish' value='Finish' />
                                    </div>

                                    <div class="pull-left">
                                        <input type='button' class='btn btn-previous btn-fill btn-default btn-wd' name='previous' value='Previous' />
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </form>
                        </div>
                    </div> <!-- wizard container -->
                </div>

            </div>
        </div>


        <footer class="footer">
            <div class="container-fluid">

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


---------------------------------------------------------------------------------------------











<script type="text/javascript">
    $(document).ready(function(){
        demo.initMaterialWizard();
        setTimeout(function(){
            $('.card.wizard-card').addClass('active');
        },600);
    });
</script>




</html>
