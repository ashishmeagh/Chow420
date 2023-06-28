<!-- HEader -->        
@include('seller.layout._header')    
@include('seller.layout._sidebar')    

<!-- BEGIN Content -->
<div id="main-content" class="main-content-div">
    @yield('main_content')
</div>
    <!-- END Main Content -->

<!-- Footer -->        
@include('seller.layout._footer')   
              