@include('admin.layouts.partials.validation-errors')
@include('flash::message')
@inject('restaurant','App\Restaurant')
@inject('client','App\Client')

@php
    $restaurants = [ '' => 'اختر المطعم'] + $restaurant->pluck('name','id')->toArray();
@endphp

<div class="form-group">
    <label for="address">address</label>
    {!! form::text('address',null,[
    'class'=>'form-control'
    ]) !!}
</div>
<div class="form-group">
    <label for="client_name">client_name</label>
    {!! form::text('client_id',null,[
    'class'=>'form-control'
    ]) !!}
</div>
<div class="form-group">
    <label for="client_phone">client_phone</label>
    {!! form::number('phone',null,[
    'class'=>'form-control'
    ]) !!}
</div>
<div class="form-group">
    <label for="">&nbsp;status_restaurant</label>
    {!! Form::select('status',
        [
              '' => 'اختر حالة المطعم',
            'pending' => 'قيد التنفيذ',
            'accepted' => 'تم تأكيد الطلب',
            'rejected' => 'مرفوض',
        ],[
            'class' => 'form-control',
    ]) !!}
</div>
<div class="form-group">
    <label for="restaurant_id">restaurant</label>
    {!! form::select('restaurant_id',$restaurants,null,[
    'class'=>'form-control'
    ]) !!}
</div>

<div class="form-group">
    <label for="cost">cost</label>
    {!! form::number('cost',null,[
    'class'=>'form-control'
    ]) !!}
</div>
<div class="form-group">
    <label for="total">total</label>
    {!! form::number('total',null,[
    'class'=>'form-control'
    ]) !!}
</div>
<div class="form-group">
    <label for="commission">commission</label>
    {!! form::number('commission',null,[
    'class'=>'form-control'
    ]) !!}
</div>

<div class="form-group">
    <label for="net">net</label>
    {!! form::number('net',null,[
    'class'=>'form-control'
    ]) !!}
</div>
<div class="form-group">

    <label for="description">notes</label>
    {!! form::textarea('notes',null,[
    'class'=>'form-control'
    ]) !!}
</div>

<div class="form-group">

    <label for="start_from">created_at</label>
    {!! form::date('created_at',null,[
    'class'=>'form-control'
    ]) !!}
</div>

{{--
<div class="form-group">
    <button class="btn btn-primary">ADD</button>
</div>--}}
>