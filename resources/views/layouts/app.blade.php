<!DOCTYPE html>
    <html class="loading semi-dark-layout" lang="en" data-layout="semi-dark-layout" data-textdirection="ltr">
<head>
   @include('layouts.partials.header-asset')
</head>
<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="">
    @include('layouts.partials.header')
    @include('layouts.partials.sidebar')
    <div class="app-content content ">
        @yield('content')
    </div>
    @include('layouts.partials.footer')


    @stack("scripts");
</body>
</html>
