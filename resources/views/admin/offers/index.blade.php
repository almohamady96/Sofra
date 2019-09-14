@extends('admin.layouts.main',[
								'page_header'		=> 'العروض',
								'page_description'	=> 'عرض العروض'
								])
@section('content')
    <div class="box box-primary">
        <div class="box-header">
            <div class="pull-right">
            <a href="{{url(route('offer.create'))}}" class="btn btn-danger"><i class="fa fa-plus"> &nbsp انشاء عرض جديد</i></a>
            {{--<a href="{{url('admin/offer/create')}}" class="btn btn-primary">--}}
            {{--<i class="fa fa-plus"></i> عرض جديد--}}
            {{--</a>--}}
                {{--<a href="trashed" class="btn btn-danger" style="float: right">show trashed value</a>--}}
            </div>
        </div>
        <div class="box-body">
            @include('flash::message')
          {{--  @if(count($offers))--}}
            @if(!empty($offers))
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead style="text-align: center;font-size: 18px">
                        <th>#</th>
                        <th>اسم العرض</th>
                        <th> اسم المطعم</th>
                        <th>الصورة</th>
                        <th>  السعر</th>
                        <th style=" width:15%">  الوصف</th>
                        <th>بداية العرض</th>
                        <th>نهاية العرض</th>
                        <th class="text-center"> متاح / غير متاح</th>
                        {{--<th class="text-center">تعديل</th>--}}
                        <th class="text-center">حذف</th>
                        </thead>
                        <tbody style="text-align: center;font-size: 18px">
                        @php $count = 1; @endphp
                        @foreach($offers as $offer)
                            <tr id="removable{{$offer->id}}">
                                <td>{{$count}}</td>
                               {{-- <td>{{$loop->iteration}}</td>--}}
                                <td>{{$offer->name}}</td>
                                <td>@if(count([$offer->restaurant])){{$offer->restaurant->name}}@endif</td>
                                {{--<td>{{optional($offer->restaurant)->name}}</td>--}}
                                <td>
                                    <a href="{{asset($offer->image)}}" data-lightbox="{{$offer->id}}" data-title="{{$offer->name}}"><img src="{{asset($offer->image)}}" alt="" style="height: 60px; width:100px "></a>
                                </td>
                                <td>{{$offer->price}}</td>
                                <td >{{$offer->description}}</td>
                                <td>{{$offer->start_from->format('Y-m-d')}}</td>
                                <td>{{$offer->end_at->format('Y-m-d')}}</td>
                                <td class="text-center">{!!  ($offer->available) ? '<i class="fa fa-2x fa-check text-green"></i>' : '<i class="fa fa-2x fa-close text-red"></i>' !!}</td>
                                {{--<td class="text-center"><a href="offer/{{$offer->id}}/edit"--}}
                                {{--class="btn btn-xs btn-success"><i class="fa fa-edit"></i></a>--}}
                                {{--</td>--}}
                                {{--
                                <td class="text-center">
                                    <a href="{{url(route('offer.edit',$offer->id))}}" class="btn btn-success btn-xs">
                                        <i class="fa fa-edit"></i>  edit region</a>
                                </td>
                                --}}
                                <td class="text-center">
                                    {!!Form::open([
                                      'action' => ['OfferController@destroy',$offer->id ],
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
                {!! $offers->render() !!}
            @endif
        </div>
    </div>
@stop