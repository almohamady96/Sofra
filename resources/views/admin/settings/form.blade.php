@include('admin.layouts.partials.validation-errors')
@include('flash::message')

<h3>اعدادات التطبيق</h3>

<h4>بيانات التواصل الاجتماعي</h4>
<div class="form-group">
    <label for="name">فيس بوك</label>
    {!!Form::text('facebook',null,[
    'class'=>'form-control'
    ])!!}
</div>
<div class="form-group">
    <label for="name">تويتر</label>
    {!!Form::text('twitter',null,[
    'class'=>'form-control'
    ])!!}
</div>
<div class="form-group">
    <label for="name">انستقرام </label>
    {!!Form::text('instagram',null,[
    'class'=>'form-control'
    ])!!}
</div>
<div class="form-group">
    <label for="name">عمولة التطبيق </label>
    {!!Form::number('commission',null,[
    'class'=>'form-control'
    ])!!}
</div>
<div class="form-group">
    <label for="name">عن التطبيق </label>
    {!!Form::textarea('about_app',null,[
    'class'=>'form-control'
    ])!!}
</div>
<div class="form-group">
    <label for="name">الشروط والأحكام </label>
    {!!Form::textarea('terms',null,[
    'class'=>'form-control'
    ])!!}
</div>
