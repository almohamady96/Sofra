@extends('admin.layouts.main',[
                                'page_header'       => ' عرض الطلبات',
                                'page_description'  => 'عرض'
                                ])
@inject('restaurant','App\Restaurant')
@inject('order_id','App\Order')

@php
@endphp

<?php
$restaurants = $restaurant->pluck('name','id')->toArray();
?>
@section('content')


    <div class="box box-primary">
        <div class="box-header">
            <div class="clearfix"></div>
            <br>
            <div class="restaurant-filter">
            <div class="row">
                {!! Form::open([
                    'method' => 'GET'
                ]) !!}
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">&nbsp;</label>
                        {!! Form::text('order_id', request()->input('order_id'),[
                            'class' => 'form-control',
                            'placeholder' => 'رقم الطلب'
                        ]) !!}
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">&nbsp;</label>
                        {!! Form::select('restaurant_id',$restaurants,request()->input('restaurant_id'),[
                            'class' => 'form-control',
                            'placeholder' => 'كل المطاعم'
                        ]) !!}
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">&nbsp;</label>
                        {!! Form::select('status',
                            [
                                'pending' => 'قيد التنفيذ',
                                'accepted' => 'تم تأكيد الطلب',
                                'rejected' => 'مرفوض',
                            ],request()->input('status'),[
                                'class' => 'form-control',
                                'placeholder' => 'كل حالات الطلبات'
                        ]) !!}
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">&nbsp;</label>
                        {!! Form::text('from',request()->input('from'),[
                            'class' => 'form-control datepicker',
                            'placeholder' => 'من'
                        ]) !!}
                    </div>
                </div>
                {{--
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">&nbsp;</label>
                        {!! Form::text('to',\Request::input('to'),[
                            'class' => 'form-control datepicker',
                            'placeholder' => 'إلى'
                        ]) !!}
                    </div>
                </div>
                --}}
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">&nbsp;</label>
                        <button class="btn btn-flat btn-block btn-primary">بحث</button>
                    </div>
                </div>
            </div>
                {!! Form::close() !!}
            </div>
            <div class="pull-right">
                <a href="{{url(route('order.create'))}}" class="btn btn-danger"><i class="fa fa-plus"> &nbsp انشاء طلب جديد</i></a>
                {{-- <a href="{{url('admin/order/create')}}" class="btn btn-primary">
                     <i class="fa fa-plus"></i> مطعم جديد
                 </a>--}}
                {{--
                            <a href="trashed" class="btn btn-danger" style="float: right">Show Trashed value</a>
                --}}
            </div>
        </div>

        <div class="box-body">
        @include('flash::message')
            @if(count($order))
            <div class="table-responsive">
                <table class="table table-bordered danger">
                    <thead style="text-align: center;font-size: 12px;">
                    <th>#</th>
                    <th>رقم الطلب</th>
                    <th> اسم المطعم</th>
                    <th>الإجمالى</th>
                    <th>ملاحظات</th>
                    <th>الحالة</th>
                    <th>وقت الطلب</th>
                    <th>العنوان</th>
                    <th>السعر</th>
                    <th>هاتف العميل</th>
                    <th>اسم العميل</th>
                    <th>العموله</th>
                    <th>الصافى</th>
                    <th class="text-center">عرض</th>
                    </thead>
                    <tbody style="text-align: center;font-size: 12px;">
                    @php $count = 1; @endphp
                    @foreach($order as $ord)
                        <tr id="removable{{$ord->id}}">
                            <td>{{$count}}</td>
                           {{-- <td>{{$loop->iteration}}</td>--}}
                           <td><a href="{{url('admin/order/'.$ord->id)}}">#{{$ord->id}}</a></td>
                            <td>@if(count([$ord->restaurant])){{$ord->restaurant->name}}@endif</td>
                           {{-- <td>{{optional($record->restaurant)->name}}</td>--}}
                            <td>{{$ord->total}}</td>
                            <td>{{$ord->note}}</td>
                            <td>{{$ord->status}}</td>
                            <td>{{$ord->created_at}}</td>
                            <td>{{$ord->address}}</td>
                            <td>{{$ord->cost}}</td>
                            <td>{{optional($ord->client)->phone}}</td>
                            <td>{{optional($ord->client)->name}}</td>
                            <td>{{$ord->commission}}</td>
                            <td>{{$ord->net}}</td>
                            <td>
                                <a href="{{url('admin/order/'.$ord->id)}}" class="btn btn-success btn-block">عرض الطلب</a>
                               {{--<a href="{{url(route('order.show'))}}" class="btn btn-success btn-block">عرض الطلب</a>--}}
                            </td>
                        </tr>
                        @php $count ++; @endphp
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                {!! $order->appends([
                    'order_id' => request()->input('order_id'),
                    'restaurant_id' =>  request()->input('restaurant_id'),
                    'status' =>  request()->input('status'),
                    'created_at' => request()->input('created_at'),
                   /* 'to' => \Request::input('to'),*/
                ])->links() !!}
            </div>
            @else
                <div class="col-md-4 col-md-offset-4">
                    <div class="alert alert-info bg-blue text-center">لا يوجد طلبات</div>
                </div>
            @endif
        </div>
    </div>

@endsection