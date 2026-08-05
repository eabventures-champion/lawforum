@extends('extenders.main')
@section('title', ucwords(strtolower($allPost1992Act['title'])))

@section('assets')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.2/semantic.min.css"> --}}
<link rel="stylesheet" href="{{ asset('css/pre_second_nav.css') }}">

<style type="text/css">
        .navbar {
          min-height: 1px;
        }
        .nav>li>a {
            position: relative;
            display: block;
            padding: 5px 14px;
            color: white;
            }
        .nav>li>a:hover {
            color: #004353;
        }
        .navbar-brand {
          padding-top: 17px;
          padding-top: 17px;
          line-height: 15px;
        }
        .navbar-toggle {
          /* (80px - button height 34px) / 2 = 23px */
          margin-top: 23px;
          padding: 9px 10px !important;
        }
        @media (min-width: 768px) {
          .navbar-nav > li > a {
            /* (80px - line-height of 27px) / 2 = 26.5px */
            padding-top: 14px;
            padding-bottom: 14px;
            line-height: 10px;
          }
        }

        .header {
          background: #888888;
          color: #f1f1f1;
          text-align: center;
          position: -webkit-sticky;
          position: sticky;
          top: 0;
        }
        ::-webkit-scrollbar {
        width: 7px;
        }
        div::-webkit-scrollbar-button {
          display: block;
          width: 17px;
          height: 17px;
        }
        div::-webkit-scrollbar-button:decrement:start {
          background-color:lightblue;
          border:1px solid #eee;
        }
        div::-webkit-scrollbar-button:increment:start {
          background-color:lightblue;
          border:1px solid #eee;
        }
        div::-webkit-scrollbar-button:decrement:end {
          background-color:lightblue;
          border:1px solid #eee;
        }
        div::-webkit-scrollbar-button:increment:end {
          background-color:lightblue;
          border:1px solid #eee;;
        }
        ::-webkit-scrollbar-thumb {
        background: #888; 
        }

        ::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3); 
        border-radius: 10px;
        } 
        ::-webkit-scrollbar-thumb:hover {
        background: #555; 
        }
        .content {
          padding: 16px;
        }
        .content-fluid{
            padding: 0.1px;
        }
        .accordion-content {
        height: 600px;
        overflow-y: auto;
        }
        .bg-header-color{
            background-color: #004353;
        }
        .bg-header-color-tabs{
            /* background-color: #539bad; */
            /* #539bad,#989898 */
            background-color: #8DD8CA;
        }
        .form-group-customised{
            margin-bottom: .1px;
        }
        .search-form{
          padding-right: 10px;
          padding-top: 3px;
      }
      .search-form .form-group {
          float: right !important;
          transition: all 0.35s, border-radius 0s;
          width: 32px;
          height: 32px;
          background-color: #fff;
          box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
          border-radius: 25px;
          border: 1px solid #ccc;
      }
          .search-form .form-group input.form-control {
          padding-right: 20px;
          border: 0 none;
          background: transparent;
          box-shadow: none;
          display:block;
      }
          .search-form .form-group input.form-control::-webkit-input-placeholder {
          display: none;
      }
          .search-form .form-group input.form-control:-moz-placeholder {
          /* Firefox 18- */
          display: none;
      }
          .search-form .form-group input.form-control::-moz-placeholder {
          /* Firefox 19+ */
          display: none;
      }
          .search-form .form-group input.form-control:-ms-input-placeholder {
          display: none;
      }
          .search-form .form-group:hover,
          .search-form .form-group.hover {
          width: 200%;
          border-radius: 4px 25px 25px 4px;
      }
          .search-form .form-group span.form-control-feedback {
          position: absolute;
          top: -1px;
          right: -2px;
          z-index: 2;
          display: block;
          width: 34px;
          height: 34px;
          line-height: 34px;
          text-align: center;
          color: #3596e0;
          left: initial;
          font-size: 14px;
      }
      .panel-title{
          font-size: 14px;
      }
      .shadow-background{
        box-shadow: 0 1px 5px #e0e0e0;
        background-color: #FFFFFF;
      }.highlight
{
 color:blue;
 text-decoration:underline;}
      
</style>

@endsection

@section('content')

{{--
@section('second_nav')
    @include('post_1992_legislation.post_1992_legislation_menu')
@endsection
--}}

<div class="container-fluid content-fluid"> 
    <div class="row">
        <div class="col-md-9">
            <div class="shadow-background">
                <div style="padding: 15px;">
                @include('post_1992_legislation.post_1992_legislation_menu')
                    <center>
                    <p style="font-size:18px;"><b class="small">{{ $allPost1992Act['title'] }}</b></p>
                    </center>
                    @include('flash-message')
                    {{-- Nav tabs -- for the tab Panel--}}
                    <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
                        <!--Acts -->
                        <li class="active">
                            <a href="#tableOfContentTab" data-toggle="tab" class="tabPaned_color_table_of_table">Table of Contents</a>
                        </li>
                        <li class="tabPanedHide_acts_content">
                            <a href="#contentTab" data-toggle="tab" class="bg-color-content">Content</a>
                        </li>

                        <!-- Expanded View -->
                        <li class="tabPanedHide_expanded_view">
                            <a href="#expandedTab" data-toggle="tab" class="bg-color-expanded">Expanded View</a>
                        </li>  

                        <!-- Amendments -->
                        <li class="tabPanedHide_amendments">
                            <a href="#all_amendmentsTab" data-toggle="tab" class="bg-color-amendments">Amendments</a>
                        </li>
                        <li class="tabPanedHide_amendments_table">
                            <a href="#amended_table_of_Content_Tab" data-toggle="tab" class="bg-color-amendments-table">Amendments Table of Contents</a>
                        </li>
                        <li class="tabPanedHide_amendments_content">
                            <a href="#amendmentcontentTab" data-toggle="tab" class="bg-color-amendments-contents">Amended Content</a>
                        </li>

                        <!-- Regulations -->
                        <li class="tabPanedHide_regulations">
                            <a href="#all_regulationsTab" data-toggle="tab" class="bg-color-regulations">Regulations</a>
                        </li>
                        <li class="tabPanedHide_regulations_table">
                            <a href="#regulated_table_of_Content_Tab" data-toggle="tab" class="bg-color-regulations-table">Regulations Table of Contents</a>
                        </li>
                        <li class="tabPanedHide_regulations_content">
                            <a href="#regulatedcontentTab" data-toggle="tab" class="bg-color-regulations-contents">Regulation Content</a>
                        </li>
                    </ul>
                    {{-- ------------------------------------------------------End of Nav tab for the panels----------------------------------------------------------- --}}



                    {{-- tab panes content --}}
                    <div id="my-tab-content" class="tab-content">

                        {{-- table of Contents --}}
                        <div id="tableOfContentTab" class="tab-pane fade in active">

                            <div class="row">
                                <div class="col-md-9">
                                    <br>
                                    
                                <a class="preamble_link" id="preamble_link_toggle" href="/new-laws/preamble/{{ $allPost1992Act['id'] }}">
                                    
                                    @if($allPost1992Act['preamble'] != null)
                                        <p class="preamble_hide">Introductory Text</p>

                                        @elseif($allPost1992Act['preamble'] == null  && ($amendedcount < 0 && $regulationcount < 0))
                                            @section('scripts')
                                                <script>
                                                $( ".preamble_hide" ).hide();
                                                $( ".no_list" ).hide();
                                                </script>
                                            @endsection

                                        @elseif($allPost1992Act['preamble'] == null  && ($amendedcount > 0))
                                            @section('scripts')
                                                <script>
                                                $( ".preamble_hide" ).hide();
                                                $( ".no_list" ).show();
                                                </script>
                                            @endsection  
                                            
                                        @elseif($allPost1992Act['preamble'] == null  && ($regulationcount > 0))
                                            @section('scripts')
                                                <script>
                                                $( ".preamble_hide" ).hide();
                                                $( ".no_list" ).show();
                                                </script>
                                            @endsection

                                        @else
                                            @section('scripts')
                                                <script>
                                                $( ".preamble_hide" ).hide();
                                                $( ".no_list" ).hide();
                                                </script>
                                            @endsection
                                    @endif
                                </a>
                                        <div class="accordion-content">
                                            @include('post_1992_legislation.displayed_parts_sections')
                                        </div>
                                            
                                        <div class="col-md-12 text-center">
                                            <!--<ul id="myPager" class="pagination"></ul>-->
                                            <p><a data-scroll-to="body"
                                            data-scroll-focus="body"
                                            data-scroll-speed="400"
                                            data-scroll-offset="-60" href="#" data-scroll-to="body">Move to Top</button></p>
                                        </div>
                                    
                                </div> 
                                    @include('post_1992_legislation.container_main_act_page')
                            </div> 
                        </div>
                        {{-- -------------------------------------------------------End of table of Contents---------------------------------------------------------------- --}}



                        {{-- Contents --}}
                        <div id="contentTab" class="tab-pane fade">
                        <!-- <span style="padding: .2em;"> -->
                            <div class="row">
                                <div class="col-md-9 table-wrapper-scroll-display" style="height: auto">
                                        <div id="display_content"></div>
                                        <div id="display_preamble"></div>
                                        <div id="display_view_all_section"></div>
                                </div>
                                @include('post_1992_legislation.container_details_main_act_page')
                            </div>   
                            
                            <div class="row show">
                                <div class="col-md-9">
                                    <ul class="pager">
                                        <li><a data-scroll-to="body"
                                            data-scroll-focus="body"
                                            data-scroll-speed="400"
                                            data-scroll-offset="-60" href="#" class="previous_content_act">&laquo;&nbsp;Previous Section</a></li>
                                        <li><a data-scroll-to="body"
                                            data-scroll-focus="body"
                                            data-scroll-speed="400"
                                            data-scroll-offset="-60" href="#" class="next_content_act">Next Section&nbsp;&raquo;</a></li>
                                    </ul>
                                </div>
                            </div>
                            
                        </div> 
                        {{-- -------------------------------------------------------End of Contents---------------------------------------------------------------- --}}

                        
                        <!-- ACTS EXPANDED CONTENTS -->
                        <div id="expandedTab" class="tab-pane fade">
                        <span style="padding: .2em;"></span>
                                <div class="row">
                                    <div class="col-md-12 expanded_view" style="background-color: #FFFFFF;">
                                        <div id="acts_expanded_view"></div> 
                                    </div>
                                    {{--@include('post_1992_legislation.container_details_act_expanded')--}}
                                </div>
                        </div>
                        {{-- -------------------------------------------------------End of Expanded View Content---------------------------------------------------------------- --}}


                        <!-- ALL AMENDMENTS LISTS -->
                        <div id="all_amendmentsTab" class="tab-pane fade">
                                <div class="row">
                                        <div class="col-md-9">
                                            <div id="all_amendments" class="amended_act_toggle"></div>
                                        </div>
                                        @include('post_1992_legislation.container_main_amended_act_page')
                                </div>
                        </div>
                        {{-- -------------------------------------------------------End of All Amendments Lists---------------------------------------------------------------- --}}


                        <!-- AMENDMENTS TABLE OF CONTENTS -->
                        <div id="amended_table_of_Content_Tab" class="tab-pane fade">
                                <div class="row">
                                    <div class="col-md-9">
                                        <div id="amended_table_of_content" class="amended_act_toggle_content"></div>   
                                    </div>
                                    
                                    @include('post_1992_legislation.container_expanded_amended_act_page')

                                </div>
                        </div>
                        {{-- -------------------------------------------------------End of Amendments table of contents---------------------------------------------------------------- --}}


                        <!-- AMENDMENTS CONTENT -->
                        <div id="amendmentcontentTab" class="tab-pane fade">
                                <div class="row">
                                    <div class="col-md-9 table-wrapper-scroll-display" style="height: 600px;">
                                        <div id="single_preamble_amended_content"></div>
                                        <div id="single_amended_content"></div>
                                        <div id="single_view_all_sections_amend"></div> 
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div id="single_container_details_amend"></div>
                                    </div>
                                    
                                    {{-- ADVERTISEMENT
                                    <div class="col-md-3">
                                        <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <p class="panel-title"><small>Advertisement</small></p>
                                        </div>
                                        <div class="panel-body">
                                            <div class="embed-responsive embed-responsive-4by3">
                                                <iframe width="420" height="345" src="https://www.youtube.com/embed/tgbNymZ7vqY"></iframe>       
                                            </div>        
                                        </div>
                                        </div>
                                    </div>
                                    --}}
                                </div>
                                
                                    <div class="row show">
                                        <div class="col-md-9">
                                        <ul class="pager">
                                            <li><a data-scroll-to="body"
                                                data-scroll-focus="body"
                                                data-scroll-speed="400"
                                                data-scroll-offset="-60" href="#" class="previous_amended_under_act">&laquo;&nbsp;Previous Section</a></li>
                                            <li><a data-scroll-to="body"
                                                data-scroll-focus="body"
                                                data-scroll-speed="400"
                                                data-scroll-offset="-60" href="#" class="next_amended_under_act">Next Section&nbsp;&raquo;</a></li>
                                        </ul>
                                        </div>
                                    </div>
                                
                        </div>
                        {{-- -------------------------------------------------------End of Amendments contents---------------------------------------------------------------- --}}


                        <!--ALL REGULATION LIST -->
                        <div id="all_regulationsTab" class="tab-pane fade">
                                <div class="row">
                                    <div class="col-md-9">
                                        <div id="all_regulations" class="regulation_act_toggle"></div>  
                                    </div>
                                    @include('post_1992_legislation.container_main_regulations_act_page')
                                </div>
                        </div>
                        {{-- -------------------------------------------------------End of Regulation List---------------------------------------------------------------- --}}


                            <!-- REGULATIONS TABLE OF CONTENTS -->
                            <div id="regulated_table_of_Content_Tab" class="tab-pane fade">
                                <div class="row">
                                        <div class="col-md-9">
                                        <div id="regulated_table_of_content" class="regulation_act_toggle_content"></div>   
                                        </div>
                                        @include('post_1992_legislation.container_expanded__regulation_page')
                                </div>
                            </div>
                            {{-- -------------------------------------------------------End of Regulation Table of Content---------------------------------------------------------------- --}}

                            <!-- REGULATIONS CONTENTS -->
                            <div id="regulatedcontentTab" class="tab-pane fade">
                                <div class="row">
                                    <div class="col-md-9 table-wrapper-scroll-display" style="height: 600px;">
                                        <div id="single_preamble_regulation_content"></div>
                                        <div id="single_regulation_content"></div>
                                        <div id="single_view_all_sections_regulation"></div> 
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div id="single_container_details_regulation"></div>
                                    </div>

                                    {{-- ADVERTISEMENT
                                    <div class="col-md-3">
                                        <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <p class="panel-title"><small>Advertisement</small></p>
                                        </div>
                                        <div class="panel-body">
                                            <div class="embed-responsive embed-responsive-4by3">
                                                <iframe width="420" height="345" src="https://www.youtube.com/embed/tgbNymZ7vqY"></iframe>       
                                            </div>        
                                        </div>
                                        </div>
                                    </div>
                                    --}}
                                </div>
                                
                                <div class="row show">
                                        <div class="col-md-9">
                                        <ul class="pager">
                                            <li><a data-scroll-to="body"
                                                data-scroll-focus="body"
                                                data-scroll-speed="400"
                                                data-scroll-offset="-60" href="#" class="previous_regulation_under_act">&laquo;&nbsp;Previous Regulation</a></li>
                                            <li><a data-scroll-to="body"
                                                data-scroll-focus="body"
                                                data-scroll-speed="400"
                                                data-scroll-offset="-60" href="#" class="next_regulation_under_act">Next Regulation&nbsp;&raquo;</a></li>
                                        </ul>
                                        </div>
                                </div>
                                
                            </div>
                            {{-- -------------------------------------------------------End of Regulation Content---------------------------------------------------------------- --}}

                            
                    </div><!--end of tab panes content row-->
                </div>
        </div>
        </div>
        <!-- for the ads -->
        @include('extenders.ads')
    </div>
</div><!--end of container-fluid-->

@endsection

@section('scripts')
{{-- <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script> --}}
{{-- <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script> --}}

<script>
document.addEventListener('copy', function (e){
    e.preventDefault();
    e.clipboardData.setData("text/plain", "Do not copy this site's content!");
})
</script>

<script>
    $(document).ready(function() {
        $('.clickme').click(function(e) {
            e.preventDefault();
            boxh = $('#popup').height();
            windowh = $(window).height();
            $('#popup').css('margin-top', windowh/2 - boxh/2);
            $('#popup').fadeIn();
        });
        $('.clicktoclose').click(function() {
            $('#popup').fadeOut;
        });
    });
</script>


    {{-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script> --}}
@endsection



