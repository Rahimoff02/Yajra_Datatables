<!DOCTYPE html>
<html>

<head>
    <title>Warehouse | Orders</title>
</head>

<body>

    @extends('layouts.app')
    @section('orders')

    <div class="card shadow mb-4">

        <div class="col-md-12 mt-1 mb-2"><button type="button" id="addNewBook" class="btn btn-success float-right">ADD</button>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered" id="datatable-ajax-crud" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Surname</th>
                            <th>Brand</th>
                            <th>Product</th>
                            <th>Buy</th>
                            <th>Sell</th>
                            <th>Stock</th>
                            <th>Orders</th>
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
                                <label for="name" class="col-sm-2 control-label">CLient</label>
                                <div class="col-sm-12">
                                    <select name="client_id" class="form-control" id="client_id">
                                        <option value="">Client select</option>
                                        @foreach($cdata as $cinfo)
                                        <option value="{{$cinfo->id}}">{{$cinfo->ad}} {{$cinfo->soyad}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Product</label>
                                <div class="col-sm-12">
                                    <select name="product_id" class="form-control" id="product_id">
                                        <option value="">Select product</option>
                                        @foreach($pdata as $binfo)
                                        <option value="{{$binfo->id}}">{{$binfo->brend}} {{$binfo->mehsul}}
                                            {{$binfo->stok}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Amount</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="miqdar" name="miqdar"
                                        placeholder="Enter Amount" maxlength="50" required="">
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
                    ajax: "{{ url('ordersdata') }}",
                    columns: [{
                            data: 'id',
                            name: 'id',
                            'visible': false
                        },
                        {
                            data: 'ad',
                            name: 'ad',
                        },
                        {
                            data: 'soyad',
                            name: 'soyad',
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
                            data: 'miqdar',
                            name: 'miqdar'
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
                    $('#id').val('');

                });


                $('body').on('click', '.Edit', function () {

                    var id = $(this).data('id');

                    // ajax
                    $.ajax({
                        type: "POST",
                        url: "{{ url('ordersedit') }}",
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (res) {
                            $('#ajaxBookModel').html("Edit Book");
                            $('#ajax-book-model').modal('show');
                            $('#id').val(res.id);
                            $('#client_id').val(res.client_id);
                            $('#product_id').val(res.product_id);
                            $('#miqdar').val(res.miqdar);
                            $('#image').removeAttr('required');

                        }
                    });

                });

                $('body').on('click', '.Delete', function () {

                    if (confirm("Delete Record?") == true) {
                        var id = $(this).data('id');

              
                        $.ajax({
                            type: "POST",
                            url: "{{ url('ordersdelete') }}",
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            success: function (res) {
                                if (res == 'Order deleted succesfully.') {
                            alert(res)
                                var oTable = $('#datatable-ajax-crud').dataTable();
                                oTable.fnDraw(false);
                            }
                          }
                        });
                    }

                });



                $('body').on('click', '.Accept', function () {

                    if (confirm("Do you want to accept ?") == true) {
                        var id = $(this).data('id');
                        
                        $.ajax({
                            type: "POST",
                            url: "{{ url('orderstesdiq') }}",
                            data: {id: id},
                            dataType: 'json',
                            success: function (res) {
                                if (res =="You don't have enough products to accept this order.") {
                                    alert(res)
                                } else {
                                    var oTable = $('#datatable-ajax-crud').dataTable();
                                    oTable.fnDraw(false);
                                }
                            }
                        });
                    }
                });



                $('body').on('click', '.Cancel', function () {

                    if (confirm("Do you want to delete ?") == true) {
                        var id = $(this).data('id');

                        // ajax
                        $.ajax({
                            type: "POST",
                            url: "{{ url('orderslevg') }}",
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            success: function (res) {
                            if (res == 'Order canceled succesfully.') {
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
                        url: "{{ url('ordersupdate')}}",
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
