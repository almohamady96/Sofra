@include('admin.layouts.partials.validation-errors')
@include('flash::message')
<div class="form-group">
    <label for="name">طريقه الدفع </label>
    {!!Form::text('name',null,[
    'class'=>'form-control'
    ])!!}
</div>


