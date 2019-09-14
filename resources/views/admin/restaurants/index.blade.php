@inject('city','App\City')
@inject('user','App\User')
@inject('res','App\Restaurant')

@php
    $cities = $city->pluck('name','id')->toArray();
    $restaurant = $res->pluck('name','id')->toArray();
@endphp

<style>
    span.select2-container {
        z-index: 10050;
        width: 100% !important;
        padding: 0;
    }

    .select2-container .select2-search--inline {
        float: left;
        width: 100%;
    }

    .restaurant-filter span.select2-container {
        z-index: 999;
        width: 100% !important;
        padding: 0;
    }

    /*.modal-open .modal {*/
    /*overflow-x: hidden;*/
    /*overflow-y: auto;*/
    /*z-index: 99999;*/
    /*}*/
</style>

@extends('admin.layouts.main',[
								'page_header'		=> 'المطاعم',
								'page_description'	=> 'عرض المطاعم'
								])
@section('content')
    <div class="box box-primary">
        <div class="box-header">
            <div class="clearfix"></div>
            <br>
            <div class="restaurant-filter">
                {!! Form::open([
                'method' => 'get'
                ]) !!}
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::select('name',$restaurant,request()->input('name'),[
                            'placeholder' => 'اسم المطعم',
                            'class' => 'form-control'
                            ]) !!}
                        </div>
                    </div>
                    {{--
                    <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::text('name',request()->input('name'),[
                                'placeholder' => 'اسم المطعم',
                                'class' => 'form-control'
                                ]) !!}
                            </div>
                        </div>
                    --}}
                    <div class="col-md-3">

                        <div class="form-group">
                            {!! Form::select('city_id',$cities,request()->input('city_id'),[
                            'class' => 'select2 form-control',
                            'placeholder' => 'المدينة'
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        {{-- 'soon' => 'قريبا', --}}
                        <div class="form-group">
                            {!! Form::select('status',['open' => 'مفتوح', 'close' => 'مغلق'],request()->input('status'),[
                            'class' => 'select2 form-control',
                            'placeholder' => 'حالة المطعم'
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <button class="btn btn-primary btn-block" type="submit"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            <div class="pull-right">
                <a href="{{url(route('restaurant.create'))}}" class="btn btn-danger"><i class="fa fa-plus"> &nbsp انشاء مطعم جديد</i></a>
               {{-- <a href="{{url('admin/client/create')}}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> مطعم جديد
                </a>--}}
            </div>
        </div>
        <div class="box-body">
            @include('flash::message')
            @if(count($restaurants) > 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead style="text-align: center">
                        <th>#</th>
                        <th>اسم المطعم</th>
                        <th>المدينة</th>
                        <th>الايميل</th>
                        <th>اقل سعر</th>
                        <th>تكلفه التوصيل </th>
                        <th>رقم الواتس</th>
                        <th>رقم الهاتف </th>
                        <th>طريقه الدفع </th>
                        {{--<th class="text-center">العمولات المستحقة</th>--}}
                        <th class="text-center">حالة المطعم</th>
                        <th class="text-center">تفعيل / إيقاف</th>
                        <th class="text-center">حذف</th>
                        </thead>
                        <tbody style="text-align: center">
                        @php $count = 1; @endphp
                        @foreach($restaurants as $restaurant)
                            <tr id="removable{{$restaurant->id}}">
                                <td>{{$count}}</td>
                                {{--<td>{{$loop->iteration}}</td>--}}
                                <td><a style="cursor: pointer" data-toggle="modal" data-target="#myModal{{$restaurant->id}}">{{$restaurant->name}}</a></td>
                                <td>
                                    @if(count([$restaurant->region]))
                                        {{$restaurant->region->name}}
                                        @if(count([$restaurant->region->city]))
                                            {{$restaurant->region->city->name}}
                                        @endif
                                    @endif
                                </td>
                              {{--  <td>{{optional($record->region)->name}}</td>--}}
                                <td>{{$restaurant->email}}</td>
                                <td>{{$restaurant->min_price}}</td>
                                <td>{{$restaurant->delivery_cost}}</td>
                                <td>{{$restaurant->phone}}</td>
                                <td>{{$restaurant->whatsapp}}</td>
                                <td>{{$restaurant->delivery_way}}</td>
                                {{--
                                <td class="text-center">
                                    {{ $restaurant->total_commissions - $restaurant->total_payments }}
                                </td>--}}
                                <td class="text-center">
                                   {{-- @if($restaurant->status == 'open')--}}
                                        @if($restaurant->activated)
                                        <i class="fa fa-circle-o text-green"></i> مفتوح
                                    @else
                                        <i class="fa fa-circle-o text-red"></i> مغلق
                                    @endif

                                </td>
                                <td class="text-center">
                                    @if($restaurant->activated)
                                        <a href="restaurant/{{$restaurant->id}}/de-activate" class="btn btn-xs btn-danger"><i class="fa fa-close"></i> إيقاف</a>
                                    @else
                                        <a href="restaurant/{{$restaurant->id}}/activate" class="btn btn-xs btn-success"><i class="fa fa-check"></i> تفعيل</a>
                                    @endif
                                </td>
                                <td class="text-center">
                                    {!!Form::open([
                                      'action' => ['RestaurantController@destroy',$restaurant->id ],
                                      'method' => 'delete'
                                      ])!!}
                                    <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-trash-o"></i></button>
                                    {!!Form::close()!!}
                                </td>

                            </tr>

                            <!-- Modal -->
                            <div class="modal fade" id="myModal{{$restaurant->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">{{$restaurant->name}}</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <ul>
                                                        <li> الايميل للتواصل :  {{$restaurant->email}}</li>
                                                        <li> المدينة :
                                                            @if(count([$restaurant->region]))
                                                                {{$restaurant->region->name}}
                                                                @if(count([$restaurant->region->city]))
                                                                    {{$restaurant->region->city->name}}
                                                                @endif
                                                            @endif
                                                        </li>
                                                        <li> الحد الأدنى للطلبات : {{$restaurant->min_price}}</li>
                                                        <li> الحاله : {{$restaurant->status}}</li>
                                                        <hr>
                                                        <li>إجمالي الطلبات : {{$restaurant->total_orders_amount}}</li>
                                                        <li>إجمالي العمولات المستحقة : {{$restaurant->total_commissions}}</li>
                                                        <li>إجمالي المبالغ المسددة : {{$restaurant->total_payments}}</li>
                                                        <li>باقي العمولات المستحقة : {{$restaurant->total_commissions - $restaurant->total_payments}}</li>
                                                    </ul>
                                                </div>
                                                <div class="col-lg-4">
                                                    <img height="150px" width="150px" class="img-responsive" alt="" src="{{url('/'.$restaurant->image.'/')}}"/>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">إغلاق</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @php $count ++; @endphp
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-center">
                    {!! $restaurants->appends([
                        'name' => request()->input('name'),
                        'city_id' => request()->input('city_id'),
                        'status' => request()->input('status'),
                    ])->render() !!}
                </div>
            @else
                <div class="col-md-4 col-md-offset-4">
                    <div class="alert alert-info bg-blue text-center">لا يوجد مطاعم</div>
                </div>
            @endif

        </div>
    </div>


@stop