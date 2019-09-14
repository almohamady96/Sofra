@extends('admin.layouts.main',[
								'page_header'		=> 'العمليات المالية',
								'page_description'	=> 'عرض العمليات'
								])
@inject('restaurant','App\Restaurant')
<?php
$restaurants = $restaurant->pluck('name','id')->toArray();
?>
@section('content')
    <div class="box box-primary">
        <div class="box-header">
            <div class="pull-right">
                <a href="{{url('admin/transaction/create')}}" class="btn btn-primary">
                    <i class="fa fa-plus"></i>  إضافة عملية مالية
                </a>
            </div>
        </div>
        <div class="box-body">
            @include('flash::message')
            <div class="filter">
                {!! Form::open([
                            'action'=>'TransactionController@index',
                            'id'=>'myForm',
                            'role'=>'form',
                            'method'=>'GET',
                            ])!!}
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">&nbsp;</label>
                            {!! Form::select('restaurant_id',$restaurants,request()->input('restaurant_id'),[
                                'class' => 'form-control',
                                'placeholder' => 'كل المطاعم'
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">&nbsp;</label>
                            <button type="submit" class="btn btn-flat bg-navy btn-block"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            @if(!empty($transactions))
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <th>#</th>
                        <th>اسم المطعم</th>
                        <th>تكلفه مبيعات المطعم</th>
                        <th>العموله</th>
                        <th>المبلغ المدفوع او السداد</th>
                        <th>   الباقي</th>
                        <th>  بيان العملية</th>
                        <th class="text-center">تعديل</th>
                        <th class="text-center">حذف</th>
                        </thead>
                        <tbody>
                        @php $count = 1; @endphp
                        @foreach($transactions as $transaction)
                            <tr id="removable{{$transaction->id}}">
                                <td>{{$count}}</td>
                                <td>{{(count([$transaction->restaurant])) ? $transaction->restaurant->name : ''}}</td>
                                <td>{{$transaction->restaurant_sales_cost}}</td>
                                <td>{{$transaction->commission}}</td>
                                <td>{{$transaction->pay_off}}</td>
                                <td>{{$transaction->remaning}}</td>
                                <td>{{$transaction->notes}}</td>
                                <td class="text-center">
                                    {{--
                                    <a href="transaction/{{$transaction->id}}/edit" class="btn btn-xs btn-success">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    --}}
                                <a href="{{url(route('transaction.edit' , $transaction->id))}}" class="btn btn-success btn-xs"><i class="fa fa-edit"></i></a>

                                </td>
                                <td class="text-center">
                                    {!!Form::open([
                                      'action' => ['TransactionController@destroy',$transaction->id ],
                                      'method' => 'delete'
                                      ])!!}
                                    <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-trash-o"></i></button>
                                    {!!Form::close()!!}
                                </td>
                            </tr>
                            @php $count ++; @endphp
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="text-center">
                    {!! $transactions->appends([
                    'restaurant_id' =>request()->input('restaurant_id'),
                ])->render() !!}
                </div>
            @else
                <div class="col-md-4 col-md-offset-4">
                    <div class="alert alert-info bg-blue text-center">لا يوجد عمليات</div>
                </div>
            @endif
        </div>
    </div>
@stop