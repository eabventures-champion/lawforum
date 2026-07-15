
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <link rel="stylesheet" href="{{ asset('css/tooltipster.bundle.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/tooltipster-sideTip-borderless.min.css') }}" type="text/css">    
</head>

<body>

<div>
    <div>
        <span class="text-left mb-5" style="color: blue;">Full Act
        </span>
        
    </div>
</div>

    <div class="content">	
        
        @if($allPre1992Act['preamble'] != null)
            <p class="text-left" style="color: blue;">Introductory Text</p>
            <span>{!! $allPre1992Act['preamble'] !!}</span><hr>
            @else
                <span></span>
        @endif

        @foreach($allPre1992Articles as $allPre1992Article)
            <span class="text-left" style="color: blue; font-size: 1rem;"><u>{!! $allPre1992Article->section !!}</u></span>
            <span>{!! $allPre1992Article->content !!}</span>
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

</body>

</html>










