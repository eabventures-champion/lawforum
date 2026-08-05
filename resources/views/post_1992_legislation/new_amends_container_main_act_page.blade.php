<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <link rel="stylesheet" href="{{ asset('css/tooltipster.bundle.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/tooltipster-sideTip-borderless.min.css') }}" type="text/css"> 
    <style>
        .btn-customised{
          font-weight: 550;
          padding: .175rem .75rem;
          line-height: 1.3;
          font-size: .8rem;
        }
    </style>   
</head>

<body>

<div class="col-md-3 mobile-filter-hide">
  <div class="sidebar">
    <div class="card border-secondary" style="max-width: 18rem;">
      <div class="card-header" style="padding: .25rem 1.25rem;">Filter</div>
      <div class="card-body text-dark">            
    <center>
        <div class="dropdown mb-2">
          <a class="btn btn-outline-dark dropdown-toggle btn-customised" href="#" role="button" id="dropdownMenuLink-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span>View Options</span>
          </a>
        
          <div class="dropdown-menu" aria-labelledby="dropdownMenuLink-2">
            <li><a class="expanded_link dropdown-item toggle_expanded_view" href="/new-laws/amended_acts/expanded_view/{{$amendedAct['post_category']}}/{{$amendedAct['title']}}/{{$amendedAct['id']}}"><center>Expanded View</center></a></li>
            
            @if (Route::has('login'))
              @auth
                    {{-- No Subscription --}}
                    @if(auth()->user()->check_subscription == 0)
                      <li><a class="dropdown-item" href="" data-toggle="modal" data-target="#myModalplainSubscribe"><center>Plain View</center></a></li>
                      {{-- Subscription has expired --}}
                      @elseif(auth()->user()->subscription_expiry < today())
                      <li><a class="dropdown-item" href="" data-toggle="modal" data-target="#myModalplainExpiry"><center>Plain View</center></a></li>                                          
                      {{-- Subscription download limit reached --}}
                      @elseif(auth()->user()->subscription_downloads <= auth()->user()->downloads_counts)
                      <li><a class="dropdown-item" href="" data-toggle="modal" data-target="#maximumDownloadReachedplain"><center>Plain View</center></a></li>
                  
                      @else
                      {{-- View Plain View --}}
                        <li><a class="dropdown-item" href="" target="_blank"><center>Plain View</center></a></li>
                    @endif
                  @else
                {{-- Create Account --}}
                <li><a class="dropdown-item" href="" data-toggle="modal" data-target="#myModalplainAccount"><center>Plain View</center></a></li>
              @endauth
            @endif

          </div>
        </div>
    </center>
      <hr>

      <form action="" method="GET" class="mt-4">
        {{ csrf_field() }}
            <input style="padding: 13px;" class="form-control" name="search_text" type="text" placeholder="Word-search" aria-label="Search">
      </form>
        
      </div>
    </div>
  </div>
        @include('layouts.plain_view_no_subscription')
        @include('layouts.plain_view_subscription_expiry')
        @include('layouts.plain_view_downloaded_exceeded')
        @include('layouts.plain_create_account')
</div>

</body>

</html>
  