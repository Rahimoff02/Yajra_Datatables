@extends('layouts.app')
@section('static')

<?php

use App\Models\brands;
use App\Models\clients;
use App\Models\products;
use App\Models\orders;
use App\Models\staff;
use App\Models\User;

use Illuminate\Support\Facades\Auth;

$stat = products::join('brands','brands.id','=','products.brand_id')
            ->select('products.*')
            ->where('products.user_id','=',Auth::id())
            ->orderBy('products.id','desc')
            ->get();

            $brend = brands::where('user_id','=',Auth::id())->count();
            $client = clients::where('user_id','=',Auth::id())->count();
            $product = products::where('user_id','=',Auth::id())->count();
            $staff = staff::where('user_id','=',Auth::id())->count();           
            $pending = orders::where('orders.tesdiq','=','0')->where('user_id','=',Auth::id())->count();
            $kind = products::where('user_id','=',Auth::id())->groupBy('mehsul')->count();
            $order = orders::where('orders.tesdiq','=','1')->where('user_id','=',Auth::id())->count();

            $cari = orders::join('products','products.id','=','orders.product_id')
            ->select('products.alis','products.satis','orders.*')
            ->where('orders.tesdiq','=','1')
            ->where('orders.user_id','=',Auth::id())
            ->orderBy('orders.id','desc')
            ->get();

            $car = 0;
            $sot = 0;

            foreach ($cari as $value) {
               $al = $value->alish;
               $sat = $value->satish;
               $sot = $value->miqdar;

               $car = $car + (($sat - $al) * $sot);
            }

            $tqazanc = 0;
            $alinma = 0;
            $satilma = 0;
            $stok = 0;
          
            foreach($stat as $info)
            {         
                $alis = $info->alish;
                $satis = $info->satish;
                $stok = $info->stok;
                
                $alinma = $alinma + $alis;
                $satilma = $satilma + $satis;

                $tqazanc = $tqazanc + (($satis - $alis) * $stok);
            }
    
?>


<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{$brend}}</h3>
                <p>Brands</p>
            </div>
            <div class="icon">
                <i class="ion ion-pricetags"></i>
            </div>
            <a href="/brend" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-light">
            <div class="inner">
                <h3>{{$client}}</h3>
                <p>Clients</p>
            </div>
            <div class="icon">
                <i class="ion ion-person"></i>
            </div>
            <a href="/klent" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{$product}}</h3>
                <p>Products</p>
            </div>
            <div class="icon">
                <i class="ion ion-cube"></i>
            </div>
            <a href="/mehsul" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{$order}}</h3>
                <p>New Orders</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="/sifarish" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{$tqazanc}} azn</h3>

                <p>All earnings</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="/sifarish" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{$stok}}</h3>

                <p>Amounts</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="/mehsul" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-dark">
            <div class="inner">
                <h3>{{$alinma}} azn</h3>

                <p>Buying</p>
            </div>
            <div class="icon">
                <i class="ion ion-card"></i>
            </div>
            <a href="/mehsul" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{$satilma}} azn</h3>

                <p>Sellings</p>
            </div>
            <div class="icon">
                <i class="ion ion-cash"></i>
            </div>
            <a href="/mehsul" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{$staff}}</h3>
                <p>Workers</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-stalker"></i>
            </div>
            <a href="/isci" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-secondary">
            <div class="inner">
                <h3>{{$pending}}</h3>

                <p>Pending orders</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="/sifarish" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-light">
            <div class="inner">
                <h3>{{$kind}}</h3>

                <p>Product kinds</p>
            </div>
            <div class="icon">
                <i class="ion ion-cube"></i>
            </div>
            <a href="/mehsul" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{$car}} azn</h3>

                <p>Real Profit</p>
            </div>
            <div class="icon">
                <i class="ion ion-cube"></i>
            </div>
            <a href="/sifarish" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

</div>


@endsection
