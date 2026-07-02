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
        .scroll-view {
          height: auto;
          max-height: 280px;
          width: 380px;
          /* overflow-x: scroll;
          overflow-y: scroll; */
          overflow: scroll;
          -ms-overflow-style: -ms-autohiding-scrollbar;
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
            <div class="dropdown mb-3">
              <a class="btn btn-outline-dark dropdown-toggle btn-customised" href="#" role="button" id="dropdownMenuLink-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span>Select Articles</span>
              </a>
              <div class="dropdown-menu scroll-view" aria-labelledby="dropdownMenuLink-3">
                @foreach($constitutionContents as $constitutionContent)
                    <a data-scroll-to="body"
                    data-scroll-focus="body"
                    data-scroll-speed="400"
                    data-scroll-offset="-60" class="constitution_view_all_section_link_with_prev_next dropdown-item" sid="{{$constitutionContent->id}}" href="/constitution/Republic/constitution_content/{{ $constitutionContent->id }}">{{$constitutionContent->section }}
                    </a>
                @endforeach              
              </div>
            </div>

            
        <div class="mb-2 preamble_hide_pre_next">
            <button a data-scroll-to="body"
            data-scroll-focus="body"
            data-scroll-speed="400"
            data-scroll-offset="-60" type="button" class="btn btn-outline-dark btn-sm previous_content_constitution_act btn-customised">
            &laquo;&nbsp;Previous
            </button>
            <button a data-scroll-to="body"
            data-scroll-focus="body"
            data-scroll-speed="400"
            data-scroll-offset="-60" type="button" class="btn btn-outline-dark btn-sm next_content_constitution_act btn-customised">
            Next&nbsp;&raquo;
            </button>
        </div>
        <hr>
        <div class="mt-5">
          <button a data-scroll-to="body"
              data-scroll-focus="body"
              data-scroll-speed="400"
              data-scroll-offset="-60" type="button" class="btn btn-outline-dark btn-sm expanded_link toggle_expanded_view btn-customised" href="/constitution/Republic/expanded_view/{{ $ghana_act['id'] }}">
              Expanded View
          </button>
        <div>
          
        </center>
                
      </div>
      
    </div>
    <div class="card mt-3">
      @include('ads.small_ads_image_main_page')
    </div>
  </div>
        
</div>

</body>

</html>
  