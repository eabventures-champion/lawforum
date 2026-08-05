<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    
</head>

<body>

        <span style="color: blue;">{{ $amendedRegulationAct['title'] }}</span>
        
        <div class="container" style="display:none;">
            <a href="/new-laws/display_amended_regulation_sections/{{$amendedRegulationAct['title']}}" class="single_container_details_link_amend_regulation"><p>Click to View details</p>
            </a>
        </div>
           
        <div class="container">
            {{-- <a href="/new-laws/amended_regulation_preamble/{{ $amendedRegulationAct['id'] }}" class="single_preamble_amended_regulation_link" style="color: blue;">Introductory Text</a> --}}
            <div style="height: auto;">
                @include('post_1992_legislation.displayed_amended_regulation_act_parts_section')
            </div>
        </div>
                
                
</body>

</html>