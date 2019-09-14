@extends('admin.layouts.main',[
                                'page_header'       => 'المستخدمين',
                                'page_description'  => 'تغيير كلمة المرور'
                                ])
@section('content')
    <!-- general form elements -->
    <div class="box box-primary">
          <div class="box-header with-border">

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                    <i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                        title="Remove">
                    <i class="fa fa-times"></i></button>
            </div>
          </div>
        <br>
        <!-- form start -->
        {!! Form::open([
                                'action'=>'UserController@change_password_save',
                                'id'=>'myForm',
                                'role'=>'form',
                                'method'=>'POST'
                                ])!!}

        <div class="box-body">
            @include('flash::message')
            @include('admin.layouts.partials.validation-errors')
            <div class="form-group">
                <label for="name"> كلمة المرور الحالية</label>
                {!!Form::password('old-password',null,[
                'class'=>'form-control'
                ])!!}
            </div>
            <div class="form-group">
                <label for="name"> كلمة المرور الجديدة</label>
                {!!Form::password('password',null,[
                'class'=>'form-control'
                ])!!}
            </div>
            <div class="form-group">
                <label for="name"> تأكيد كلمة المرور الجديدة</label>
                {!!Form::password('password_confirmation',null,[
                'class'=>'form-control'
                ])!!}
            </div>

            <div class="box-footer">
                <button type="submit" class="btn btn-primary">حفظ</button>
            </div>

        </div>
        {!! Form::close()!!}

    </div><!-- /.box -->

@endsection