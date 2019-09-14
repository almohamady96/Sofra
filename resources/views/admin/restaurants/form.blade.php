@include('admin.layouts.partials.validation-errors')
@include('flash::message')
<div class="form-group">

    <label for="name">name</label>
    {!! form::text('name',null,[
    'class'=>'form-control'
    ]) !!}
</div>
<div class="form-group">

    @inject('regions','App\Region')
    <label for="region_id">region</label>
    {!! form::select('region_id',$regions->pluck('name','id'),[
    'class'=>'form-control'
    ]) !!}
</div>

<div class="form-group">

    @inject('category','App\Category')
    <label for="category_id">category</label>
    {!! form::select('category_id',$category->pluck('name','id'),[
    'class'=>'form-control'
    ]) !!}
</div>
<div class="form-group">

    <label for="email">email</label>
    {!! form::email('email',null,[
    'class'=>'form-control'
    ]) !!}
</div>

<div class="form-group">

    <label for="password">password</label>
    {!! form::text('password',null,[
    'class'=>'form-control'
    ]) !!}
</div>
<div class="form-group">
    <label for="status">status</label>
    {!! form::select('status',['open'=>'مفتوح','close'=>'مغلق'],[
    'class'=>'form-control'
    ]) !!}
</div>
<div class="form-group">

    <label for="min_price">min_price</label>
    {!! form::number('min_price',null,[
    'class'=>'form-control'
    ]) !!}
</div>
<div class="form-group">

    <label for="delivery_cost">delivery_cost</label>
    {!! form::number('delivery_cost',null,[
    'class'=>'form-control'
    ]) !!}
</div>
<div class="form-group">

    <label for="phone">phone</label>
    {!! form::number('phone',null,[
    'class'=>'form-control'
    ]) !!}
</div>
<div class="form-group">

    <label for="whatsapp">whatsapp</label>
    {!! form::number('whatsapp',null,[
    'class'=>'form-control'
    ]) !!}
</div>
<div class="form-group">

    <label for="delivery_way">delivery_way</label>
    {!! form::text('delivery_way',null,[
    'class'=>'form-control'
    ]) !!}
</div>