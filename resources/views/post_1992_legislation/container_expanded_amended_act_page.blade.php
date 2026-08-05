
{{-- CONTAINER PLAIN --}}

{{-- DOWNLOADS --}}
<div class="col-md-3"> 
  
    <div class="panel panel-default">
      <div class="panel-heading">
        <center><p class="panel-title"><small>Filter</small></p></center>
      </div>
      <div class="panel-body">

      {{-- Downloads --}}
        <center>
          {{--
        <div class="row">
          <div class="col-md-12">
            <label>Downloads</label>
            <div class="row">
              
              <a class="col-md-6" href=""><img alt="Brand" src="{{ asset('/logo/pdf.png') }}" class="img-responsive" style="width:2em;">PDF</a>
              <a class="col-md-6" href=""><img alt="Brand" src="{{ asset('/logo/word.png') }}" class="img-responsive" style="width:2em;">WORD</a>
              
            </div>
            <br>
            <div class="row">
              <div class="col-md-12">
                <!-- <label>Print</label> -->
                <button class="btn btn-primary btn-sm printLink"><span class="glyphicon glyphicon-print" aria-hidden="true"></span>&nbsp;&nbsp;Print</button>
              </div> 
            </div>
          </div>
        </div>
        --}}

        {{-- <label style="color: black;">View Options</label>
          <a class="expanded_link" id="expanded_link_toggle_all_pre1992_preview_1" href="/new-laws/1/{{$allPost1992Act['post_group']}}/{{$allPost1992Act['title']}}/expanded-view/{{ $allPost1992Act['id'] }}"><li style="list-style:none;">Expanded View</li>
          </a>
          <a href="/new-laws/1/{{$allPost1992Act['post_group']}}/{{$allPost1992Act['title']}}/plain_view/{{ $allPost1992Act['id'] }}" target="_blank"><li style="list-style:none;">Plain View</li></a> --}}
        
        <div class="dropdown">
            <button style="background-color:white; border-color:black;" class="btn btn-sm dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
              View Options
              <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
              <li><a class="expanded_link" id="expanded_link_toggle_all_pre1992_preview_1" href="/new-laws/1/{{$allPost1992Act['post_group']}}/{{$allPost1992Act['title']}}/expanded-view/{{ $allPost1992Act['id'] }}"><span class="small"><center>Expanded View</center></span></a></li>
              <li><a href="/new-laws/1/{{$allPost1992Act['post_group']}}/{{$allPost1992Act['title']}}/plain_view/{{ $allPost1992Act['id'] }}" target="_blank"><span class="small"><center>Plain View</center></span></a></li>
            </ul>
        </div>

        <hr>
        <!-- <label>Print</label>
        <a href=""><li>Whole Amendments</li></a> -->
        @include('extenders.case_law_main_search')
      </div>
    </center> 
    </div>
  </div>


    

    

