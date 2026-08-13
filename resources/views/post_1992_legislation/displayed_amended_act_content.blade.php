<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <link rel="stylesheet" href="{{ asset('css/tooltipster.bundle.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/tooltipster-sideTip-borderless.min.css') }}" type="text/css"> 
    <style>
        .nav-links{
        background-color: #f5f5f5;
        border: .1px solid #ddd;
        border-radius: .25rem;
        display: block;
        padding: .1rem .9rem;
        }
    </style>   
</head>

<body>
    <span style="color: blue;">{{ $amendedContent['act_title'] }}</span>
    <div class="nav-links">
        <span>{{ $amendedContent['section'] }}</span>
    </div>

    <div style="margin-bottom: 5px;">
        &nbsp;&nbsp;&nbsp;&nbsp;<a class="pull-right" id="print_options" href="#">Print Options</a>
        <div class="menu_options pull-right" style="display: none;">
            @if (Route::has('login'))
                @auth
                    <a href="/new-laws/pdf/amended_content_section/{{$amendedContent['act_title']}}/{{ $amendedContent['id'] }}"><img alt="Brand" src="{{ asset('/logo/pdf.png') }}" style="width:1.5em;">&nbsp;PDF</a>&nbsp;&nbsp;||&nbsp;
                    {{-- <a href="/new-laws/plain_amended/content_section/{{ $amendedContent['id'] }}" target="_blank">Plain View</a>&nbsp;&nbsp;||&nbsp; --}}
                    <a href="/new-laws/print_amended/content_section/{{ $amendedContent['id'] }}" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true"></span>&nbsp;Print</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        
                    @else

                    <a href="" data-toggle="modal" data-target="#myModal"><img alt="Brand" src="{{ asset('/logo/pdf.png') }}" style="width:1.5em;">&nbsp;PDF</a>&nbsp;&nbsp;||&nbsp;
                    {{-- <a href="/new-laws/plain_amended/content_section/{{ $amendedContent['id'] }}" target="_blank">Plain View</a>&nbsp;&nbsp;||&nbsp; --}}
                    <a href="" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-print" aria-hidden="true"></span>&nbsp;Print</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        
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
    </div>

    <div class="content">
        <p>{!! $amendedContent['content'] !!}</p>
    </div>

    {{-- <script type="text/javascript" src="https://code.jquery.com/jquery-1.10.0.min.js"></script> --}}
{{-- <script src="{{ asset('js/tooltipster.bundle.min.js') }}"></script> --}}
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>

<script>
    $(".section_id").click(function(e){
        e.preventDefault();
        var section_id = $(this).attr("rel");
        console.log(section_id);

        $.ajax({
            url: section_id,
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
    $(".download_link").click(function(e){
        e.preventDefault();
        var download_link = $(this).attr("rel");
        $('.section_id').trigger("click");
       
        $.ajax({
            url: download_link,
            type: "GET",
        });
    });  
</script>

<script>
    $('.tooltips').tooltipster({
        theme: 'tooltipster-borderless'
    });
</script>

<script>
    $('.bookmarking').click(function(e){
    e.preventDefault();
        var targetUrl = $(this).attr('rel');
    $.ajax({
            url: targetUrl,
            type: "GET",
            success:function(response){
            if(response.success){
                  $("#bookmarked").notify(
                      response.message,
                { position:"left", className: "info" }
                );
            }else{
                $("#bookmarked").notify(
               "Section bookmarked",
                { position:"left", className: "success" }
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





    


