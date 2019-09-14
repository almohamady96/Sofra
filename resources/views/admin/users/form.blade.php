@include('admin.layouts.partials.validation-errors')
@include('flash::message')


<div class="form-group">
    <label for="name">الاسم </label>
    {!!Form::text('name',null,[
    'class'=>'form-control'
    ])!!}
</div>
<div class="form-group">
    <label for="name"> الايميل</label>
    {!!Form::email('email',null,[
    'class'=>'form-control'
    ])!!}
</div>

<div class="form-group">
    <label for="name"> كلمة المرور</label>
    {!!Form::password('password',null,[
    'class'=>'form-control'
    ])!!}
</div>
<div class="form-group">
    <label for="name">  تأكيد كلمة المرور</label>
    {!!Form::password('password_confirmation',null,[
    'class'=>'form-control'
    ])!!}
</div>
