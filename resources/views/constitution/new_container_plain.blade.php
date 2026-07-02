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
                    <li><a class="expanded_link dropdown-item toggle_expanded_view" href="/constitution/Republic/expanded_view/{{ $ghana_act['id'] }}"><center>Expanded View</center></a></li>
                    
                    @if (Route::has('login'))
                        @auth
                            {{-- View Plain View --}}
                                <li><a class="dropdown-item" href="/constitution/Republic/{{$ghana_act['gh_group']}}/{{$ghana_act['title']}}/plain_view/{{ $ghana_act['id'] }}" target="_blank"><center>Plain View</center></a></li>
                            @else
                            {{-- Create Account --}}
                            <li><a class="dropdown-item" href="" data-toggle="modal" data-target="#myModalplainAccount"><center>Plain View</center></a></li>
                        @endauth
                    @endif

                </div>
              </div>
          </center>
          <hr>

        <form action="{{ url('search_ghana_constitution') }}" method="GET" class="mt-4">
          {{ csrf_field() }}
              <input style="padding: 13px;" class="form-control" name="search_text" type="text" placeholder="Word-search" aria-label="Search">
        </form>
      </div>
    </div>
    <div class="card mt-3">
      @include('ads.small_ads_image_main_page')
    </div>
  </div>
        @include('layouts.plain_create_account')
</div>

</body>

</html>
  