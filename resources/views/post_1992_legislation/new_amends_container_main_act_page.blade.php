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
  </div>
        @include('layouts.plain_view_no_subscription')
        @include('layouts.plain_view_subscription_expiry')
        @include('layouts.plain_view_downloaded_exceeded')
        @include('layouts.plain_create_account')
</div>

@include('partials._premium_guest_gate')

<!--Start of Tawk.to Script-->
<script type="text/javascript">
   var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
   (function(){
   var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
   s1.async=true;
   s1.src='https://embed.tawk.to/6a7df4c6bc79881d4b22fbbc/1jvu08a2a';
   s1.charset='UTF-8';
   s1.setAttribute('crossorigin','*');
   s0.parentNode.insertBefore(s1,s0);
   })();
</script>
<!--End of Tawk.to Script-->
</body>

</html>
  