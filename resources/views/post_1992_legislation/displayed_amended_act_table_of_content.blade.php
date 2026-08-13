<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    
</head>

<body>

        <span style="color: blue;">{{ $amendedAct['title'] }}</span>
        {{-- style="display:none;" --}}
        <div class="container" style="display:none;">
            <a href="/new-laws/display_amended_sections/{{$amendedAct['title']}}" class="single_container_details_link_amend"><p>Click to View details</p>
            </a>
        </div>
    
           
        <div class="container">
            {{-- <a href="/new-laws/amended_preamble/{{ $amendedAct['id'] }}" class="single_preamble_amended_link" style="color: blue;">Introductory Text</a> --}}

            <div style="height: auto;">
                @include('post_1992_legislation.displayed_amended_act_parts_section')
            </div>
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





    


                         
