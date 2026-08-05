
{{-- CONTAINER PLAIN --}}

{{-- DOWNLOADS --}}
<div class="col-md-3" style="padding-top: 3.7em;"> 
    <div class="panel panel-default">
      <div class="panel-heading" style="background: #eeeeee;">
        <center><p class="panel-title" style="color: black;"><small>Filter</small></p></center>
      </div>
      <center>
      <div class="panel-body">

        <div class="dropdown hidden">
          <button class="btn btn-sm btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            Related
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Separated link</a></li>
          </ul>
      </div>
      <br>
      {{-- Downloads
          
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
        {{-- <center>
        <label style="color: black;">View Options</label>
        <a class="expanded_link" id="expanded_link_toggle_all_pre1992_preview_1" href="/existing-laws/1/{{$allPre1992Act['pre_1992_group']}}/{{$allPre1992Act['title']}}/expanded-view/{{ $allPre1992Act['id'] }}"><li style="list-style:none;">Expanded View</li></a>
        <a href="/existing-laws/1/{{$allPre1992Act['pre_1992_group']}}/{{$allPre1992Act['title']}}/plain_view/{{ $allPre1992Act['id'] }}" target="_blank"<li style="list-style:none;">Plain View</li></a>
        </center>  --}}

      <div class="dropdown">
          <button style="background-color:white; border-color:black;" class="btn btn-sm dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            View Options
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
            <li><a class="expanded_link" id="expanded_link_toggle_all_pre1992_preview_1" href="/existing-laws/1/{{$allPre1992Act['pre_1992_group']}}/{{$allPre1992Act['title']}}/expanded-view/{{ $allPre1992Act['id'] }}"><span class="small"><center>Expanded View</center></span></a></li>
            <li><a href="/existing-laws/1/{{$allPre1992Act['pre_1992_group']}}/{{$allPre1992Act['title']}}/plain_view/{{ $allPre1992Act['id'] }}" target="_blank"><span class="small"><center>Plain View</center></span></a></li>
          </ul>
      </div>

        <hr>
        @include('extenders.case_law_main_search')
      </div>
    </center>
      </div>
</div>


    

    

