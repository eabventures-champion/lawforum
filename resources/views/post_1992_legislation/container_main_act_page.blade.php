<div class="col-md-3" style="padding-top: 3.7em;">
    <div class="panel panel-default">
      <div class="panel-heading" style="background: #eeeeee;">
        <center><p class="panel-title" style="color: black;"><small>Filter</small></p></center>
      </div>

      <center>
        <div class="panel-body">
          
          {{--<label style="color: black;">Related Acts</label><br>--}}
          
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
          
          
          
          {{--
          @if($amendedcount > 0 && $regulationcount > 0)
                <a class="all_amendments_link" id="all_amendments_link_toggle" href="/new-laws/{{$allPost1992Act['post_group']}}/all_amended_acts/{{$allPost1992Act['title']}}/{{ $allPost1992Act['id'] }}"><li style="list-style:none;">View Amendments</li>
                </a>
                
                <a class="all_regulations_link" id="all_regulations_link_toggle" href="/new-laws/{{$allPost1992Act['post_group']}}/all_regulations_acts/{{$allPost1992Act['title']}}/{{ $allPost1992Act['id'] }}"><li style="list-style:none;">View Regulations</li>
                </a>
                <br>

            @elseif($amendedcount > 0)
                <a class="all_amendments_link" id="all_amendments_link_toggle" href="/new-laws/{{$allPost1992Act['post_group']}}/all_amended_acts/{{$allPost1992Act['title']}}/{{ $allPost1992Act['id'] }}"><li style="list-style:none;">View Amendments</li>
                </a>
                <br>

            @elseif($regulationcount > 0)
                <a class="all_regulations_link" id="all_regulations_link_toggle" href="/new-laws/{{$allPost1992Act['post_group']}}/all_regulations_acts/{{$allPost1992Act['title']}}/{{ $allPost1992Act['id'] }}"><li style="list-style:none;">View Regulations</li>
                </a>
                <br>
                
            @else
                  <p style="text-decoration: none;" class="hidden">None</p>
                  <br>
          @endif
          --}}
          
          
          <div class="dropdown no_list">
              <button style="background-color:white; border-color:black;" class="btn btn-sm dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                View Related Acts
                <span class="caret"></span>
              </button>

              <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                  <!-- 1. both are true -->
                  @if($amendedcount > 0 && $regulationcount > 0)
                      <li><a class="all_amendments_link" id="all_amendments_link_toggle"  href="/new-laws/{{$allPost1992Act['post_group']}}/all_amended_acts/{{$allPost1992Act['title']}}/{{ $allPost1992Act['id'] }}"><span class="small"><center>Amendments</center></span></a></li>
                      <li><a class="all_regulations_link" id="all_regulations_link_toggle" href="/new-laws/{{$allPost1992Act['post_group']}}/all_regulations_acts/{{$allPost1992Act['title']}}/{{ $allPost1992Act['id'] }}"><span class="small"><center>Regulations</center></span></a></li>
                      
                      <!-- 2. only amendments -->
                      @elseif($amendedcount > 0)
                        <li><a class="all_amendments_link" id="all_amendments_link_toggle" href="/new-laws/{{$allPost1992Act['post_group']}}/all_amended_acts/{{$allPost1992Act['title']}}/{{ $allPost1992Act['id'] }}"><span class="small"><center>Amendments</center></span></a></li>
                      
                      <!-- 3. only regulations -->
                      @elseif($regulationcount > 0)
                        <li><a class="all_regulations_link" id="all_regulations_link_toggle" href="/new-laws/{{$allPost1992Act['post_group']}}/all_regulations_acts/{{$allPost1992Act['title']}}/{{ $allPost1992Act['id'] }}"><span class="small"><center>Regulations</center></span></a></li>
                  
                      @else
                      <!--None-->
                      
                      @section('scripts')
                        <script>
                        $( ".no_list" ).hide();
                        </script>
                      @endsection
                    
                  @endif
              </ul>
          </div>

          <br>
          

          <div class="dropdown">
              <button style="background-color:white; border-color:black;" class="btn btn-sm dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                View Options
                <span class="caret"></span>
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                <li><a class="expanded_link" id="expanded_link_toggle_all_pre1992_preview_1" href="/new-laws/1/{{$allPost1992Act['post_group']}}/{{$allPost1992Act['title']}}/expanded-view/{{ $allPost1992Act['id'] }}"><span class="small"><center>Expanded View</center></span></a></li>
                
                @if (Route::has('login'))
                  @auth
                        {{-- No Subscription --}}
                        @if(auth()->user()->check_subscription == 0)
                          <li><a href="" data-toggle="modal" data-target="#myModalplainSubscribe"><span class="small"><center>Plain View</center></span></a></li>
                          {{-- Subscription has expired --}}
                          @elseif(auth()->user()->subscription_expiry < today())
                          <li><a href="" data-toggle="modal" data-target="#myModalplainExpiry"><span class="small"><center>Plain View</center></span></a></li>                                          
                          {{-- Subscription download limit reached --}}
                          @elseif(auth()->user()->subscription_downloads <= auth()->user()->downloads_counts)
                          <li><a href="" data-toggle="modal" data-target="#maximumDownloadReachedplain"><span class="small"><center>Plain View</center></span></a></li>
                      
                          @else
                          {{-- View Plain View --}}
                            <li><a href="/new-laws/1/{{$allPost1992Act['post_group']}}/{{$allPost1992Act['title']}}/plain_view/{{ $allPost1992Act['id'] }}" target="_blank"><span class="small"><center>Plain View</center></span></a></li>
                        @endif
                      @else
                    {{-- Create Account --}}
                    <li><a href="" data-toggle="modal" data-target="#myModalplainAccount"><span class="small"><center>Plain View</center></span></a></li>
                  @endauth
                @endif
              </ul>
          </div>
          <hr>
          {{-- @include('extenders.case_law_main_search') --}}
          <form action="/acts-of-parliament-act-search/{{$allPost1992Act['title']}}/{{ $allPost1992Act['id'] }}" method="GET">
            {{ csrf_field() }}
                <input style="padding: 15px;" class="form-control" name="search_text" type="text" placeholder="Search word in section" aria-label="Search">
          </form>
          <div id="content"></div>
        </div>
        </center>
    </div>
        @include('layouts.plain_view_no_subscription')
        @include('layouts.plain_view_subscription_expiry')
        @include('layouts.plain_view_downloaded_exceeded')
        @include('layouts.plain_create_account')
</div>


           
          

 

    

