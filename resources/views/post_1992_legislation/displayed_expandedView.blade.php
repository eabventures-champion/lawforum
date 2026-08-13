
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
        <p><b>{{ $allPost1992Act['title'] }}</b></p>
    </div>
    --}}
    <div style="margin-bottom:5px;">
        &nbsp;&nbsp;&nbsp;&nbsp;<a class="pull-right" id="print_options" href="#">Print Options</a>
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
                                <a class="act_download_link" href="javascript:;" rel="/new-laws/1/{{$allPost1992Act['post_group']}}/{{$allPost1992Act['title']}}/pdf-view/{{ $allPost1992Act['id'] }}"><img alt="Brand" src="{{ asset('/logo/pdf.png') }}" style="width:1.5em;">&nbsp;PDF</a>&nbsp;&nbsp;||&nbsp;
                                {{-- SAVE USER DOWNLOAD --}}
                                <a class="act_id hidden" href="javascript:;" rel="/acts-downloads/{{$allPost1992Act['title']}}/{{ Auth::user()->name }}/{{ Auth::user()->id }}/{{$allPost1992Act['post_group']}}/{{$allPost1992Act['id']}}/{{ Auth::user()->id }}{{$allPost1992Act['title']}}"><img alt="Brand" src="{{ asset('/logo/pdf.png') }}" style="width:1.5em;">&nbsp;PDF</a>  
                                {{-- PLAIN VIEW --}}
                                <a href="/new-laws/1/{{$allPost1992Act['post_group']}}/{{$allPost1992Act['title']}}/plain_view/{{ $allPost1992Act['id'] }}" target="_blank">Plain View</a>&nbsp;&nbsp;||&nbsp;
                                {{-- PRINT --}}
                                <a href="/new-laws/1/{{$allPost1992Act['post_group']}}/{{$allPost1992Act['title']}}/print_view/{{ $allPost1992Act['id'] }}" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true"></span>&nbsp;Print</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        @endif

                    @else
                    {{-- Create Account --}}
                    <a href="" data-toggle="modal" data-target="#myModal"><img alt="Brand" src="{{ asset('/logo/pdf.png') }}" style="width:1.5em;">&nbsp;PDF</a>&nbsp;&nbsp;||&nbsp;
                    <a href="" data-toggle="modal" data-target="#myModal">Plain View</a>&nbsp;&nbsp;||&nbsp;
                    <a href="" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-print" aria-hidden="true"></span>&nbsp;Print</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              <h4 class="modal-title" id="myModalLabel">Kindly <span style="color:#3490dc;">Log In</span> or <span style="color:#3490dc;">Register</span> to Create An Account</h4>
                            </div>
                            <div class="modal-body">
                                <a class="btn btn-sm btn-primarys" href="{{ route('login') }}">Login</a>
                                <a class="btn btn-sm btn-primarys" href="{{ route('register') }}">Register</a>                            
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                          </div>
                        </div>
                    </div>

                @endauth
            @endif

        </div>
    </div>

    <div class="content">	
        @if(isset($allPost1992Act['preamble']) && $allPost1992Act['preamble'] != null)
            <p class="text-left" style="color: blue;">Introductory Text</p>
            <span>{!! $allPost1992Act['preamble'] !!}</span><hr>
        @else
            <span></span>
        @endif

        @foreach($allPost1992Articles as $allPost1992Article)
            <span class="text-left" style="color: blue; font-size: 1rem;"><u>{!! $allPost1992Article->section !!}</u></span>
            <span>{!! $allPost1992Article->content !!}</span>
        @endforeach
    </div>
</div>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>

<script>
    $(".act_id").click(function(e){
        e.preventDefault();
        var act_id = $(this).attr("rel");
        console.log(act_id);

        $.ajax({
            url: act_id,
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
    $(".act_download_link").click(function(e){
        e.preventDefault();
        var act_download_link = $(this).attr("rel");
        $('.act_id').trigger("click");
       
        $.ajax({
            url: act_download_link,
            type: "GET",
        });
    });  
</script>



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










