<!DOCTYPE html>
<html>

<head>
    <title>Admin | Ajax</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body>

    @extends('layouts.app')
    @section('admin')

    <div class="card shadow mb-4">

        <div class="col-md-12 mt-1 mb-2"><button type="button" id="addNewBook" class="btn btn-success">Add</button>
        </div>

        <div class="card-header py-3">
            <h6 class="font-weight-bold text-primary">DataTables Admin</h6>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered" id="datatable-ajax-crud" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Surname</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Created at</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>

        </div>
        <!-- boostrap add and edit book model -->
        <div class="modal fade" id="ajax-book-model" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="ajaxBookModel"></h4>
                    </div>
                    <div class="modal-body">
                        <form action="javascript:void(0)" id="addEditBookForm" name="addEditBookForm"
                            class="form-horizontal" method="POST">
                            <input type="hidden" name="id" id="id">

                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Name</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Enter Appointment" maxlength="50" required="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Surname</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="surname" name="surname"
                                        placeholder="Enter Amount" maxlength="50" required="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="email" name="email"
                                        placeholder="Enter Amount" maxlength="50" required="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Phone</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        placeholder="Enter phone number" maxlength="50" required="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Password</label>
                                <div class="col-sm-12">
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Enter password" maxlength="50" required="">
                                </div>
                            </div>

                           <!--  <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">New password</label>
                                <div class="col-sm-12">
                                    <input type="password" class="form-control" id="newpass" name="newpass"
                                        placeholder="Enter new password" maxlength="50" required="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">New Password</label>
                                <div class="col-sm-12">
                                    <input type="password" class="form-control" id="newpass" name="newpass"
                                        placeholder="Enter password" maxlength="50" required="">
                                </div>
                            </div>
                        -->
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary" id="btn-save" value="addNewBook">Save
                                    changes
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">

                    </div>
                </div>
            </div>
        </div>
        <!-- end bootstrap model -->

        <script type="text/javascript">
            $(document).ready(function () {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('#image').change(function () {

                    let reader = new FileReader();

                    reader.onload = (e) => {

                        $('#preview-image').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(this.files[0]);

                });

                $('#datatable-ajax-crud').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ url('admindata') }}",
                    columns: [{
                            data: 'id',
                            name: 'id',
                            'visible': false
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'surname',
                            name: 'surname'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'phone',
                            name: 'phone'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false
                        },
                    ],
                    order: [
                        [0, 'desc']
                    ]
                });


                $('#addNewBook').click(function () {
                    $('#addEditBookForm').trigger("reset");
                    $('#ajaxBookModel').html("Add User");
                    $('#ajax-book-model').modal('show');
                    $('#id').val('');


                });

                $('body').on('click', '.edit', function () {

                    var id = $(this).data('id');

                    // ajax
                    $.ajax({
                        type: "POST",
                        url: "{{ url('adminedit') }}",
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (res) {
                            $('#ajaxBookModel').html("Edit User");
                            $('#ajax-book-model').modal('show');
                            $('#id').val(res.id);
                            $('#name').val(res.name);
                            $('#surname').val(res.surname);
                            $('#email').val(res.email);
                            $('#phone').val(res.phone);
                            $('#password').val(res.password);

                        }
                    });

                });

                $('body').on('click', '.delete', function () {

                    if (confirm("Delete Record?") == true) {
                        var id = $(this).data('id');

                        // ajax
                        $.ajax({
                            type: "POST",
                            url: "{{ url('admindelete') }}",
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            success: function (res) {
                                if (res == 'User deleted succesfully.') {
                            alert(res)
                                var oTable = $('#datatable-ajax-crud').dataTable();
                                oTable.fnDraw(false);
                            }
                          }
                        });
                    }

                });

                $('body').on('click', '.blok', function () {

                    if (confirm("Do you want to block this user ?") == true) {
                        var id = $(this).data('id');

                        // ajax
                        $.ajax({
                            type: "POST",
                            url: "{{ url('adminblok') }}",
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            success: function (res) {
                                if (res == 'User blocked succesfully.') {
                            alert(res)
                                    var oTable = $('#datatable-ajax-crud').dataTable();
                                    oTable.fnDraw(false);
                            }
                          }
                        });
                    }
                });

                $('body').on('click', '.unblok', function () {

                if (confirm("Do you want to unblock this user ?") == true) {
                    var id = $(this).data('id');

                    // ajax
                    $.ajax({
                        type: "POST",
                        url: "{{ url('adminunblok') }}",
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (res) {
                            if (res == 'User unblocked succesfully.') {
                            alert(res)
                                var oTable = $('#datatable-ajax-crud').dataTable();
                                oTable.fnDraw(false);
                        }
                      }
                    });
                }
                });

                $('#addEditBookForm').submit(function (e) {

                    e.preventDefault();

                    var formData = new FormData(this);

                    $.ajax({
                        type: 'POST',
                        url: "{{ url('adminupdate')}}",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: (data) => {
                            $("#ajax-book-model").modal('hide');
                            var oTable = $('#datatable-ajax-crud').dataTable();
                            oTable.fnDraw(false);
                            $("#btn-save").html('Submit');
                            $("#btn-save").attr("disabled", false);
                        },
                        error: function (data) {
                            console.log(data);
                        }
                    });
                });
            });

        </script>
    </div>

    @endsection

</body>

</html>
