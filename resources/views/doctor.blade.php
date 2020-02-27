@extends ("container")

@section("title","home")

@section('body')

    @include('vendor.sweetalert.cdn')
    @include('vendor.sweetalert.view')

    <div class="content">
        <div class="container-fluid">

            <div class="row">


                <div class="col-md-12">

                    <div class="card">

                        <div class="card-header card-header-icon" data-background-color="purple">
                            <i class="material-icons">person</i>
                        </div>

                        <div class="card-content">

                            <h4 class="card-title">Doctors List</h4>
                            <div class="toolbar">
                                <!--        Here you can write extra buttons/actions for the toolbar
                                             -->
                                <button class="create-modal btn btn-success"><i class="fa fa-plus"></i> Add Doctor</button>
                            </div>

                            <div class="material-datatables">


                                <!--<table id="sample_1" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">-->

                                <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">

                                    <thead>
                                    <tr>
                                        <th class="text-center">Image</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Specialty</th>
                                        <th class="text-center">Created At</th>
                                        <th class="disabled-sorting text-right">Action</th>
                                    </tr>
                                    </thead>



                                    <tbody>

                                    @foreach($doctors as $item)
                                        <tr>
                                            <td class="text-center"> <img style="width: 100px; height: 100px" src="{{asset("profilePhoto/" . $item->image_path)}}" width="20px" height="20px"/>  </td>

                                            <td class="text-center"> {{$item->names}} </td>
                                            <td class="text-center"> {{$item->email}} </td>
                                            <td class="text-center"> {{$item->specialty}} </td>
                                            <td class="text-center"> {{$item->created_at}} </td>
                                            <td class="td-actions text-right">


                                                <button type="button" rel="tooltip" class="delete-modal btn btn-danger" data-id="{{$item->id}}"  data-name="{{$item->names}}" data-email="{{$item->email}}" data-phone="{{$item->phone_number}}" data-status="{{$item->specialty}}"  data-created="{{$item->created_at}}">
                                                    <i class="material-icons">close</i>
                                                </button>
                                            </td>

                                        </tr>
                                    @endforeach



                                    </tbody>

                                </table>

                            </div>
                        </div>

                    </div>

                </div>

            </div>


        </div>
    </div>


    {{-- Modal Form Create Post --}}
    <div id="create" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                @foreach (['danger', 'warning', 'success', 'info'] as $key)
                    @if(Session::has($key))
                        <p class="alert alert-{{ $key }}">{{ Session::get($key) }}</p>
                    @endif
                @endforeach
                <hr/>

                <form method="POST" enctype="multipart/form-data"  action="{{url("hospital/doctor/add")}}" class="form-horizontal" role="form">

                    {{ csrf_field() }}

                    <div class="modal-body">




                        <div class="form-group row add">
                            <label class="control-label col-sm-2" for="categoryname"> Name * :</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="categoryname" name="names"
                                       placeholder="Doctor Name Here" required>
                                <p class="error text-center alert alert-danger hidden"></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="body">Specialty:</label>
                            <div class="col-sm-10">

                                <select id="status" name="specialty" style="width: 200px; height: 35px; padding:5px"  data-style="select-with-transition" title="Single Select" data-size="7">
                                    <option value="General Health"> General Health</option>
                                    <option value="Cardiologist"> Cardiologist</option>
                                    <option value="Nephrologist"> Nephrologist</option>
                                    <option value="Orthopaedic Surgeon"> Orthopaedic Surgeon</option>
                                </select>

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="body">Gender:</label>
                            <div class="col-sm-10">

                                <select id="status" name="gender" style="width: 200px; height: 35px; padding:5px"  data-style="select-with-transition" title="Single Select" data-size="7">
                                    <option value="Male"> Male</option>
                                    <option value="Female"> Female</option>
                                </select>

                            </div>
                        </div>

                        <div class="form-group row add">
                            <label class="control-label col-sm-2" for="categoryname">Email  * :</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="categoryname" name="email"
                                       placeholder="Doctor Email Here" required>
                                <p class="error text-center alert alert-danger hidden"></p>
                            </div>
                        </div>

                        <div class="form-group row add">
                            <label class="control-label col-sm-2" for="categoryname">Password * :</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="categoryname" name="password"
                                       placeholder="Doctor Password Here" required>
                                <p class="error text-center alert alert-danger hidden"></p>
                            </div>
                        </div>

                        <div class="form-group row add">
                            <label class="control-label col-sm-2" for="categoryname">Phone * :</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" id="categoryname" name="phonenumber"
                                       placeholder="Doctor Phone Number Here" required>
                                <p class="error text-center alert alert-danger hidden"></p>
                            </div>
                        </div>

                        <div class="form-group row add">
                            <label class="control-label col-sm-2" for="categoryname">Bio * :</label>
                            <div class="col-sm-10">
                                <textarea  class="form-control" placeholder="Doctor Profile Here" name="bio" rows="5"></textarea>
                                <p class="error text-center alert alert-danger hidden"></p>
                            </div>
                        </div>




                        <div class="form-group">
                            <label class="control-label col-sm-2" for="body"> Photo :</label>
                            <div class="col-sm-10">

                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail">
                                        <img src="{{asset("assets/img/image_placeholder.jpg")}}" alt="...">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                    <div>
                                                    <span class="btn btn-rose btn-round btn-file">
                                                        <span class="fileinput-new">Select image</span>
                                                        <span class="fileinput-exists">Change</span>
                                                        <input type="file" name="file" />
                                                    </span>
                                        <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">

                        <button class="btn btn-warning" type="submit" id="add">
                            <span class="glyphicon glyphicon-plus"></span>Add
                        </button>
                        <button class="btn btn-warning" type="button" data-dismiss="modal">
                            <span class="glyphicon glyphicon-remobe"></span>Close
                        </button>

                    </div>

                </form>
            </div>
        </div>
    </div>




    {{-- Modal Form Edit  --}}
    <div id="editModal"class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <hr/>
                <form method="POST" enctype="multipart/form-data"  action="{{url("/banner/edit")}}" class="form-horizontal" role="form">

                    {{ csrf_field() }}

                    <div class="modal-body">

                        <input type="hidden" class="form-control" name="editcategoryid" id="fid">



                        <div class="form-group row add">
                            <label class="control-label col-sm-2" for="editcategoryname">Caption * :</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="editcategoryname" name="editcategoryname"
                                       placeholder="Your Category Name Here" required>
                                <p class="error text-center alert alert-danger hidden"></p>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="control-label col-sm-2" for="body">Sort Order :</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" id="editsortorder" name="editsortorder"
                                       placeholder="Enter Sort Order Number" required>
                                <p class="error text-center alert alert-danger hidden"></p>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="control-label col-sm-2" for="body">Status:</label>
                            <div class="col-sm-10">

                                <select id="editstatus" name="editstatus" style="width: 200px; height: 35px; padding:5px"  data-style="select-with-transition" title="Single Select" data-size="7">
                                    <option value="enable"> Enable</option>
                                    <option value="disable"> Disable</option>
                                </select>

                            </div>
                        </div>



                        <div class="form-group">
                            <label class="control-label col-sm-2" for="body">Banner Image :</label>
                            <div class="col-sm-10">

                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail">
                                        <img id="editimage" height="100" width="100" src="{{asset("banners/banner.png")}}" alt="...">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                    <div>
                                                    <span class="btn btn-rose btn-round btn-file">
                                                        <span class="fileinput-new">Select image</span>
                                                        <span class="fileinput-exists">Change</span>
                                                        <input type="file" id="editfile" name="editfile" />
                                                    </span>
                                        <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">

                        <button class="btn btn-warning" type="submit" id="add">
                            <span class="glyphicon glyphicon-plus"></span>Edit
                        </button>
                        <button class="btn btn-warning" type="button" data-dismiss="modal">
                            <span class="glyphicon glyphicon-remobe"></span>Close
                        </button>

                    </div>

                </form>
            </div>
        </div>
    </div>

    {{-- Modal Form Delete  --}}
    <div id="deleteModal"class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4>Delete Doctor</h4>
                </div>
                <hr/>
                <form method="post" action="{{url("/hospital/doctor/delete")}}"  role="modal">
                    {{ csrf_field() }}

                    <div class="modal-body">

                        <div class="card-content">
                            <div class="row">
                                <label class="col-sm-2 label-on-left"> Name</label>
                                <div class="col-sm-10">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"></label>
                                        <input type="text" id="deletefullnames" name="deletefullnames" class="form-control" required>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>




                        </div>


                        <input type="hidden" class="form-control" name="deleteuserid" id="deleteuserid">

                    </div>
                    <hr/>
                    {{-- Form Delete Post --}}
                    <div style="padding: 10px;">
                        Are You sure you want to delete?
                    </div>
                    <hr/>
                    <div class="modal-footer">

                        <button type="submit" name="submit" class="btn btn-success">
                            <span id="footer_action_button" class="fa fa-trash"> Delete</span>
                        </button>

                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                            <span class="glyphicon glyphicon"></span>close
                        </button>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type="text/javascript">

        $(document).on('click','.create-modal', function() {
            $('#create').modal('show');
            $('.form-horizontal').show();
            $('.modal-title').text('Add');
        });

        // Show function
        $(document).on('click', '.show-modal', function() {
            $('#show').modal('show');
            $('#i').text($(this).data('id'));
            $('#categoryname').text($(this).data('name'));
            $('#orderid').text($(this).data('order'));
            $('#createdat').text($(this).data('created'));
            $('.modal-title').text('Show Category');
        });


        // function Edit POST
        $(document).on('click', '.edit-modal', function() {
            $('#footer_action_button').text(" Edit");
            $('#footer_action_button').addClass('fa-edit');
            $('#footer_action_button').removeClass('glyphicon-trash');
            $('.actionBtn').addClass('btn-success');
            $('.actionBtn').removeClass('btn-danger');
            $('.actionBtn').addClass('edit');
            $('.modal-title').text('Edit Admin Info');
            $('.form-horizontal').show();
            $('#fid').val($(this).data('id'));
            $('#fullnames').val($(this).data('name'));
            $('#email').val($(this).data('email'));
            $('#phonenumber').val($(this).data('phone'));
            $('#status').val($(this).data('status'));
            $('#role').val($(this).data('role'));

            $('#editModal').modal('show');
        });

        // form Delete function
        $(document).on('click', '.delete-modal', function() {

            $('#deleteuserid').val($(this).data('id'));
            $('#deletefullnames').val($(this).data('name'));
            $("#deletefullnames").prop('disabled', true);

            $('#deleteModal').modal('show');
        });


    </script>

    @include('vendor.sweetalert.cdn')
    @include('vendor.sweetalert.view')

@endsection