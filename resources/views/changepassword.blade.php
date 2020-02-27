@extends ("container")

@section("title","home")

@section('body')

    @include('sweetalert::cdn')
    @include('sweetalert::view')


    <div class="content">
        <div class="container-fluid">

            <div class="row">


                <div class="col-md-12">

                    @foreach (['danger', 'warning', 'success', 'info'] as $key)
                        @if(Session::has($key))
                            <p class="alert alert-{{ $key }}">{{ Session::get($key) }}</p>
                        @endif
                    @endforeach


                    <div class="card">
                        <form method="POST" action="{{url("/hospital/profile/changepassword/edit")}}" class="form-horizontal">

                            {{ csrf_field() }}

                            <div class="card-header card-header-text" data-background-color="rose">
                                <h4 class="card-title">Profile</h4>
                            </div>
                            <div class="card-content">

                                <input type="hidden" class="form-control" name="id"  value="{{$admin->id}}">

                                <div class="row">
                                    <label class="col-sm-2 label-on-left">Old Password</label>
                                    <div class="col-sm-10">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"></label>
                                            <input type="password" name="oldpassword" class="form-control"  required>
                                            <span class="help-block">Old Password.</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-sm-2 label-on-left">New Password</label>
                                    <div class="col-sm-10">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"></label>
                                            <input type="password" name="newpassword"  class="form-control" required>
                                            <span class="help-block">New Password.</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-sm-2 label-on-left">Confirm New Password</label>
                                    <div class="col-sm-10">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"></label>
                                            <input type="password" name="confirmnewpassword"  class="form-control" required>
                                            <span class="help-block">Confirm New Password.</span>
                                        </div>
                                    </div>
                                </div>





                                <div class="row">

                                </div>
                                <div class="row">

                                </div>
                                <br/><br/>
                                <div class="row">
                                    <label class="col-md-3"></label>
                                    <div class="col-md-9">
                                        <div class="form-group form-button">
                                            <button type="submit" class="btn btn-fill btn-rose">Change Password</button>
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