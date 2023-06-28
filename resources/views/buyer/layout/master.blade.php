<!-- HEader -->        
@include('buyer.layout._header')    
@include('buyer.layout._sidebar')    

<!-- BEGIN Content -->
<div id="main-content" class="main-content-div">
    @yield('main_content')
</div>
    <!-- END Main Content -->

<!-- Footer -->        
@include('buyer.layout._footer')   
              