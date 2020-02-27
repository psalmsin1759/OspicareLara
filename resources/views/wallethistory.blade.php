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

                            <h4 class="card-title">Wallet Fund History</h4>
                            <div class="toolbar">
                                <!--        Here you can write extra buttons/actions for the toolbar
                                             -->
                            </div>

                            <div class="material-datatables">


                                <!--<table id="sample_1" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">-->

                                <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">

                                    <thead>
                                    <tr>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Amount</th>
                                        <th class="text-center">Card Number</th>
                                        <th class="text-center">Payment Gateway</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Created At</th>
                                        <th class="disabled-sorting text-right">Action</th>
                                    </tr>
                                    </thead>



                                    <tbody>

                                    @foreach($transaction as $item)
                                        <tr>
                                            <td class="text-center"> {{$item->nurse_name}} </td>
                                            <td class="text-center"> {{$item->amount}} </td>
                                            <td class="text-center"> {{$item->card_number}} </td>
                                            <td class="text-center"> {{$item->payment_gateway}} </td>
                                            <td class="text-center"> {{$item->response_message}} </td>
                                            <td class="text-center"> {{$item->created_at}} </td>
                                            <td class="td-actions text-right">


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

                <form method="POST" action="{{url("/hospital/admin/add")}}" class="form-horizontal" role="form">

                    {{ csrf_field() }}

                    <div class="modal-body">




                        <div class="form-group row add">
                            <label class="control-label col-sm-2" for="category">Full Names :</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control"  name="fullnames"
                                       placeholder="Your Full Names" required>
                                <span class="help-block">Enter Full Names</span>
                                <p class="error text-center alert alert-danger hidden"></p>
                            </div>
                        </div>

                        <div class="form-group row add">
                            <label class="control-label col-sm-2" for="category">Email :</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control"  name="email"
                                       placeholder="Enter Email" required>
                                <span class="help-block">Enter Email</span>
                                <p class="error text-center alert alert-danger hidden"></p>
                            </div>
                        </div>


                        <div class="form-group row add">
                            <label class="control-label col-sm-2" for="category">Password :</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control"  name="password"
                                       placeholder="Enter Password" required>
                                <span class="help-block">Enter Password</span>
                                <p class="error text-center alert alert-danger hidden"></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="body">Status:</label>
                            <div class="col-sm-10">

                                <select id="status" name="status" style="width: 200px; height: 35px; padding:5px"  data-style="select-with-transition" title="Single Select" data-size="7">
                                    <option value="enable">Enable</option>
                                    <option value="disable">Disable</option>
                                </select>

                            </div>
                        </div>







                    </div>

                    <div class="modal-footer">

                        <button class="btn btn-success" type="submit" id="add">
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
                <form method="post" action="{{url("/hospital/admin/edit")}}" class="form-horizontal" role="modal">
                    <div class="modal-body">

                        {{ csrf_field() }}

                        <input type="hidden" class="form-control" name="id" id="fid">

                        <div class="form-group row add">
                            <label class="control-label col-sm-2" for="category">Full Names :</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="fullnames"  name="fullnames"
                                       placeholder="Your Full Names" required>
                                <span class="help-block">Enter Full Names</span>
                                <p class="error text-center alert alert-danger hidden"></p>
                            </div>
                        </div>

                        <div class="form-group row add">
                            <label class="control-label col-sm-2" for="category">Email :</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="email"  name="email"
                                       placeholder="Enter Email" required>
                                <span class="help-block">Enter Email</span>
                                <p class="error text-center alert alert-danger hidden"></p>
                            </div>
                        </div>





                        <div class="form-group">
                            <label class="control-label col-sm-2" for="body">Status:</label>
                            <div class="col-sm-10">

                                <select id="status"  name="status" style="width: 200px; height: 35px; padding:5px"  data-style="select-with-transition" title="Single Select" data-size="7">
                                    <option value="enable">Enable</option>
                                    <option value="disable">Disable</option>
                                </select>

                            </div>
                        </div>







                    </div>
                    <div class="modal-footer">

                        <button type="submit" class="btn actionBtn">
                            <span id="footer_action_button" class="fa"></span>
                        </button>

                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                            <span class="glyphicon glyphicon"></span>close
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
                    <h4>Delete Administrator</h4>
                </div>
                <hr/>
                <form method="post" action="{{url("/hospital/admin/delete")}}"  role="modal">
                    {{ csrf_field() }}

                    <div class="modal-body">

                        <div class="card-content">
                            <div class="row">
                                <label class="col-sm-2 label-on-left">Name</label>
                                <div class="col-sm-10">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"></label>
                                        <input type="text" id="name" name="name" class="form-control" required>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>



                        </div>


                        <input type="hidden" class="form-control" name="id" id="fd">

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
            $('.modal-title').text('Add Administrator');
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

            $('#fd').val($(this).data('id'));
            $('#name').val($(this).data('name'));
            $("#name").prop('disabled', true);

            $('#deleteModal').modal('show');
        });


    </script>

    @include('vendor.sweetalert.cdn')
    @include('vendor.sweetalert.view')

@endsection