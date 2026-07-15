@extends('extenders.main')

@section('title', ucwords(strtolower($allPre1992Act['title'])))

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
      }


        /* ============================================
           PREMIUM FIXED NAVIGATION BAR (SHARED)
           ============================================ */
        :root {
            --bg-primary: #060a13;
            --bg-secondary: #0c1220;
            --bg-tertiary: #111827;
            --card-bg: rgba(17, 24, 39, 0.65);
            --card-bg-hover: rgba(25, 35, 55, 0.8);
            --border-color: rgba(255, 255, 255, 0.06);
            --border-hover: rgba(255, 255, 255, 0.12);
            --accent: #3b82f6;
            --accent-light: #60a5fa;
            --accent-glow: rgba(59, 130, 246, 0.25);
            --accent-gradient: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            --gold: #f59e0b;
            --gold-glow: rgba(245, 158, 11, 0.2);
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        .nav-wrap,
        .nav-wrap *,
        .nav-menu-links-premium,
        .nav-menu-links-premium *,
        .nav-link-btn,
        .nav-link-btn *,
        .nav-dropdown-menu,
        .nav-dropdown-menu a {
            font-family: var(--font) !important;
        }

        .nav-wrap {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 70px;
            z-index: 1000;
            background: rgba(6, 10, 19, 0.88) !important;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-color) !important;
            padding: 0 !important;
        }

        .nav-inner {
            max-width: 1440px;
            margin: 0 auto;
            padding: 16px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            height: 100%;
        }

        .nav-logo img {
            height: 38px;
            width: auto;
            transition: transform 0.3s ease;
        }

        .nav-menu-links-premium {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .nav-link-dropdown {
            position: relative;
        }

        .nav-link-btn {
            font-size: 14px !important;
            font-weight: 500 !important;
            color: var(--text-secondary) !important;
            padding: 8px 14px !important;
            border-radius: 8px !important;
            background: transparent !important;
            border: none !important;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .nav-link-btn:hover {
            color: var(--text-primary) !important;
            background: rgba(255, 255, 255, 0.05) !important;
        }

        .nav-link-btn i {
            font-size: 10px !important;
            color: var(--text-muted) !important;
        }

        .nav-dropdown-menu {
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            min-width: 220px;
            background: rgba(17, 24, 39, 0.95) !important;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-color) !important;
            border-radius: 12px !important;
            padding: 8px !important;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
        }

        .nav-link-dropdown:hover .nav-dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .nav-dropdown-menu a {
            display: flex !important;
            align-items: center;
            gap: 10px;
            padding: 10px 14px !important;
            border-radius: 8px !important;
            font-size: 14px !important;
            color: var(--text-secondary) !important;
            transition: all 0.2s ease;
            text-align: left;
            text-decoration: none !important;
        }

        .nav-dropdown-menu a:hover {
            color: var(--text-primary) !important;
            background: rgba(255, 255, 255, 0.06) !important;
        }

        .nav-dropdown-divider {
            height: 1px;
            background: var(--border-color);
            margin: 6px 0;
        }

        .nav-auth {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-login {
            font-size: 13px !important;
            font-weight: 600 !important;
            color: var(--text-primary) !important;
            padding: 8px 18px !important;
            border-radius: 8px !important;
            border: 1px solid var(--border-hover) !important;
            background: transparent !important;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none !important;
        }

        .btn-login:hover {
            background: rgba(255, 255, 255, 0.06) !important;
            border-color: rgba(255, 255, 255, 0.2) !important;
        }

        .btn-signup {
            font-size: 13px !important;
            font-weight: 600 !important;
            color: #fff !important;
            padding: 8px 18px !important;
            border-radius: 8px !important;
            border: none !important;
            background: var(--accent-gradient) !important;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px var(--accent-glow) !important;
            text-decoration: none !important;
        }

        .btn-signup:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 18px var(--accent-glow) !important;
        }

        .nav-user-dropdown {
            position: relative;
        }

        .nav-user-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px !important;
            border-radius: 8px !important;
            border: 1px solid var(--border-color) !important;
            background: var(--card-bg) !important;
            color: var(--text-primary) !important;
            font-size: 14px !important;
            font-weight: 500 !important;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .nav-user-btn:hover {
            background: var(--card-bg-hover) !important;
            border-color: var(--border-hover) !important;
        }

        .nav-user-dropdown.active .nav-dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .nav-dropdown-menu a.logout-link {
            color: #f43f5e !important;
        }

        .nav-dropdown-menu a.logout-link:hover {
            background: rgba(244, 63, 94, 0.1) !important;
        }

    </style>

@endsection

@section('content')

{{-- @section('second_nav')
    @include('pre_1992_legislation.pre_1992_legislation_menu')
@endsection --}}

<div class="container-fluid content-fluid"> 
  <div class="row">
    <div class="col-md-9">
        <div class="shadow-background">
            <div style="padding: 15px;">
    @include('pre_1992_legislation.pre_1992_legislation_menu')
    <center>  
    <p style="font-size:18px;"><b class="small">{{ $allPre1992Act['title'] }}</b></p>
    </center>   
    {{-- Nav tabs --}}
    <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">

        <!-- ACTS TABLE OF CONTENT -->
        <li class="active">
            <a href="#tableOfContentTab" data-toggle="tab" class="tabPaned_color_table_of_table">Table of Contents</a>
        </li>

        <!-- ACTS CONTENTS -->
        <li class="tabPanedHide_acts_content">
            <a href="#contentTab" data-toggle="tab" class="bg-color-content">Content</a>
        </li>

        <!-- ACTS EXPANDED CONTENTS -->
        <li class="tabPanedHide_expanded_view">
                <a href="#expandedTab" data-toggle="tab" class="bg-color-expanded">Expanded View</a>
        </li>  
    </ul>
    {{-- ------------------------------------------------------End of Nav tab for the panels----------------------------------------------------------- --}}


    {{-- tab panes content --}}
    <div id="my-tab-content" class="tab-content">

        <!-- ACTS TABLE OF CONTENT -->
        <div id="tableOfContentTab" class="tab-pane fade in active">

            <div class="row">
                <div class="col-md-9">
                   <br>
                   
                   <a class="preamble_link" id="preamble_link_toggle" href="/pre_1992_legislation/preamble/{{ $allPre1992Act['id'] }}">
                      
                      @if($allPre1992Act['preamble'] != null)
                        <p class="preamble_hide">Introductory Text</p>
                        @else
                            @section('scripts')
                                <script>
                                $( ".preamble_hide" ).hide();
                                </script>
                            @endsection
                      @endif
                   </a>
                   
                   <div class="accordion-content">
                        @include('pre_1992_legislation.displayed_parts_sections')
                   </div>      

                        <div class="col-md-12 text-center">
                            <!--<ul id="myPager" class="pagination"></ul>-->
                            <p><a data-scroll-to="body"
                            data-scroll-focus="body"
                            data-scroll-speed="400"
                            data-scroll-offset="-60" href="#" data-scroll-to="body">Move to Top</button></p>
                        </div>
                    
                </div> 
                    @include('pre_1992_legislation.container_main_act_page')
            </div> 
        </div>
        {{-- -------------------------------------------------------End of table of Contents---------------------------------------------------------------- --}}


        <!-- ACTS CONTENTS -->
        <div id="contentTab" class="tab-pane fade">
            <div class="row">
                <div class="col-md-9 table-wrapper-scroll-display" style="height: 600px;">
                    <div id="display_content"></div>
                    <div id="display_preamble"></div>
                    <div id="display_view_all_section"></div>
                </div>
                @include('pre_1992_legislation.container_details_main_act_page')
            </div>   
            
            <div class="row show">
                <div class="col-md-7">
                 <ul class="pager">
                    <li><a data-scroll-to="body"
                        data-scroll-focus="body"
                        data-scroll-speed="400"
                        data-scroll-offset="-60" href="#" class="previous_content_pre_act">Previous Section</a></li>
                    <li><a data-scroll-to="body"
                        data-scroll-focus="body"
                        data-scroll-speed="400"
                        data-scroll-offset="-60" href="#" class="next_content_pre_act">Next Section</a></li>
                 </ul>
                </div>
            </div>
            
         </div> 
         
         <!-- ACTS EXPANDED CONTENTS -->
         <div id="expandedTab" class="tab-pane fade">
          <span style="padding: .2em;"></span>
                <div class="row">
                     <div class="col-md-12 expanded_view" style="background-color: #FFFFFF";>
                        <div id="acts_expanded_view"></div> 
                    </div>
                      {{-- @include('pre_1992_legislation.container_details_act_expanded') --}}
                </div>
            </div>
            
    </div><!--end of row-->
  </div>
</div>
</div>
<!-- for the ads -->
@include('extenders.ads')
</div>
</div><!--end of container-fluid-->

@endsection




