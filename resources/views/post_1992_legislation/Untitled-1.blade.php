<div class="col-md-3">
  <div class="sidebar">
    <div class="panel panel-default">
      <div class="panel-heading">
        <center><p class="panel-title"><small>Filter</small></p></center>
      </div>
      <div class="panel-body">
  
         {{-- View all acts --}}
         
        <center>
        <div class="btn-group">
              <button style="background-color:white; border-color:black;" type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <small>Select Sections</small></small> <span class="caret"></span>
              </button>
              <ul class="dropdown-menu table-wrapper-scroll-view" style="width: 520px;">
                  @foreach($allPost1992Articles as $allPost1992Article)
                      <li><a data-scroll-to="body"
                        data-scroll-focus="body"
                        data-scroll-speed="400"
                        data-scroll-offset="-60" class="view_all_section_link_with_prev_next" sid="{{$allPost1992Article->id}}" href="/new-laws/content/{{ $allPost1992Article->id }}">{{$allPost1992Article->section }}</a></li>
                  @endforeach  
              </ul>
        </div>
        </center>
        <br>
        <ul class="pager show">
            <li><a data-scroll-to="body"
              data-scroll-focus="body"
              data-scroll-speed="400"
              data-scroll-offset="-60" href="#" class="previous_content_act">&laquo;&nbsp;Previous Section</a></li>
            <li><a data-scroll-to="body"
              data-scroll-focus="body"
              data-scroll-speed="400"
              data-scroll-offset="-60" href="#" class="next_content_act">Next Section&nbsp;&raquo;</a></li>
        </ul>
      
        
        <hr>
        <br>
        <center>
        <button class="btn btn-sm btn-default expanded_link" id="expanded_link_toggle_all_pre1992_preview_2" href="/new-laws/1/{{$allPost1992Act['post_group']}}/{{$allPost1992Act['title']}}/expanded-view/{{ $allPost1992Act['id'] }}"><li style="list-style:none;">Expanded View</li>
        </button>


        {{-- <a href="/new-laws/plain_content/{{ $allPost1992Article['post_act'] }}/{{ $allPost1992Article['id'] }}" target="_blank">Sections Plain View</a>
        <a class="trigger_plain_view" href="#"><li>Plain View</li></a>
        <a href="/new-laws/plain_content/{{ $allPost1992Article->id }}"><li>Plain View</li></a> --}}
        </center>
        
        <!--<br>-->
        {{-- @include('extenders.case_law_main_search') --}}
        
          {{-- <input type="text" id="search_text">
          <input type="button" value="search" id="search"> --}}
        

    </div>
    
  </div>
</div>
</div>



