@include('admin.layouts.partials.validation-errors')
@include('flash::message')

@inject('city','App\City')
@php
    $cities = $city->pluck('name','id')->toArray();
@endphp
<div class="form-group">
    <label for="name">اسم المنطقة</label>
    {!!Form::text('name',null,[
    'class'=>'form-control'
    ])!!}
</div>
<div class="form-group">
    <label for="city_id"> اختر المدينة</label>
    {!!Form::select('city_id',$cities,null,[
    'class'=>'form-control'
    ])!!}
</div>

