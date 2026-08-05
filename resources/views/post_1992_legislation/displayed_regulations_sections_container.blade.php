<div class="panel panel-default">
          <div class="panel-heading">
            <center><p class="panel-title"><small>Filter</small></p></center>
          </div>
          
          <div class="panel-body">
    
            {{-- View all sections --}}
            <center>
                <div class="btn-group">
                      <button style="background-color:white; border-color:black;"  type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <small>View All Regulations</small></small> <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu table-wrapper-scroll-view" style="width: 520px;">
                         @foreach($regulationsContents as $title)
                            <li><a href="/new-laws/regulations_content/{{ $title->id }}" sid="{{$title->id}}" class="single_view_all_regulation_section_link">{{ $title->section }}</a></li>
                        @endforeach 
                      </ul>
                </div>
            </center>
            
            <ul class="pager show">
                <li><a href="#" class="previous_regulation_under_act">&laquo;&nbsp;Previous</a></li>
                <li><a href="#" class="next_regulation_under_act">Next&nbsp;&raquo;</a></li>
            </ul>
    
            {{-- Downloads --}}
            <center>
        
        {{-- <label>View</label>
        <a class="expanded_link" id="expanded_link_toggle_all_pre1992_preview_2" href=""><li style="list-style:none;">Expanded View</li></a> --}}
        
        <button style="background-color:white; border-color:black;" class="btn btn-xs expanded_link" id="expanded_link_toggle_all_pre1992_preview_2" href=""><li style="list-style:none;">Expanded View</li>
        </button>
        <hr>
      </center>
        
      @include('extenders.case_law_main_search')
        </div>
</div>



