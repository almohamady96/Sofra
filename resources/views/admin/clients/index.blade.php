@extends('admin.layouts.main',[
								'page_header'		=> 'العملاء',
								'page_description'	=> 'طالبي الطعام'
								])

@section('content')
    <div class="box box-primary">
        <div class="box-header">
            <div class="pull-right">
                {{-- <a href="{{url(route('client.create'))}}" class="btn btn-primary">--}}
                <a href="{{url('admin/client/create')}}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> عميل جديد
                </a>
            </div>
        </div>
        <div class="box-body">
            @include('flash::message')
            {{--@if(count($clients))--}}
            @if(!empty($clients))
                <div class="table-responsive">
                    <table class="table table-bordered danger">
                        <thead style="text-align: center">
                        <th>#</th>
                        <th>اسم العميل</th>
                        <th>الايميل</th>
                        <th>الهاتف</th>
                        <th>المدينة</th>
                        <th>الوصف</th>
                        <th>الصوره</th>
                        <th class="text-center">تعديل</th>
                        <th class="text-center">حذف</th>

                        </thead>
                        <tbody style="text-align: center">
                        @php $count = 1; @endphp
                        @foreach($clients as $client)
                            <tr id="removable{{$client->id}}">
                                <td>{{$count}}</td>
                                <td>{{$client->name}}</td>
                                <td>{{$client->email}}</td>
                               {{-- <td>{{Hash::make($client->password)}}</td>--}}
                                <td>{{$client->phone}}</td>
                               {{-- <td>{{optional($client->region)->name}}</td>--}}
                                <td>
                                    @if(count([$client->region]))
                                        {{$client->region->name}}
                                        @if(count(array($client->region->city)))
                                            {{$client->region->city->name}}
                                        @endif
                                    @endif
                                </td>
                                <td>{{$client->description}}</td>
                                <td>
                                    {{--<img src="{{asset($client->image)}}" style="width: 50px; height: 50px">--}}
                                    <a href="{{asset($client->image)}}" data-lightbox="{{$client->id}}" data-title="{{$client->name}}"><img src="{{asset($client->image)}}" alt="" style="height: 60px; width:100px "></a>

                                </td>
                               {{-- <td class="text-center">
                                    <a href="region/{{$country->id}}/edit"  class="btn btn-xs btn-success"><i class="fa fa-edit"></i></a>
                                </td>--}}
                                <td><a href="{{url(route('client.edit' , $client->id))}}" class="btn btn-success btn-xs"><i class="fa fa-edit"></i></a></td>

                                <td class="text-center">
                                    {!!Form::open([
                                      'action' => ['ClientController@destroy',$client->id ],
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
                {!! $clients->render() !!}
            @endif
        </div>
    </div>
@stop