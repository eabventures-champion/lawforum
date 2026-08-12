
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
        <p><b>{{ $allConstitutionalAct['title'] }}</b></p>
    </div>
    --}}
    <div style="margin-bottom:5px;">
        &nbsp;&nbsp;&nbsp;&nbsp;<a class="pull-right" id="print_options" href="#">Print Options</a>
        <div class="menu_options pull-right" style="display: none;">
            @if (Route::has('login'))
                @auth
                    <a class="act_download_link" href="javascript:;" rel="/new-laws/executive-acts/pdf-full-act-content/{{$allExecutiveAct['executive_group']}}/{{$allExecutiveAct['title']}}/{{ $allExecutiveAct['id'] }}"><img alt="Brand" src="{{ asset('/logo/pdf.png') }}" style="width:1.5em;">&nbsp;PDF</a>&nbsp;&nbsp;||&nbsp;
                    <a class="act_id hidden" href="javascript:;" rel="/acts-downloads/{{$allExecutiveAct['title']}}/{{ Auth::user()->name }}/{{ Auth::user()->id }}/{{$allExecutiveAct['executive_group']}}/{{$allExecutiveAct['id']}}/{{ Auth::user()->id }}{{$allExecutiveAct['title']}}"><img alt="Brand" src="{{ asset('/logo/pdf.png') }}" style="width:1.5em;">&nbsp;PDF</a>
                    <a href="/new-laws/executive-acts/plain-view-full-act-content/{{$allExecutiveAct['executive_group']}}/{{$allExecutiveAct['title']}}/{{ $allExecutiveAct['id'] }}" target="_blank">Plain View</a>&nbsp;&nbsp;||&nbsp;
                    <a href="/new-laws/executive-acts/print_view/{{$allExecutiveAct['executive_group']}}/{{$allExecutiveAct['title']}}/{{ $allExecutiveAct['id'] }}" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true"></span>&nbsp;Print</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                    @else

                    <a href="" data-toggle="modal" data-target="#myModal"><img alt="Brand" src="{{ asset('/logo/pdf.png') }}" style="width:1.5em;">&nbsp;PDF</a>&nbsp;&nbsp;||&nbsp;
                    <a href="/new-laws/executive-acts/plain-view-full-act-content/{{$allExecutiveAct['executive_group']}}/{{$allExecutiveAct['title']}}/{{ $allExecutiveAct['id'] }}" target="_blank">Plain View</a>&nbsp;&nbsp;||&nbsp;
                    <a href="" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-print" aria-hidden="true"></span>&nbsp;Print</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                    {{-- <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <br>
                                <div class="container">
                                    <h3>Kindly <span style="color:blue;"><b>Log In</b></span> or <span style="color:blue;"><b>Register</b></span> to Create An Account</h3>
                                    <br>
                                    <a class="btn btn-sm btn-primary" href="{{ route('login') }}">Login</a>
                                    <a class="btn btn-sm btn-primary" href="{{ route('register') }}">Register</a>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div> --}}
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
                              {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                            </div>
                          </div>
                        </div>
                    </div>

                @endauth
            @endif

        </div>
    </div>

    <div class="content">	
        <h5><b>Introductory Text</b></h5> <p>{!! $allExecutiveAct['preamble'] !!}</p>
        <hr>
        @foreach($allExecutiveArticles as $allExecutiveArticle)
            <!--<center>-->
            <!--    <h4>-->
            <!--        <b>{{ $allExecutiveArticle->part }}</b>-->
            <!--    </h4>-->
            <!--</center>-->
            
            <h5><b>{{$allExecutiveArticle->section }}</b></h5>
                {!! $allExecutiveArticle->content !!}
            <hr><br>
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

@include('partials._premium_guest_gate')
</body>

</html>










