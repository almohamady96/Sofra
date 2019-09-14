@include('flash::message')
@include('admin.layouts.partials.validation-errors')

<div class="form-group">
    <label for="name">Name</label>
    {!!Form::text('name',null,[
    'class'=>'form-control'
    ])!!}
</div>


