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
            @if(!empty($models))
                <div class="table-responsive">
                    <table class="table table-bordered danger">
                        <thead style="text-align: center; font-size: 13px">
                        <th>#</th>
                        <th>facebook</th>
                        <th>twitter</th>
                        <th>instagram</th>
                        <th> commission</th>
                        <th>about_app</th>
                        <th>terms</th>
                        {{--<th class="text-center">تعديل</th>--}}
                        <th class="text-center">Edit</th>
                        </thead>
                        <tbody style="text-align: center; font-size: 13px">
                        @php $count = 1; @endphp
                        @foreach($models as $model)
                            <tr id="removable{{$model->id}}">
                                <td>{{$count}}</td>
                                <td>{{$model->facebook}}</td>
                                <td>{{$model->twitter}}</td>
                                <td>{{$model->instagram}}</td>
                                <td>{{$model->commission}}</td>
                                <td>{{$model->about_app}}</td>
                                <td>{{$model->terms}}</td>
                               {{-- <td ><a href="{{url(route('setting_v2.edit',$model->id))}}" class="btn btn-xs btn-danger"><i class="fa fa-edit"></i></a></td>--}}
                                <td class="text-center"><a href="setting_v2/{{$model->id}}/edit"
                                class="btn btn-xs btn-success"><i class="fa fa-edit"></i></a>
                                </td>
                               {{--
                                <td class="text-center">
                                    {!!Form::open([
                                      'action' => ['ContactController@destroy',$model->id ],
                                      'method' => 'delete'
                                      ])!!}
                                    <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-trash-o"></i></button>
                                    {!!Form::close()!!}
                                </td>
                                --}}
                            </tr>
                            @php $count ++; @endphp
                        @endforeach
                        </tbody>
                    </table>
                </div>
            {{--
                {!! $models->render() !!}
                --}}
            @endif
        </div>
    </div>
@stop