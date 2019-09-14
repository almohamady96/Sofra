@extends('admin.layouts.main',[
                                'page_header'       => 'تطبيق أكلات',
                                'page_description'  => 'لوحة التحكم'
                                ])
@inject('restaurant','App\Restaurant')
@inject('order','App\Order')
@inject('client','App\Client')
@inject('offer','App\Offer')

<?php
$usersCount = $client->all()->count();
$ordersCount = $order->where('status','!=','pending')->get()->count();
$restaurantCount = $restaurant->all()->count();
$offerCount = $offer->all()->count();

?>
@section('content')
    <!-- Info boxes -->
    <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-cutlery"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">عدد المطاعم</span>
                    <span class="info-box-number">{{$restaurantCount}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-tasks"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">عدد الطلبات المكتملة</span>
                    <span class="info-box-number">{{$ordersCount}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-users"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">عدد المستخدمين</span>
                    <span class="info-box-number">{{$usersCount}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

        <!-- /.col -->
        <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-users"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">عدد العروض</span>
                    <span class="info-box-number">{{$offerCount}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

    </div>
    <!-- /.row -->

    <!-- Default box -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"></h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                    <i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                        title="Remove">
                    <i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">

            <div class="row">

                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>{{$client->count()}}</h3>

                            <p>client</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>{{$offer->count()}}</h3>

                            <p>Offer</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>{{$restaurant->count()}}</h3>

                            <p>Restaurant</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>{{$order->count()}}</h3>

                            <p>Order</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-flag-o"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>


            </div>




            {{--
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            You are logged in!
            --}}
        </div>
        <!-- /.box-body -->
        <div class="box-footer">

        </div>
        <!-- /.box-footer-->
    </div>
    <!-- /.box -->

@endsection
