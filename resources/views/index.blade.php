@extends ("container")

@section("title","home")

@section('body')


    <div class="content">
        <div class="container-fluid">


            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header" data-background-color="orange">
                            <i class="material-icons">people</i>
                        </div>
                        <div class="card-content">
                            <p class="category">Number of Patients</p>
                            <h3 class="card-title">{{$patients}}</h3>
                        </div>
                        <div class="card-footer">

                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header" data-background-color="rose">
                            <i class="material-icons">list</i>
                        </div>
                        <div class="card-content">
                            <p class="category">Number Of Doctors</p>
                            <h3 class="card-title">{{$doctors}}</h3>
                        </div>
                        <div class="card-footer">

                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header" data-background-color="green">
                            <i class="material-icons">list</i>
                        </div>
                        <div class="card-content">
                            <p class="category">Number Of Nurses</p>
                            <h3 class="card-title">{{$nurse}}</h3>
                        </div>
                        <div class="card-footer">

                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header" data-background-color="blue">
                            <i class="material-icons">account_balance</i>
                        </div>
                        <div class="card-content">
                            <p class="category">Wallet Balance</p>
                            <h3 class="card-title">₦{{$walletAmount}}</h3>
                        </div>
                        <div class="card-footer">

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">


            </div>


            <div class="row">


            </div>


        </div>
    </div>



@endsection