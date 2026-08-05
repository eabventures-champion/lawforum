
{{-- DOWNLOADS AND PRINT OPTIONS
<div class="col-md-2"> 
    <div class="panel panel-default">
      <div class="panel-heading">
        <center><p class="panel-title"><small>Print and Downloads</small></p></center>
      </div>
      <div class="panel-body">
    
        <center>
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
              
                <button class="btn btn-primary btn-sm printLink"><span class="glyphicon glyphicon-print" aria-hidden="true"></span>&nbsp;&nbsp;Print</button>
              </div> 
            </div>
          </div>
        </div>
        </center> 
        <br>
        
        <label>View</label>
        <a href="/new-laws/1/{{$allPost1992Act['post_group']}}/{{$allPost1992Act['title']}}/plain-view/{{ $allPost1992Act['id'] }}"><li>Plain View</li></a>    
    </div>
  </div>
  @include('extenders.case_law_main_search')
</div>
--}}

{{-- ADVERTISEMENT--}}
<div class="col-md-3">
@include('extenders.case_law_main_search')
<br>
    <div class="panel panel-default">
      <div class="panel-heading">
        <p class="panel-title"><small>Advertisement</small></p>
      </div>
      <div class="panel-body">
        <div class="embed-responsive embed-responsive-4by3">
        <iframe width="420" height="345" src="https://www.youtube"></iframe>      
      </div>        
      </div>
    </div>
</div>

