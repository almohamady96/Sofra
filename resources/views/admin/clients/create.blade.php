@extends('admin.layouts.main',[
                                'page_header'       => 'انشاء مستخدم جديد',
                                'page_description'  => 'عميل جديد'
                                ])
@section('content')

    <ol class="breadcrumb">
        <li><a href="{{url('admin/client')}}"><i class="fa fa-cutlery"></i> {{$model->name}}</a></li>
    </ol>

    <!-- general form elements -->
    <div class="box box-primary box-header with-border">
    {{--@include('admin.layouts.partials.validation-errors')--}}
    <!-- form start -->
        {!! Form::model($model,[
                                'action'=>'ClientController@store',
                                'id'=>'myForm',
                                'role'=>'form',
                                'method'=>'POST',
                                'files' => true
                                ])!!}
        <div class="box-body">
            @include('admin.clients.form')
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">حفظ</button>
            </div>
        </div>
        {!! Form::close()!!}
    </div><!-- /.box -->
@endsection