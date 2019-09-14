@extends('admin.layouts.main',[
								'page_header'		=> 'العروض',
								'page_description'	=> 'عرض العروض'
								])
@section('content')
    <div class="box box-primary">
        <div class="box-header">
            {{--<div class="pull-right">--}}
            {{--<a href="{{url('admin/contact/create')}}" class="btn btn-primary">--}}
            {{--<i class="fa fa-plus"></i> عرض جديد--}}
            {{--</a>--}}
            {{--</div>--}}
        </div>
        <div class="box-body">
            @include('flash::message')
            @if(!empty($contacts))
                <div class="table-responsive">
                    <table class="table table-bordered danger">
                        <thead style="text-align: center">
                        <th>#</th>
                        <th>الاسم</th>
                        <th>الهاتف</th>
                        <th>الايميل</th>
                        <th>نوع الرساله</th>
                        <th>الرسالة</th>
                        {{--<th class="text-center">تعديل</th>--}}
                        <th class="text-center">حذف</th>
                        </thead>
                        <tbody style="text-align: center">
                        @php $count = 1; @endphp
                        @foreach($contacts as $contact)
                            <tr id="removable{{$contact->id}}">
                                <td>{{$count}}</td>
                                <td>{{$contact->name}}</td>
                                <td>{{$contact->phone}}</td>
                                <td>{{$contact->email}}</td>
                                <td>{{$contact->status}}</td>
                                <td>{{$contact->notes}}</td>
                                {{--<td class="text-center"><a href="contact/{{$contact->id}}/edit"--}}
                                {{--class="btn btn-xs btn-success"><i class="fa fa-edit"></i></a>--}}
                                {{--</td>--}}
                                <td class="text-center">
                                    {!!Form::open([
                                      'action' => ['ContactController@destroy',$contact->id ],
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
                {!! $contacts->render() !!}
            @endif
        </div>
    </div>
@stop