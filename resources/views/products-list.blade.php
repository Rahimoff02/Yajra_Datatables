<!DOCTYPE html>
<html>

<head>
    <title>Warehouse | Products</title>
</head>

<body>

    @extends('layouts.app')
    @section('products')

    <div class="card shadow mb-4">

        <div class="col-md-12 mt-1 mb-2"><button type="button" id="addNewBook" class="btn btn-success float-right">ADD</button>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered" id="datatable-ajax-crud" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Image</th>
                            <th>Brand</th>
                            <th>Product</th>
                            <th>Buy</th>
                            <th>Sell</th>
                            <th>Stock</th>
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
                            class="form-horizontal" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" id="id">

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Image</label>
                                <div class="col-sm-6 pull-left">
                                    <input type="file" class="form-control" id="image" name="image" required="">
                                </div>
                                <div class="col-sm-6 pull-right"><br>
                                    <img id="preview-image"
                                        src="https://www.riobeauty.co.uk/images/product_image_not_found.gif"
                                        alt="preview image" style="max-height: 130px;">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Brand</label>
                                <div class="col-sm-12">
                                    <select name="brand_id" class="form-control" id="brand_id">
                                        <option value="">Brand select</option>
                                        @foreach($bdata as $info)
                                        <option value="{{$info->id}}">{{$info->brend}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Product</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="mehsul" name="mehsul"
                                        placeholder="Enter Product" maxlength="50" required="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Buy</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="alis" name="alis"
                                        placeholder="Enter Amount" maxlength="50" required="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Sell</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="satis" name="satis"
                                        placeholder="Enter Amount" maxlength="50" required="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Stock</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="stok" name="stok"
                                        placeholder="Enter stock" maxlength="50" required="">
                                </div>
                            </div>

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
                    ajax: "{{ url('productsdata') }}",
                    columns: [{
                            data: 'id',
                            name: 'id',
                            'visible': false
                        },
                        {
                            data: 'image',
                            name: 'image',
                            orderable: false
                        },
                        {
                            data: 'brend',
                            name: 'brend'
                        },
                        {
                            data: 'mehsul',
                            name: 'mehsul'
                        },
                        {
                            data: 'alis',
                            name: 'alis'
                        },
                        {
                            data: 'satis',
                            name: 'satis'
                        },
                        {
                            data: 'stok',
                            name: 'stok'
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
                    responsive:true,
                    lengthChange: true,
                    buttons: [ 'copy', 'excel', 'pdf', 'print','colvis' ]
                });


                $('#addNewBook').click(function () {
                    $('#addEditBookForm').trigger("reset");
                    $('#ajaxBookModel').html("Add Book");
                    $('#ajax-book-model').modal('show');
                    $("#image").attr("required", "true");
                    $('#id').val('');
                    $('#preview-image').attr('src',
                        'https://pngimage.net/wp-content/uploads/2018/06/productos-png-5.png');


                });

                $('body').on('click', '.edit', function () {

                    var id = $(this).data('id');

                    // ajax
                    $.ajax({
                        type: "POST",
                        url: "{{ url('productsedit') }}",
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (res) {
                            $('#ajaxBookModel').html("Edit Book");
                            $('#ajax-book-model').modal('show');
                            $('#id').val(res.id);
                            $('#brand_id').val(res.brand_id);
                            $('#mehsul').val(res.mehsul);
                            $('#alis').val(res.alis);
                            $('#satis').val(res.satis);
                            $('#stok').val(res.stok);
                            $('#image').removeAttr('required');

                        }
                    });

                });

                $('body').on('click', '.delete', function () {

                    if (confirm("Delete Record?") == true) {
                        var id = $(this).data('id');

                        // ajax
                        $.ajax({
                            type: "POST",
                            url: "{{ url('productsdelete') }}",
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            success: function (res) {
                            if (res == 'Product deleted succesfully.') {
                            alert(res)
                            var oTable = $('#datatable-ajax-crud').dataTable();
                            oTable.fnDraw(false);
                            }
                            else {
                            (res == "This product exist in order's table.")
                            alert(res)
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
                        url: "{{ url('productsupdate')}}",
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
