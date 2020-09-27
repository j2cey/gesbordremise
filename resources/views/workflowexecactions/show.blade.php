@extends('layouts.core.app02')

@section('content')

<!-- Navbar -->
@include('layouts.admin02.nav.nav')
<!-- /.navbar -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <div class="content">
        <div class="container">
            <workflow-execaction :execaction_prop="{{ $workflowexecaction->toJson() }}"></workflow-execaction>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

</div>
<!-- /.content-wrapper -->

<!-- Control Sidebar -->
@include('layouts.admin02.controlbar')
<!-- /.control-sidebar -->

<!-- Admin Footer -->
@include('layouts.admin02.footer')

@endsection
