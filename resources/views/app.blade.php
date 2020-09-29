@extends('layouts.core.app02')

@section('content')

    <!-- Navbar -->
    @include('layouts.admin02.nav.nav')
    <!-- /.navbar -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Main content -->
        @yield('app_content')
        <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    @include('layouts.admin02.controlbar')
    <!-- /.control-sidebar -->

    <!-- Admin Footer -->
    @include('layouts.admin02.footer')

@endsection
