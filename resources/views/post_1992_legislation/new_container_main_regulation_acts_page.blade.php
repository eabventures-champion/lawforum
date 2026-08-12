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
    <div class="premium-ad-card" style="margin-bottom: 20px;">
        @include('ads.placeholder_advertise')
    </div>
    <div class="card mt-3">
      @include('ads.small_ads_image_main_page')
    </div>
  </div>
        @include('layouts.plain_view_no_subscription')
        @include('layouts.plain_view_subscription_expiry')
        @include('layouts.plain_view_downloaded_exceeded')
        @include('layouts.plain_create_account')
</div>

@include('partials._premium_guest_gate')
</body>

</html>
  