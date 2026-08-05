

<div class="row">
    <div class="col-md-12">

        <div class="container"><h5><b>{{ $regulationsAct['title'] }}</b></h5></div>
        
        <div class="container" style="display: none">
            <a href="/new-laws/display_regulations_sections/{{$regulationsAct['title']}}" class="single_container_details_link_regulation"><p>Click to View details</p>
            </a>
        </div>    
          
        <div class="container">
            <a href="/new-laws/regulations_preamble/{{ $regulationsAct['id'] }}" class="single_preamble_regulation_link"><p>Introductory Text</p>
            </a>
        </div>

            <div style="height: 600px; overflow-y: auto;">
                @include('post_1992_legislation.displayed_regulations_parts_section')
            </div>

                <div class="col-md-12 text-center">
                            <!--<ul id="myPager" class="pagination"></ul>-->
                            <p><a data-scroll-to="body"
                            data-scroll-focus="body"
                            data-scroll-speed="400"
                            data-scroll-offset="-60" href="#" data-scroll-to="body">Move to Top</button></p>
                </div>
    </div> 
                         
</div>
