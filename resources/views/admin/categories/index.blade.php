@extends('admin.layouts.main',[
								'page_header'		=> 'التصنيفات',
								'page_description'	=> 'تصنيفات المطاعم'
								])
@section('content')
    <div class="box box-primary">
        <div class="box-header">
            @include('flash::message')
            <div class="pull-right">
                <a href="{{url('admin/category/create')}}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> تصنيف جديد
                </a>
            </div>
        </div>
    @if(!empty($categories))
            <div class="table-responsive">
                <table class="table table-bordered danger">
                    <thead>
                    <th>#</th>
                    <th>اسم القسم</th>
                    <th class="text-center">تعديل</th>
                    <th class="text-center">حذف</th>
                    </thead>
                    <tbody>
                    @php $count = 1; @endphp
                    @foreach($categories as $category)
                        <tr id="removable{{$category->id}}">
                            <td>{{$count}}</td>
                            {{--<td>{{$loop->iteration}}</td>--}}
                            <td>{{$category->name}}</td>

                            <td class="text-center"><a href="category/{{$category->id}}/edit" class="btn btn-xs btn-success"><i class="fa fa-edit"></i></a></td>
                            {{--
                            <td class="text-center">
                                <a href="{{url(route('category.edit',$record->id))}}" class="btn btn-success btn-xs">
                                    <i class="fa fa-edit"></i>  edit categories</a>
                            </td>
                            --}}
                            <td class="text-center">
                                <button id="{{$category->id}}" data-token="{{ csrf_token() }}" data-route="{{URL::route('category.destroy',$category->id)}}"  type="button" class="destroy btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button>
                            </td>
{{--
                            <td class="text-center">
                                {!!Form::open([
                                  'action' => ['CategoryController@destroy',$category->id ],
                                  'method' => 'delete',
                                  ])!!}
                                <button class="btn btn-danger btn-xs" type="submit" id="delete"><i class="fa fa-trash-o"></i></button>
                                {!!Form::close()!!}
                            </td>
                            --}}
                        </tr>
                        @php $count ++; @endphp
                    @endforeach
                    </tbody>
                </table>
            </div>
            {!! $categories->render() !!}
        @endif


    </div>
@stop