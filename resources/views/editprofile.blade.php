@extends ("container")

@section("title","home")

@section('body')

    @include('sweetalert::cdn')
    @include('sweetalert::view')


    <div class="content">
        <div class="container-fluid">

            <div class="row">


                <div class="col-md-12">



                    <div class="card">

                        <form method="POST" action="{{url("/hospital/profile/edit")}}" class="form-horizontal">

                            {{ csrf_field() }}

                            <div class="card-header card-header-text" data-background-color="rose">
                                <h4 class="card-title">Profile</h4>
                            </div>
                            <div class="card-content">

                                <input type="hidden" class="form-control" name="id" id="fid" value="{{$admin->id}}">

                                <div class="row">
                                    <label class="col-sm-2 label-on-left">Email</label>
                                    <div class="col-sm-10">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"></label>
                                            <input type="email" name="email" value="{{$admin->email}}" class="form-control" required>
                                            <span class="help-block">email.</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-sm-2 label-on-left">FulllNames</label>
                                    <div class="col-sm-10">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"></label>
                                            <input type="text" name="fullnames" class="form-control" value="{{$admin->full_names}}" required>
                                            <span class="help-block">FullNames.</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-sm-2 label-on-left">PhoneNumber</label>
                                    <div class="col-sm-10">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"></label>
                                            <input type="text" name="phonenumber" value="{{$admin->phone_number}}" class="form-control" required>
                                            <span class="help-block">phonenumber.</span>
                                        </div>
                                    </div>
                                </div>








                                <br/><br/>
                                <div class="row">
                                    <label class="col-md-3"></label>
                                    <div class="col-md-9">
                                        <div class="form-group form-button">
                                            <button type="submit" class="btn btn-fill btn-rose">Edit Profile</button>
                                        </div>
                                    </div>
                                </div>


                            </div>

                        </form>
                        <br/><br/>
                    </div>


                </div>

            </div>


        </div>
    </div>





@endsection