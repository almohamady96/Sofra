@include('admin.layouts.partials.validation-errors')
@include('flash::message')

@inject('restaurant','App\Restaurant')
@php
    $restaurants = [ '' => 'اختر المطعم'] + $restaurant->pluck('name','id')->toArray();
@endphp


<div class="row">

    <div class="col-md-4 ">
        <div class="form-group">
            <label for="restaurant_id">restaurant</label>
            {!! form::select('restaurant_id',$restaurants,null,[
            'class'=>'form-control'
            ]) !!}
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="notes">notes</label>
            {!! form::text('notes',null,[
            'class'=>'form-control'
            ]) !!}
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="restaurant_sales_cost">restaurant_sales_cost</label>
            {!! form::number('restaurant_sales_cost',null,[
            'class'=>'form-control'
            ]) !!}
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="commission">commission</label>
            {!! form::number('commission',null,[
            'class'=>'form-control'
            ]) !!}
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="pay_off">pay_off</label>
            {!! form::number('pay_off',null,[
            'class'=>'form-control'
            ]) !!}
        </div>
    </div>



    <div class="col-md-4">
        <div class="form-group">
            <label for="remaning">remaning</label>
            {!! form::number('remaning',null,[
            'class'=>'form-control'
            ]) !!}
        </div>
    </div>


<div class="clearfix"></div>
</div>


