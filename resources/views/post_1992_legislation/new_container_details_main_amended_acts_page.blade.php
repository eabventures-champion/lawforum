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
    <div class="premium-ad-card" style="margin-bottom: 20px;">
        @include('ads.placeholder_advertise')
    </div>      
                
      </div>
    </div>
  </div>
        
</div>

@include('partials._premium_guest_gate')
</body>

</html>
  