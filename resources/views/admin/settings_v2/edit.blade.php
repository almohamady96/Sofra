@extends('admin.layouts.main',[
                                'page_header'       => 'الاعدادات',
                                'page_description'  => 'اعدادات الموقع'
                                ])
@section('content')
    <!-- general form elements -->
    <div class="box box-primary">
        <!-- form start -->
        {!! Form::model($model,[
                                'action'=>['Setting_v2Controller@update',$model->id],
                                'id'=>'myForm',
                                'role'=>'form',
                                'method'=>'PUT',
                                'files'=>true
                                ])!!}

        <div class="box-body">

            @include('admin.settings_v2.form')

            <div class="box-footer">
                <button type="submit" class="btn btn-primary">حفظ</button>
            </div>

        </div>
        {!! Form::close()!!}

    </div><!-- /.box -->

@endsection