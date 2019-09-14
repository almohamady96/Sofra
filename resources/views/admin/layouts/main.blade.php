@include('admin.layouts.includes.header')
@include('admin.layouts.includes.sidebar')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header with-border ">
        <h1>
            {{$page_header}}
            <small>{!! $page_description !!}</small>
        </h1>


            <ol class="breadcrumb">
                <li style=" position: absolute;right:95%"><a href="{{url('/home')}}"><i class="fa fa-dashboard"  style=" position: absolute;right:98%;top:20%"></i> Home</a></li>

            </ol>

    </section>

    <!-- Main content -->
    <section class="content">

        @yield('content')

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

@include('admin.layouts.includes.footer')