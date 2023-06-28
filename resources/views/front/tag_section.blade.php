
@if(isset($arr_tags) && !empty($arr_tags))
  <div class="tags-section-index-div">
  <div class="tags-section-div">

    @php
    $tagtitle = $taglink ='';
     foreach($arr_tags as $k=>$v)
      {

        $tagtitle = isset($v['title'])?$v['title']:'';
        $taglink  = isset($v['link'])?$v['link']:'';
    @endphp

       <a href="{{ $taglink }}" target="_blank"> {{ $tagtitle }}</a>

     @php
       }//foreach
     @endphp

  </div>
</div>
@endif
