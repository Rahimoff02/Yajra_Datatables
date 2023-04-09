<!DOCTYPE html>
<html>

<head>
    <title>Warehouse | Brands</title>
</head>

<body>

    @extends('layouts.app')
    @section('brands')

    <div class="card header">
        <div class="col-md-12 mt-1 mb-2">
            <button type="button" id="addNewBook" class="btn btn-success float-right">ADD</button>
        </div>
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered" id="datatable-ajax-crud" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Image</th>
                            <th>Brand</th>
                            <th>Created at</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
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
                        class="form-horizontal" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id">

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Brand Image</label>
                            <div class="col-sm-6 pull-left">
                                <input type="file" class="form-control" id="image" name="image" required="">
                            </div>
                            <div class="col-sm-6 pull-right"><br>
                                <img id="preview-image"
                                    src="https://www.feedough.com/wp-content/uploads/2016/09/brand-image.png"
                                    alt="preview image" style="max-height: 150px;">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Brand Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="brend" name="brend"
                                    placeholder="Enter Brand Name" maxlength="50" required="">
                            </div>
                        </div>

                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="btn-save" value="addNewBook">Save
                                changes
                            </button>
                        </div>
                    </form>
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
                    ajax: "{{ url('/brands') }}",
                    columns: [{
                            data: 'id',
                            name: 'id',
                            'visible': false
                        },
                        {
                            data: 'image',
                            name: 'image'
                        },
                        {
                            data: 'brend',
                            name: 'brend'
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
                    ],
                    dom: 'Bfrltip',
                    responsive: true,
                    lengthChange: true,
                    buttons: ['copy', 'excel', 'pdf', 'print', 'colvis']
                });


                $('#addNewBook').click(function () {
                    $('#addEditBookForm').trigger("reset");
                    $('#ajaxBookModel').html("Add Brand");
                    $('#ajax-book-model').modal('show');
                    $("#image").attr("required", "true");
                    $('#id').val('');
                    $('#preview-image').attr('src',
                        'https://www.feedough.com/wp-content/uploads/2016/09/brand-image.png');


                });

                $('body').on('click', '.edit', function () {
                    var id = $(this).data('id');

                    $.ajax({
                        type: "POST",
                        url: "{{ url('brandsedit') }}",
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (res) {
                            $('#ajaxBookModel').html("Edit Brand");
                            $('#ajax-book-model').modal('show');
                            $('#id').val(res.id);
                            $('#brend').val(res.brend);
                            $('#image').removeAttr('required');
                            document.getElementById('preview-image').src = res.image

                        }
                    });

                });

                $('body').on('click', '.delete', function () {

                    if (confirm("Delete Record ?") == true) {
                        var id = $(this).data('id');

                        $.ajax({
                            type: "POST",
                            url: "{{ url('brandsdelete') }}",
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            success: function (res) {
                                if (res == 'Brand deleted succesfully.') {
                                    var oTable = $('#datatable-ajax-crud').dataTable();
                                    oTable.fnDraw(false);
                                } else {
                                    (res == "This brand exist in brand's table.")
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
                        url: "{{ url('brandsupdate')}}",
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
