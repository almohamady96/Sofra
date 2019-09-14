@extends('admin.layouts.main',[
								'page_header'		=> 'طرق الدفع',
								'page_description'	=> 'عرض الكل'
								])
@section('content')
    <div class="box box-default">
        <div class="box-header">
            <div class="pull-right">
                <a href="{{url('admin/payment/create')}}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> أضف جديد
                </a>
            </div>
        </div>
        @include('flash::message')
    @if(!empty($payments))
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <th>#</th>
                    <th>الاسم</th>
                    <th class="text-center">تعديل</th>
                    <th class="text-center">حذف</th>
                    </thead>
                    <tbody>
                    @php $count = 1; @endphp
                    @foreach($payments as $record)
                        <tr id="removable{{$record->id}}">
                            <td>{{$count}}</td>
                            <td>{{$record->name}}</td>
                            <td class="text-center"><a href="payment/{{$record->id}}/edit" class="btn btn-xs btn-success"><i class="fa fa-edit"></i></a></td>
                            {{--<td class="text-center">
                                <button id="{{$record->id}}" data-token="{{ csrf_token() }}" data-route="{{URL::route('payment.destroy',$record->id)}}"  type="button" class="destroy btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button>
                            </td>--}}
                            <td class="text-center">
                                {!!Form::open([
                                  'action' => ['PaymentController@destroy',$record->id ],
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
            {!! $payments->render() !!}
        @endif


    </div>
@stop