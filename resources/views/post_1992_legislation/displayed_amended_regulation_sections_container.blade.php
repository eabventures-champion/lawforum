
{{--CONTAINER DETAIL --}}

{{-- DOWNLOADS AND PRINT OPTIONS --}}
    <div class="panel panel-default">
      <div class="panel-heading">
        <center><p class="panel-title"><small>Views and Downloads</small></p></center>
      </div>
      
      <div class="panel-body">

        {{-- View all sections --}}
            <center>
                <div class="btn-group">
                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <small>View All Regulations</small></small> <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu table-wrapper-scroll-view" style="width: 520px;">
                          @foreach($amendedRegulationContents as $title)
                            <li><a href="/new-laws/amended_act_regulation_content/{{ $title->id }}" sid="{{$title->id}}" class="single_view_all_amendments_under_regulation_section_link">{{ $title->section }}</a></li>
                          @endforeach
                      </ul>
                </div>
            </center>
            
            <ul class="pager show">
                <li><a href="#" class="previous_amendment_under_regulation">Previous</a></li>
                <li><a href="#" class="next_amendment_under_regulation">Next</a></li>
            </ul>

        {{-- Downloads --}}
        <center>
        
          <label>View</label>
          <a class="expanded_link" id="expanded_link_toggle_all_pre1992_preview_2" href=""><li style="list-style:none;">Expanded View</li></a><hr>
          @include('extenders.case_law_main_search')

        </center> 
        

    </div>
  </div>

