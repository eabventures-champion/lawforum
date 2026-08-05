
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <link rel="stylesheet" href="{{ asset('css/tooltipster.bundle.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/tooltipster-sideTip-borderless.min.css') }}" type="text/css">    
</head>

<body>

<div>
{{--
<div class="header_only" style="margin-bottom: 5px;">
    <p><b>{{ $amendedAct['title'] }}</b></p>
</div>
--}}

<div>
    <span class="text-left mb-5" style="color: blue;">Full Act
    &nbsp;&nbsp;&nbsp;&nbsp;<a class="pull-right" id="print_options" href="#">Print Options</a>
    </span>

    <div class="menu_options pull-right" style="display: none;">
      @if (Route::has('login'))
        @auth

            {{-- No Subscription --}}
            @if(auth()->user()->check_subscription == 0)
                @include('layouts.no_subscription')
                    
                {{-- Subscription has expired --}}
                @elseif(auth()->user()->subscription_expiry < today())
                @include('layouts.expired_subscription')
                    
                {{-- Subscription download limit reached --}}
                @elseif(auth()->user()->subscription_downloads <= auth()->user()->downloads_counts)
                @include('layouts.exceeded_downloads_subscription')

                    {{-- Download PDF and Others --}}
                    @else
                      {{-- DOWNLOAD PDF --}}
                      <a class="amended_act_download_link" href="javascript:;" rel="/new-laws/pdf_expanded_amended_act/content/{{$amendedAct['post_category']}}/{{$amendedAct['title']}}/{{ $amendedAct['id'] }}"><img alt="Brand" src="{{ asset('/logo/pdf.png') }}" style="width:1.5em;">&nbsp;PDF</a>&nbsp;&nbsp;||&nbsp;
                      {{-- SAVE USER DOWNLOAD --}}
                      <a class="amended_act_id hidden" href="javascript:;" rel="/acts-downloads/{{$amendedAct['title']}}/{{ Auth::user()->name }}/{{ Auth::user()->id }}/{{$amendedAct['post_category']}}/{{$amendedAct['id']}}/{{ Auth::user()->id }}{{$amendedAct['title']}}"><img alt="Brand" src="{{ asset('/logo/pdf.png') }}" style="width:1.5em;">&nbsp;PDF</a>
                      {{-- PLAIN VIEW --}}
                      <a href="/new-laws/plain_expanded_amended_act/content/{{$amendedAct['post_category']}}/{{$amendedAct['title']}}/{{ $amendedAct['id'] }}" target="_blank">Plain View</a>&nbsp;&nbsp;||&nbsp;
                      {{-- PRINT --}}
                      <a href="/new-laws/print_expanded_amended_act/content/{{$amendedAct['post_category']}}/{{$amendedAct['title']}}/{{ $amendedAct['id'] }}" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true"></span>&nbsp;Print Preview</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              @endif

            @else
            {{-- Create Account --}}
            <a href="" data-toggle="modal" data-target="#myModal"><img alt="Brand" src="{{ asset('/logo/pdf.png') }}" style="width:1.5em;">&nbsp;PDF</a>&nbsp;&nbsp;||&nbsp;
            <a href="" data-toggle="modal" data-target="#myModal">Plain View</a>&nbsp;&nbsp;||&nbsp;
            <a href="" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-print" aria-hidden="true"></span>&nbsp;Print</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

             <!--Create Account Modal -->
             <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel"><b>Kindly Log In or Sign Up to Create An Account</b></h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
                  </div>
                  <div class="modal-body">
                      <a class="btn btn-sm bg-header-color text-white" href="{{ route('login') }}">Login</a>
                      <a class="btn btn-sm bg-header-color text-white" href="{{ route('register') }}">Sign Up</a>
                  </div>
              </div>
              </div>
          </div>

        @endauth
      @endif

    </div>
    {{-- End of pull-right --}}
</div>

  <div class="content">	

      @if($amendedAct['preamble'] != null)
        <p class="text-left" style="color: blue;">Introductory Text</p>
        <span>{!! $amendedAct['preamble'] !!}</span><hr>
      @else
          <span></span>
      @endif

      @foreach($allAmendedArticles as $allAmendedArticle)
        <span class="text-left" style="color: blue; font-size: 1rem;"><u>{{$allAmendedArticle->section }}</u></span>
        <span>{!! $allAmendedArticle->content !!}</span>
      @endforeach

  </div>

</div>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>

<script>
    $(".amended_act_id").click(function(e){
        e.preventDefault();
        var amended_act_id = $(this).attr("rel");
        console.log(amended_act_id);

        $.ajax({
            url: amended_act_id,
            type: "GET",
            success:function(response){
            if(response.success){
                  $("#bookmarked").notify(
                      response.message,
                { position:"left", className: "info", autoHideDelay: 900000}
                );
            }else{
                $("#bookmarked").notify(
               "Section to Download",
                { position:"left", className: "success", autoHideDelay: 10000}
                );
              }
            },
            error:function (){
                $("#bookmarked").notify(
               "Issue with database entry",
                { position:"left", className: "error" }
                );
            }
        });

    });
    
</script>

<script>
    $(".amended_act_download_link").click(function(e){
        e.preventDefault();
        var amended_act_download_link = $(this).attr("rel");
        $('.amended_act_id').trigger("click");
       
        $.ajax({
            url: amended_act_download_link,
            type: "GET",
        });
    });  
</script>

</body>

</html>










