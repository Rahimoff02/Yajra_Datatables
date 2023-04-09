<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Warehouse | User Profile</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.6.1/toastify.js"
        integrity="sha512-MnKz2SbnWiXJ/e0lSfSzjaz9JjJXQNb2iykcZkEY2WOzgJIWVqJBFIIPidlCjak0iTH2bt2u1fHQ4pvKvBYy6Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.6.1/toastify.min.css"
        integrity="sha512-UiKdzM5DL+I+2YFxK+7TDedVyVm7HMp/bN85NeWMJNYortoll+Nd6PU9ZDrZiaOsdarOyk9egQm6LOJZi36L2g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

@extends('layouts.app')
@section('profile')

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">

                        <!-- Profile Image -->
                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img src="{{url(auth()->user()->foto)}}"
                                        style="width:200px; height:120px; border-radius: 10px;"
                                        alt="User profile picture">
                                </div>

                                <h3 class="profile-username text-center">{{auth()->user()->name}}
                                    {{auth()->user()->surname}}</h3>

                                <!--    <p class="text-muted text-center">Software Engineer   </p>-->

                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <b>Created at:</b> <a class="float-right">{{auth()->user()->created_at}}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Following</b> <a class="float-right">543</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Friends</b> <a class="float-right">13,287</a>
                                    </li>
                                </ul>

                                <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
                            </div>
                            <!-- /.card-body -->
                        </div>



                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">About Me</h3>
                            </div>

                            <div class="card-body">
                                <strong><i class="fas fa-book mr-1"></i> Education</strong>

                                <p class="text-muted">
                                    B.S. in Computer Science from the University of Tennessee at Knoxville
                                </p>

                                <hr>

                                <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                                <p class="text-muted">Malibu, California</p>

                                <hr>

                                <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>

                                <p class="text-muted">
                                    <span class="tag tag-danger">UI Design</span>
                                    <span class="tag tag-success">Coding</span>
                                    <span class="tag tag-info">Javascript</span>
                                    <span class="tag tag-warning">PHP</span>
                                    <span class="tag tag-primary">Node.js</span>
                                </p>

                                <hr>

                                <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>

                                <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam
                                    fermentum enim neque.</p>
                            </div>

                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-9">
                        <div class="card">

                            <body id="page-top">
                                <div id="content-wrapper" class="d-flex flex-column">
                                    <div id="content">
                                        <!-- Container Fluid-->
                                        <div class="container-fluid" id="container-wrapper">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <!-- Form Basic -->

                                                    <div
                                                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                                        <h6 class="m-0 font-weight-bold text-primary">
                                                            Profile update</h6>
                                                    </div>

                                                    @if($errors->any())
                                                    @foreach($errors->all() as $sehv)
                                                    {{$sehv}}<br><br>
                                                    @endforeach
                                                    @endif

                                                    <script>
                                                        @if(session('message'))
                                                        Toastify({
                                                            text: "{{ Session::get('message') }}",
                                                            duration: 3000,
                                                        }).showToast();
                                                        @endif

                                                    </script>

                                                    <div class="card-body">
                                                        <form method="post" action="/profile"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="form-group">
                                                                <label>File upload</label><br>
                                                                <div class="custom-file">
                                                                    <input type="file" name="foto"
                                                                        class="custom-file-input" id="customFile">
                                                                    <label class="custom-file-label" for="customFile"
                                                                        value="{{auth()->user()->foto}}">Choose
                                                                        file</label>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1">Name</label>
                                                                <input type="text" name="name" class="form-control"
                                                                    id="exampleInputPassword1" placeholder="Your name"
                                                                    value="{{auth()->user()->name}}">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1">Surname</label>
                                                                <input type="text" name="surname" class="form-control"
                                                                    id="exampleInputPassword1"
                                                                    placeholder="Your surname"
                                                                    value="{{auth()->user()->surname}}">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="exampleInputphone">Phone</label>
                                                                <input type="text" name="phone" class="form-control"
                                                                    id="exampleInputphone"
                                                                    placeholder="Your phone number"
                                                                    value="{{auth()->user()->phone}}">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Email
                                                                    address</label>
                                                                <input type="email" name="email"
                                                                    value="{{auth()->user()->email}}"
                                                                    class="form-control" id="exampleInputEmail1"
                                                                    aria-describedby="emailHelp"
                                                                    placeholder="Enter email">
                                                                <small id="emailHelp" class="form-text text-muted">We'll
                                                                    never share your
                                                                    email with anyone else.</small>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1">Password</label>
                                                                <input type="password" class="form-control"
                                                                    name="password" id="exampleInputPassword1"
                                                                    placeholder="Password">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1">Password
                                                                    again</label>
                                                                <input type="password" name="newpass"
                                                                    class="form-control" id="exampleInputPassword1"
                                                                    placeholder="Password again">
                                                                <small id="emailHelp" class="form-text text-muted">Write
                                                                    password if you want to reset
                                                                    new.</small>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1">Password
                                                                    again</label>
                                                                <input type="password" name="parol_t"
                                                                    class="form-control" id="exampleInputPassword1"
                                                                    placeholder="Password confirm">
                                                                <small id="emailHelp" class="form-text text-muted">Write
                                                                    your new password again.</small>
                                                            </div>

                                                            <button type="submit"
                                                                class="btn btn-primary">Update</button>
                                                        </form>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- jQuery -->
    <script src="{{url('../../plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{url('../../plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    @endsection

</body>

</html>
