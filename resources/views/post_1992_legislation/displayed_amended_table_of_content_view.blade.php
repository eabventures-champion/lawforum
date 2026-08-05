@extends('extenders.main')
@section('title', ucwords(strtolower($amendedAct['title'])))

@section('assets')
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
      }
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
              <center><p style="font-size:18px;"><b class="small">{{ $amendedAct['title'] }}</b></p></center>

              {{-- Nav tabs --}}
              <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
                  <li class="active">
                      <a href="#tableOfContentTab" data-toggle="tab" class="tabPaned_color_table_of_table">Table of Contents</a>
                  </li>
                  <li class="tabPanedHide_acts_content">
                      <a href="#contentTab" data-toggle="tab" class="bg-color-content">Contents</a>
                  </li> 
                  <!-- Expanded View -->
                  <li class="tabPanedHide_expanded_view">
                          <a href="#expandedTab" data-toggle="tab" class="bg-color-expanded">Expanded View</a>
                  </li>   
              </ul>
              {{-- ------------------------------------------------------End of Nav tab for the panels----------------------------------------------------------- --}}


              {{-- tab panes content --}}
              <div id="my-tab-content" class="tab-content">

              {{-- table of Contents --}}
                  <div id="tableOfContentTab" class="tab-pane fade in active">
                      <div class="row">
                          <div class="col-md-9">
                              {{--<h5><b>{{ $amendedAct['title'] }}</b></h5>--}}
                              <br>
                            <a class="preamble_link" id="preamble_link_toggle" href="/new-laws/amended_acts/preamble/{{ $amendedAct['id'] }}"><p>Introductory Text</p></a>
                            
                                  <div class="accordion-content">
                                      @include('post_1992_legislation.displayed_amended_parts_sections')
                                  </div>
                                  
                                  <div class="col-md-12 text-center">
                                      <!--<ul id="myPager" class="pagination"></ul>-->
                                      <p><a data-scroll-to="body"
                                      data-scroll-focus="body"
                                      data-scroll-speed="400"
                                      data-scroll-offset="-60" href="#" data-scroll-to="body">Move to Top</button></p>
                                  </div>
                          </div> 
                                  @include('post_1992_legislation.container_main_amended_acts_page')
                      </div>

                  </div>
                  {{-- -------------------------------------------------------End of table of Contents---------------------------------------------------------------- --}}

                  {{-- Contents --}}
                  <div id="contentTab" class="tab-pane fade">
                    <div class="row">
                      <div class="col-md-9 table-wrapper-scroll-display" style="height: 600px;">
                          <div id="display_content"></div>
                          <div id="display_preamble"></div>
                          <div id="display_view_all_section"></div>
                      </div>
                                  @include('post_1992_legislation.container_details_main_amended_acts_page')
                    </div>
                    
                      <div class="row show">
                          <div class="col-md-9">
                          <ul class="pager">
                              <li><a data-scroll-to="body"
                                  data-scroll-focus="body"
                                  data-scroll-speed="400"
                                  data-scroll-offset="-60" href="#" class="previous_content_amendments">Previous Section</a></li>
                              <li><a data-scroll-to="body"
                                  data-scroll-focus="body"
                                  data-scroll-speed="400"
                                  data-scroll-offset="-60" href="#" class="next_content_amendments">Next Section</a></li>
                          </ul>
                          </div>
                      </div>
                    
                  </div>
                  {{-- -------------------------------------------------------End of Contents---------------------------------------------------------------- --}}


                  <!-- ACTS EXPANDED CONTENTS -->
                  <div id="expandedTab" class="tab-pane fade">
                  <span style="padding: .2em;">
                          <div class="row">
                              <div class="col-md-12 expanded_view" style="background-color: #FFFFFF;">
                                  <div id="acts_expanded_view"></div> 
                              </div>
                              {{--@include('post_1992_legislation.container_details_act_expanded_amended_act')--}}
                          </div>
                  </div>
                  {{-- -------------------------------------------------------End of Expanded View Content---------------------------------------------------------------- --}}


              </div>
          </div>
              </div>
        </div>
        <!-- for the ads -->
        @include('extenders.ads')
  </div>    
</div><!--end of container-fluid-->

@endsection

