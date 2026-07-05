<!doctype html>
<html lang="en">
  <head>
    <script data-ad-client="ca-pub-4293461101625028" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Explore constitutions of all countries around the world on LawsGhana.">
    <title>All Constitutions - LawsGhana</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('logo/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('logo/favicon/favicon-16x16.png') }}">
    
    <style>
        /* ============================================
           THEME & CSS VARIABLES
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

        body {
            font-family: var(--font);
            background-color: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
            padding-top: 90px; /* offset for fixed navbar */
            padding-bottom: 40px;
        }

        /* ============================================
           PREMIUM FIXED NAVIGATION BAR
           ============================================ */
        .nav-wrap {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 70px;
            z-index: 1000;
            background: rgba(6, 10, 19, 0.88);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-color);
        }

        .nav-inner {
            max-width: 1440px;
            margin: 0 auto;
            padding: 16px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
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
            font-size: 14px;
            font-weight: 500;
            color: var(--text-secondary);
            padding: 8px 14px;
            border-radius: 8px;
            background: transparent;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .nav-link-btn:hover {
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.05);
        }

        .nav-link-btn i {
            font-size: 10px;
            color: var(--text-muted);
        }

        .nav-dropdown-menu {
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            min-width: 220px;
            background: rgba(17, 24, 39, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 8px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 100;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
        }

        .nav-link-dropdown:hover .nav-dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .nav-dropdown-menu a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 14px;
            color: var(--text-secondary);
            transition: all 0.2s ease;
            text-align: left;
            text-decoration: none !important;
        }

        .nav-dropdown-menu a:hover {
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.06);
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
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
            padding: 8px 18px;
            border-radius: 8px;
            border: 1px solid var(--border-hover);
            background: transparent;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background: rgba(255, 255, 255, 0.06);
            border-color: rgba(255, 255, 255, 0.2);
        }

        .btn-signup {
            font-size: 13px;
            font-weight: 600;
            color: #fff;
            padding: 8px 18px;
            border-radius: 8px;
            border: none;
            background: var(--accent-gradient);
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px var(--accent-glow);
        }

        .btn-signup:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 18px var(--accent-glow);
        }

        /* User dropdown */
        .nav-user-dropdown {
            position: relative;
        }

        .nav-user-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            background: var(--card-bg);
            color: var(--text-primary);
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .nav-user-btn:hover {
            background: var(--card-bg-hover);
        }

        .nav-user-btn i {
            color: var(--accent-light);
        }

        .nav-user-dropdown:hover .nav-dropdown-menu,
        .nav-user-dropdown.active .nav-dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .nav-dropdown-menu a.logout-link {
            color: #f43f5e;
        }

        .nav-dropdown-menu a.logout-link:hover {
            background: rgba(244, 63, 94, 0.1);
        }

        /* ============================================
           WORKSPACE COMPONENTS & CARDS
           ============================================ */
        .premium-card {
            background: var(--bg-secondary) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 16px !important;
            padding: 24px !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5) !important;
            margin-bottom: 24px;
        }

        .premium-sidebar-card {
            background: var(--bg-secondary) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 16px !important;
            padding: 20px !important;
            box-shadow: 0 8px 24px rgba(0,0,0,0.5) !important;
            margin-bottom: 24px;
        }

        /* Premium Continent Scroller */
        .nav-underline-premium {
            display: flex;
            gap: 6px;
            border: none !important;
            overflow-x: auto;
            padding: 6px;
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            margin-bottom: 24px;
            flex-wrap: nowrap !important;
        }

        .nav-link-premium {
            font-size: 13px !important;
            font-weight: 600 !important;
            color: var(--text-secondary) !important;
            background: transparent !important;
            border: 1px solid transparent !important;
            padding: 8px 16px !important;
            border-radius: 8px !important;
            transition: all 0.2s ease !important;
            white-space: nowrap !important;
            text-decoration: none !important;
            display: inline-flex !important;
            align-items: center;
        }

        .nav-link-premium:hover {
            color: var(--text-primary) !important;
            background: rgba(255, 255, 255, 0.05) !important;
            border-color: var(--border-color) !important;
        }

        .nav-link-premium.active {
            color: #fff !important;
            background: var(--accent-gradient) !important;
            border-color: var(--accent) !important;
            box-shadow: 0 4px 12px var(--accent-glow) !important;
        }

        /* ============================================
           PREMIUM DATATABLE OVERRIDES
           ============================================ */
        #datatable {
            background-color: #0c1220 !important;
            color: var(--text-secondary) !important;
            border-collapse: collapse !important;
        }

        #datatable th {
            background-color: #0c1220 !important;
            border-bottom: 2px solid var(--border-color) !important;
            color: var(--text-primary) !important;
            font-weight: 700 !important;
            font-size: 12px !important;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 14px 16px !important;
        }

        #datatable td {
            background-color: #0c1220 !important;
            border-bottom: 1px solid var(--border-color) !important;
            color: rgba(255, 255, 255, 0.8) !important;
            font-size: 14px !important;
            padding: 14px 16px !important;
        }

        /* Force Datatables hover highlight backgrounds to be subtle and dark */
        #datatable tbody tr:hover,
        #datatable tbody tr:hover td,
        table.dataTable.hover tbody tr:hover,
        table.dataTable.display tbody tr:hover,
        .table-hover tbody tr:hover,
        .table-hover tbody tr:hover td {
            background-color: rgba(255, 255, 255, 0.05) !important;
            background: rgba(255, 255, 255, 0.05) !important;
            color: #fff !important;
        }

        #datatable td a {
            color: var(--accent-light) !important;
            font-weight: 600 !important;
            text-decoration: none !important;
        }

        #datatable td a:hover {
            color: var(--gold) !important;
            text-decoration: underline !important;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            color: var(--text-secondary) !important;
            font-size: 13px !important;
            margin-bottom: 15px;
        }

        .dataTables_wrapper .dataTables_filter input {
            background: rgba(17, 24, 39, 0.7) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 8px !important;
            color: var(--text-primary) !important;
            padding: 6px 12px !important;
            font-size: 13px !important;
            outline: none !important;
            margin-left: 8px;
        }

        .dataTables_wrapper .dataTables_length select {
            background: rgba(17, 24, 39, 0.7) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 8px !important;
            color: var(--text-primary) !important;
            padding: 4px 8px !important;
            outline: none !important;
            margin: 0 4px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            color: var(--text-secondary) !important;
            border-radius: 6px !important;
            border: 1px solid var(--border-color) !important;
            padding: 4px 10px !important;
            margin: 0 2px !important;
            cursor: pointer !important;
            background: transparent !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: rgba(255, 255, 255, 0.05) !important;
            color: #fff !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: var(--accent-gradient) !important;
            color: #fff !important;
            border: 1px solid var(--accent) !important;
            box-shadow: 0 4px 12px var(--accent-glow) !important;
        }

        /* ============================================
           FORM CONTROL INPUT STYLING
           ============================================ */
        .premium-input {
            background: rgba(17, 24, 39, 0.6) !important;
            border: 1px solid var(--border-color) !important;
            color: #fff !important;
            border-radius: 8px !important;
            padding: 8px 12px !important;
            font-size: 13px !important;
            outline: none !important;
            transition: all 0.3s ease;
        }

        .premium-input:focus {
            border-color: var(--accent) !important;
            box-shadow: 0 0 0 2px var(--accent-glow) !important;
        }

        .premium-select {
            background: rgba(17, 24, 39, 0.8) !important;
            border: 1px solid var(--border-color) !important;
            color: #fff !important;
            border-radius: 8px !important;
            padding: 6px 12px !important;
            font-size: 13px !important;
            outline: none !important;
        }

        .premium-select option {
            background-color: #0c1220;
            color: #fff;
        }

        /* Scrollbars styling */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: var(--bg-primary);
        }
        ::-webkit-scrollbar-thumb {
            background: var(--border-color);
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--border-hover);
        }
    </style>
  </head>
  <body>
      
    <!-- ====== PREMIUM NAVIGATION ====== -->
    <nav class="nav-wrap" id="mainNav">
        <div class="nav-inner">
            <a href="/" class="nav-logo">
                <img src="{{ asset('logo/lawsghlog.png') }}" alt="LawsGhana">
            </a>

            <div class="nav-menu-links-premium">
                <!-- Constitution Dropdown -->
                <div class="nav-link-dropdown">
                    <button class="nav-link-btn">Constitution <i class="fa-solid fa-chevron-down"></i></button>
                    <div class="nav-dropdown-menu">
                        <a href="/constitution/Republic/Ghana/1">Ghana</a>
                        <a href="/constitution/all-countries/1/Africa">Africa</a>
                        <a href="/constitution/all-countries/2/Asia">Asia</a>
                        <a href="/constitution/all-countries/3/Europe">Europe</a>
                        <a href="/constitution/all-countries/4/North-America">North America</a>
                        <a href="/constitution/all-countries/5/South-America">South America</a>
                    </div>
                </div>

                <!-- Pre-4th Republic Laws Dropdown -->
                <div class="nav-link-dropdown">
                    <button class="nav-link-btn">Pre-4th Republic Laws <i class="fa-solid fa-chevron-down"></i></button>
                    <div class="nav-dropdown-menu">
                        <a href="/pre_1992_legislation/1/First Republic">1st Republic</a>
                        <a href="/pre_1992_legislation/2/Second Republic">2nd Republic</a>
                        <a href="/pre_1992_legislation/3/Third Republic">3rd Republic</a>
                        <a href="/pre_1992_legislation/5/NLC Decree">NLC Decree</a>
                        <a href="/pre_1992_legislation/6/NRC Decree">NRC Decree</a>
                        <a href="/pre_1992_legislation/7/SMC Decree">SMC Decree</a>
                        <a href="/pre_1992_legislation/8/AFRC Decree">AFRC Decree</a>
                        <a href="/pre_1992_legislation/4/PNDC Law">PNDC Law</a>
                    </div>
                </div>

                <!-- 4th Republic Laws Dropdown -->
                <div class="nav-link-dropdown">
                    <button class="nav-link-btn">4th Republic Laws <i class="fa-solid fa-chevron-down"></i></button>
                    <div class="nav-dropdown-menu">
                        <a href="/post-1992-legislation/1/Acts of Parliament">Acts of Parliament</a>
                        <a href="/post-1992-legislation/only-regulations">Legislative Instruments</a>
                        <a href="/post-1992-legislation/Constitutional-Intruments">Constitutional Instruments</a>
                        <a href="/post-1992-legislation/Executive-Intruments">Executive Instruments</a>
                        <a href="/post-1992-legislation/only-amendments">Amendments</a>
                    </div>
                </div>

                <a href="/judgement/Ghana" class="nav-link-btn" style="text-decoration:none !important;">Case Laws</a>
                <a href="/News/Ghana-News/1" class="nav-link-btn" style="text-decoration:none !important;">News</a>
            </div>

            <div class="nav-auth">
                @guest
                    <a href="{{ route('login') }}" class="btn-login">Log In</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-signup">Sign Up</a>
                    @endif
                @else
                    <div class="nav-user-dropdown" id="userDropdown">
                        <button class="nav-user-btn" onclick="document.getElementById('userDropdown').classList.toggle('active')">
                            <i class="fa-solid fa-circle-user"></i>
                            {{ Auth::user()->name }}
                            <i class="fa-solid fa-chevron-down" style="font-size: 10px; margin-left: 2px;"></i>
                        </button>
                        <div class="nav-dropdown-menu dropdown-menu-right" style="right: 0; left: auto;">
                            <a href="/home"><i class="fa-solid fa-house"></i> Dashboard</a>
                            <a href="/accounts/profile/{{ Auth::user()->id }}"><i class="fa-solid fa-user"></i> Profile</a>
                            <a href="/accounts/manage-password"><i class="fa-solid fa-gear"></i> Settings</a>
                            <div class="nav-dropdown-divider"></div>
                            <a href="/accounts/downloads/{{ Auth::user()->id }}"><i class="fa-solid fa-download"></i> Downloads</a>
                            <a href="/accounts/bookmarks/{{ Auth::user()->id }}"><i class="fa-solid fa-bookmark"></i> Bookmarks</a>
                            <a href="/subscription"><i class="fa-solid fa-credit-card"></i> Subscription</a>
                            <div class="nav-dropdown-divider"></div>
                            <a href="{{ route('logout') }}" class="logout-link"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa-solid fa-power-off"></i> Sign Out
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </nav>

    <!-- ====== MAIN PORTAL AREA ====== -->
    <div class="container-fluid px-md-5">
        <div class="row">
            
            <!-- Left Main Column -->
            <div class="col-md-9">
                <!-- Search bar input at the top -->
                <div class="d-flex mb-3">
                    <form action="{{ url('all_constitution_index_search') }}" method="GET" class="form-inline w-100">
                        {{ csrf_field() }}
                        <div class="position-relative w-100 d-flex" style="max-width: 450px;">
                            <i class="fa-solid fa-magnifying-glass position-absolute text-muted" style="left: 14px; top: 12px; font-size: 14px;"></i>
                            <input style="padding-left: 38px !important; width: 100%; height: 38px;" class="form-control premium-input" type="search" placeholder="Search any word in Constitution..." aria-label="Search" name="search_text">
                        </div>
                    </form>
                </div>

                <!-- Premium Continent Tabs Menu -->
                <div class="nav-underline-premium">
                    <a class="nav-link-premium active" href="/constitution/all_countries"><i class="fa-solid fa-globe mr-2"></i> All Countries</a>
                    <a class="nav-link-premium" href="/constitution/Republic/Ghana/1"><i class="fa-solid fa-book-open mr-2"></i> Ghana</a>
                    <a class="nav-link-premium" href="/constitution/all-countries/1/Africa"><i class="fa-solid fa-earth-africa mr-2"></i> Africa</a>
                    <a class="nav-link-premium" href="/constitution/all-countries/2/Asia"><i class="fa-solid fa-earth-asia mr-2"></i> Asia</a>
                    <a class="nav-link-premium" href="/constitution/all-countries/3/Europe"><i class="fa-solid fa-earth-europe mr-2"></i> Europe</a>
                    <a class="nav-link-premium" href="/constitution/all-countries/4/North-America"><i class="fa-solid fa-earth-americas mr-2"></i> North America</a>
                    <a class="nav-link-premium" href="/constitution/all-countries/5/South-America"><i class="fa-solid fa-earth-americas mr-2"></i> South America</a>
                </div>

                <!-- Premium Table Card -->
                <div class="premium-card">
                    <div class="table-responsive">
                        <table class="table table-hover" id="datatable" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Countries</th>
                                    <th>Constitution Title</th>
                                    <th>Year</th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach($allCountriesConstitutions as $allCountriesConstitution)
                                <tr>
                                    <td>{{ $allCountriesConstitution->country }}</td>
                                    <td>
                                        <a href="/constitution/1/{{ $allCountriesConstitution->continent }}/{{ $allCountriesConstitution->country }}/{{ $allCountriesConstitution->id}}">{{ $allCountriesConstitution->title }}</a>
                                    </td> 
                                    <td>{{ $allCountriesConstitution->year }}</td>  
                                </tr>
                              @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar Column -->
            <div class="col-md-3">
                
                <!-- Premium Sidebar filter card -->
                <div class="premium-sidebar-card">
                    <h5 class="text-white mb-3" style="font-size: 14px; font-weight: 700; border-bottom: 1px solid var(--border-color); padding-bottom: 10px;">
                        <i class="fa-solid fa-filter text-warning mr-1"></i> Interactive Filter
                    </h5>
                    
                    <div class="form-group mb-3">
                        <label class="text-muted mb-1" style="font-size: 11px; font-weight: 600;">Select Country</label>
                        <select class="form-control premium-select all_judgment_filter_category w-100" style="height: 36px;">
                            <option selected value="">Select Country</option>
                        </select>
                    </div>
                    
                    <div class="form-group mb-0">
                        <label class="text-muted mb-1" style="font-size: 11px; font-weight: 600;">Keyword Search</label>
                        <form action="{{ url('all_constitution_index_search') }}" method="GET">
                            {{ csrf_field() }}
                            <div class="position-relative d-flex">
                                <input style="height: 36px; padding-right: 32px;" class="form-control premium-input w-100" name="search_text" type="text" placeholder="Search word in Constitution..." aria-label="Search">
                                <button type="submit" class="position-absolute border-0 bg-transparent text-muted" style="right: 10px; top: 8px; cursor: pointer;">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Advertisement Card -->
                <div class="premium-sidebar-card p-2" style="background: transparent !important; border: none !important; box-shadow: none !important;">
                    @include('ads.small_ads_image_main_page')
                </div>

                <div class="premium-sidebar-card p-2" style="background: transparent !important; border: none !important; box-shadow: none !important; margin-top: 15px;">
                    @include('ads.adsense_vertical')
                </div>
            </div>

        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/slim.js') }}"></script>
    <script>window.jQuery || document.write('<script src="/docs/4.5/assets/js/vendor/jquery.slim.min.js"><\/script>')</script>
    <script src="{{ asset('js/bootstrap_update.min.js') }}"></script>
    <script src="{{ asset('js/offcanvas.js') }}"></script>
    
    <!-- DataTables JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    
    <script>
        $(document).ready(function(){
            // Initialize DataTables with premium styling features
            const table = $('#datatable').DataTable({
                "pageLength": 10,
                "ordering": true,
                "responsive": true
            });

            // Extract unique country options from table column 0 and populate dropdown filter
            const countries = [];
            $('#datatable tbody tr').each(function(){
                const country = $(this).find('td:first-child').text().trim();
                if (country && !countries.includes(country)) {
                    countries.push(country);
                }
            });
            countries.sort();

            const selectEl = $('.all_judgment_filter_category');
            countries.forEach(function(c){
                selectEl.append(`<option value="${c}">${c}</option>`);
            });

            // Bind filter change action
            selectEl.on('change', function(){
                const val = $(this).val();
                if (val) {
                    // Precise search matching
                    table.column(0).search('^' + $.fn.dataTable.util.escapeRegex(val) + '$', true, false).draw();
                } else {
                    table.column(0).search('').draw();
                }
            });

            // Close user dropdown on click outside
            document.addEventListener('click', (e) => {
                const dropdown = document.getElementById('userDropdown');
                if (dropdown && !dropdown.contains(e.target)) {
                    dropdown.classList.remove('active');
                }
            });
        });
    </script>
  </body>
</html>
