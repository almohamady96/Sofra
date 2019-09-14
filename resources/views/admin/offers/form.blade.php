@include('admin.layouts.partials.validation-errors')
@include('flash::message')
@inject('restaurant','App\Restaurant')

@php
    $restaurants = [ '' => 'اختر المطعم'] + $restaurant->pluck('name','id')->toArray();
@endphp

<div class="form-group">

    <label for="name">Name</label>
    {!! form::text('name',null,[
    'class'=>'form-control'
    ]) !!}
</div>
<div class="form-group">

    @inject('restaurant','App\Restaurant')
    <label for="restaurant_id">restaurant</label>
    {!! form::select('restaurant_id',$restaurants,null,[
    'class'=>'form-control'
    ]) !!}
</div>

<div class="form-group">

    <label for="price">price</label>
    {!! form::number('price',null,[
    'class'=>'form-control'
    ]) !!}
</div>
<div class="form-group">

    <label for="description">description</label>
    {!! form::textarea('description',null,[
    'class'=>'form-control'
    ]) !!}
</div>
<div class="form-group">

    <label for="image">image</label>
    {!! form::file('image',[
    'class'=>'form-control'
    ]) !!}
</div>
<div class="form-group">

    <label for="start_from">start_from</label>
    {!! form::date('start_from',null,[
    'class'=>'form-control'
    ]) !!}
</div>

<div class="form-group">

    <label for="end_at">end_at</label>
    {!! form::date('end_at',null,[
    'class'=>'form-control'
    ]) !!}
</div>
{{--
<div class="form-group">
    <button class="btn btn-primary">ADD</button>
</div>--}}