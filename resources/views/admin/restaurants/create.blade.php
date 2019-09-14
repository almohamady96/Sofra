@extends('admin.layouts.main',[
                                'page_header'       => 'المطاعم',
                                'page_description'  => 'مطعم جديد '
                                ])
@section('content')
    {{--@include('admin.layouts.partials.validation-errors')--}}
    <!-- general form elements -->
    <div class="box box-primary">
        <!-- form start -->
        {!! Form::model($model,[
                                'action'=>'RestaurantController@store',
                                'id'=>'myForm',
                                'role'=>'form',
                                'method'=>'POST',
                                'files'=>'true'
                                ])!!}
        <div class="box-body">
            @include('admin.restaurants.form')
           {{-- <div class="form-group">
                <button class="btn btn-primary">ADD</button>
            </div>--}}
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">حفظ</button>
            </div>
        </div>
        {!! Form::close()!!}
    </div><!-- /.box -->
@endsection