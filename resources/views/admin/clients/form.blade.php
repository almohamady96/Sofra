@include('admin.layouts.partials.validation-errors')
@include('flash::message')
<div class="row">

    <div class="col-md-4 ">
<div class="form-group">
    <label for="name">name</label>
    {!! form::text('name',null,[
    'class'=>'form-control'
    ]) !!}
</div>
    </div>

    <div class="col-md-4">
    <div class="form-group">
    @inject('regions','App\Region')
    <label for="region_id">region</label>
    {!! form::select('region_id',$regions->pluck('name','id'),[
    'class'=>'form-control'
    ]) !!}
</div>
    </div>

    <div class="col-md-4">
<div class="form-group">
    <label for="email">email</label>
    {!! form::email('email',null,[
    'class'=>'form-control'
    ]) !!}
</div>
    </div>

    <div class="col-md-4">
<div class="form-group">
    <label for="password">password</label>
    {!! form::text('password',null,[
    'class'=>'form-control'
    ]) !!}
</div>
        </div>

        <div class="col-md-4">
<div class="form-group">
    <label for="description">description</label>
    {!! form::text('description',null,[
    'class'=>'form-control'
    ]) !!}
</div>
            </div>


            <div class="col-md-4">
<div class="form-group">
    <label for="phone">phone</label>
    {!! form::number('phone',null,[
    'class'=>'form-control'
    ]) !!}
</div>
                </div>

                <div class="col-md-4">
<div class="form-group">
    <label for="image">image</label>
    {!! form::file('image',null,[
    'class'=>'form-control'
    ]) !!}
</div>
                </div>

<div class="clearfix"></div>
</div>


