@extends('admin.layouts.main',[
                                'page_header'       => ' العملاء',
                                'page_description'  => 'تعديل عميل '
                                ])
@section('content')

    <ol class="breadcrumb">
        <li><a href="{{url('admin/client')}}"><i class="fa fa-cutlery"></i> {{$model->name}}</a></li>
    </ol>
    <!-- general form elements -->
    <div class="box box-primary">
        <!-- form start -->
        {!! Form::model($model,[
                               // 'url'=> 'admin/'.$restaurant->id.'/item/'.$model->id,
                                'action'=>['ClientController@update',$model->id],
                                'id'=>'myForm',
                                'role'=>'form',
                                'method'=>'PUT',
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