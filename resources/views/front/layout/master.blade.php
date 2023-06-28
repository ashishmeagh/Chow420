<!-- Header -->
@include('front.layout._header')

<!-- BEGIN Content -->
<div id="main-content" class="main-content-div">
    @yield('main_content')
</div>
    <!-- END Main Content -->

<!-- Footer -->

@yield('page_script')

@include('front.layout._footer')
