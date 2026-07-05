<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Africa Constitutions - LawsGhana</title>

    <!-- Google Fonts & Stylesheets -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <style>
        :root {
            --bg-primary: #070a13;
            --bg-secondary: #0f172a;
            --card-bg: rgba(17, 24, 39, 0.55);
            --border-color: rgba(255, 255, 255, 0.08);
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --accent: #2563eb;
            --accent-light: #60a5fa;
            --accent-glow: rgba(37, 99, 235, 0.15);
            --accent-gradient: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            --gold: #f59e0b;
            --gold-light: #fbbf24;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: radial-gradient(circle at 50% 0%, var(--bg-secondary) 0%, var(--bg-primary) 100%);
            color: var(--text-primary);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ====== PREMIUM NAVIGATION ====== */
        .nav-wrap {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: rgba(7, 10, 19, 0.75);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .nav-inner {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 24px;
        }

        .nav-logo img {
            height: 38px;
            width: auto;
            transition: transform 0.3s ease;
        }

        .nav-logo:hover img {
            transform: scale(1.03);
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
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .nav-link-btn:hover {
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.05);
        }

        .nav-link-dropdown:hover .nav-dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .nav-dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            min-width: 220px;
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 8px;
            margin-top: 8px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.4);
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            z-index: 100;
        }

        .nav-dropdown-menu a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            font-size: 13.5px;
            color: var(--text-secondary);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.15s ease;
        }

        .nav-dropdown-menu a:hover {
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.06);
        }

        .nav-auth {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-login {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--text-primary);
            text-decoration: none !important;
            padding: 8px 16px;
            transition: color 0.2s;
        }

        .btn-login:hover {
            color: var(--accent-light);
        }

        .btn-signup {
            font-size: 13.5px;
            font-weight: 600;
            color: #fff !important;
            background: var(--accent-gradient);
            padding: 8px 18px;
            border-radius: 8px;
            text-decoration: none !important;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
            transition: all 0.2s ease;
        }

        .btn-signup:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.35);
        }

        .nav-user-dropdown {
            position: relative;
        }

        .nav-user-btn {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            border-radius: 20px;
            padding: 6px 14px;
            font-size: 13.5px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
        }

        .nav-user-dropdown.active .nav-dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .nav-dropdown-divider {
            height: 1px;
            background: var(--border-color);
            margin: 6px 0;
        }

        /* Continent / Sub-navigation header */
        .continent-nav-wrap {
            background: rgba(15, 23, 42, 0.4);
            border-bottom: 1px solid var(--border-color);
            padding: 8px 0;
        }

        .continent-nav-wrap .nav-underline {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            gap: 8px;
            overflow-x: auto;
        }

        .continent-nav-wrap .nav-underline::-webkit-scrollbar {
            display: none;
        }

        .continent-nav-wrap .nav-link {
            font-size: 13.5px;
            font-weight: 500;
            color: var(--text-secondary) !important;
            padding: 6px 16px;
            border-radius: 20px;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .continent-nav-wrap .nav-link:hover {
            color: var(--text-primary) !important;
            background: rgba(255, 255, 255, 0.03);
        }

        .continent-nav-wrap .nav-link.active {
            color: #fff !important;
            background: rgba(59, 130, 246, 0.15) !important;
            border: 1px solid rgba(59, 130, 246, 0.3) !important;
        }

        /* ====== MAIN CONTENT & LAYOUT ====== */
        .main-container {
            max-width: 1400px;
            margin: 40px auto 80px;
            padding: 0 24px;
        }

        .dashboard-hero {
            margin-bottom: 30px;
        }

        .dashboard-hero h1 {
            font-size: 32px;
            font-weight: 800;
            letter-spacing: -0.75px;
            margin-bottom: 8px;
            background: linear-gradient(135deg, #ffffff 0%, #94a3b8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .dashboard-hero p {
            color: var(--text-secondary);
            font-size: 15px;
        }

        .premium-card {
            background: var(--card-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.2);
        }

        .card-header-styled {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 16px;
            margin-bottom: 20px;
        }

        .card-header-styled h5 {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* ====== SEARCH BAR UTILITY ====== */
        .search-bar-wrap {
            margin-bottom: 24px;
        }

        .search-input-premium {
            background: rgba(17, 24, 39, 0.6);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            color: var(--text-primary);
            padding: 12px 16px 12px 42px;
            font-size: 14px;
            outline: none;
            width: 100%;
            transition: all 0.3s ease;
        }

        .search-input-premium:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 2px var(--accent-glow);
        }

        .search-bar-wrap i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 15px;
        }

        /* ====== INPUT & SELECT FIELDS ====== */
        .input-premium {
            background: rgba(17, 24, 39, 0.6) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 10px !important;
            color: var(--text-primary) !important;
            padding: 10px 14px !important;
            font-size: 13.5px !important;
            outline: none !important;
            width: 100% !important;
            height: auto !important;
            transition: all 0.2s ease !important;
        }

        .input-premium:focus {
            border-color: var(--accent) !important;
            box-shadow: 0 0 0 2px var(--accent-glow) !important;
        }

        .btn-accent {
            background: var(--accent-gradient) !important;
            color: #fff !important;
            font-weight: 600 !important;
            border: none !important;
            padding: 10px 16px !important;
            border-radius: 10px !important;
            transition: all 0.2s ease !important;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15) !important;
        }

        .btn-accent:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.3) !important;
        }

        /* ====== DATATABLES PREMIUM OVERRIDES ====== */
        .dataTables_wrapper {
            padding: 0;
            color: var(--text-secondary) !important;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            color: var(--text-secondary) !important;
            margin-bottom: 16px;
            font-size: 13px;
        }

        .dataTables_wrapper .dataTables_filter input {
            background: rgba(17, 24, 39, 0.6) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 8px !important;
            color: var(--text-primary) !important;
            padding: 6px 12px !important;
            outline: none !important;
            margin-left: 8px !important;
            transition: all 0.3s ease;
        }

        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: var(--accent) !important;
            box-shadow: 0 0 0 2px var(--accent-glow) !important;
        }

        .dataTables_wrapper .dataTables_length select {
            background: rgba(17, 24, 39, 0.6) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 6px !important;
            color: var(--text-primary) !important;
            padding: 4px 8px !important;
            outline: none !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            color: var(--text-secondary) !important;
            border-radius: 6px !important;
            border: 1px solid var(--border-color) !important;
            padding: 4px 10px !important;
            background: transparent !important;
            transition: all 0.2s ease;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: rgba(255, 255, 255, 0.05) !important;
            color: var(--text-primary) !important;
            border-color: rgba(255, 255, 255, 0.2) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: var(--accent-gradient) !important;
            color: #fff !important;
            border: none !important;
        }

        .table-premium {
            background: transparent !important;
            border-collapse: separate !important;
            border-spacing: 0 8px !important;
            width: 100% !important;
            margin-top: 10px !important;
        }

        .table-premium th {
            background: rgba(255, 255, 255, 0.02) !important;
            border: none !important;
            color: var(--gold) !important;
            font-size: 13px !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
            padding: 12px 16px !important;
            font-weight: 700 !important;
        }

        .table-premium tr {
            background: rgba(255, 255, 255, 0.01) !important;
            transition: all 0.2s ease;
        }

        .table-premium tr:hover {
            background: rgba(255, 255, 255, 0.03) !important;
        }

        .table-premium td {
            border-top: 1px solid var(--border-color) !important;
            border-bottom: 1px solid var(--border-color) !important;
            padding: 14px 16px !important;
            color: var(--text-primary) !important;
            font-size: 14px !important;
        }

        .table-premium td:first-child {
            border-left: 1px solid var(--border-color) !important;
            border-top-left-radius: 8px !important;
            border-bottom-left-radius: 8px !important;
        }

        .table-premium td:last-child {
            border-right: 1px solid var(--border-color) !important;
            border-top-right-radius: 8px !important;
            border-bottom-right-radius: 8px !important;
        }

        .table-premium a {
            color: var(--accent-light) !important;
            text-decoration: none !important;
            font-weight: 600 !important;
            transition: color 0.2s ease;
        }

        .table-premium a:hover {
            color: var(--accent) !important;
            text-decoration: underline !important;
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

    <!-- Continent/Sub-Navigation header -->
    <div class="continent-nav-wrap">
        <div class="nav-scroller">
            <nav class="nav nav-underline">
                <a class="nav-link" href="/constitution/all_countries">All Countries</a>
                <a class="nav-link" href="/constitution/Republic/Ghana/1">Ghana</a>
                <a class="nav-link active" href="/constitution/all-countries/1/Africa">Africa</a>
                <a class="nav-link" href="/constitution/all-countries/2/Asia">Asia</a>
                <a class="nav-link" href="/constitution/all-countries/3/Europe">Europe</a>
                <a class="nav-link" href="/constitution/all-countries/4/North-America">North America</a>
                <a class="nav-link" href="/constitution/all-countries/5/South-America">South America</a>
            </nav>
        </div>
    </div>

    <!-- ====== MAIN CONTAINER ====== -->
    <div class="main-container">
        <div class="dashboard-hero">
            <h1>African Constitutions</h1>
            <p>Browse, filter, and search constitution indexes and documents across Africa.</p>
        </div>

        <div class="row align-items-start">
            <!-- Main Content: Constitutions Database -->
            <div class="col-lg-9">
                <!-- Search bar across all laws -->
                <div class="search-bar-wrap position-relative">
                    <form action="{{ url('all_constitution_index_search') }}" method="GET">
                        {{ csrf_field() }}
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input class="search-input-premium" type="search" placeholder="Search keyword in all laws database..." name="search_text">
                    </form>
                </div>

                <div class="premium-card">
                    <div class="card-header-styled">
                        <h5><i class="fa-solid fa-globe text-primary"></i> Constitutions List</h5>
                    </div>

                    <table class="table-premium table" id="datatable">
                        <thead>
                            <tr>
                                <th>Name of Country</th>
                                <th>Constitution Title</th>
                                <th>Year</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($africaConstitutions as $africaConstitution)
                                <tr>
                                    <td>{{ $africaConstitution->country }}</td>
                                    <td>
                                        <a href="/constitution/1/{{ $africaConstitution->continent }}/{{ $africaConstitution->country }}/{{ $africaConstitution->id}}">
                                            {{ $africaConstitution->title }}
                                        </a>
                                    </td> 
                                    <td>{{ $africaConstitution->year }}</td>  
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Right Sidebar: Filters & Advertisements -->
            <div class="col-lg-3">
                <div class="premium-card">
                    <div class="card-header-styled">
                        <h5><i class="fa-solid fa-filter text-primary"></i> Search & Filter</h5>
                    </div>

                    <!-- Year select filter -->
                    <label class="small text-muted font-weight-bold mb-1">By Year:</label>
                    <select class="form-control africa_constitution_filter_year input-premium mb-2">
                        <option value="">Select Year</option>
                        @foreach($africaConstitutions->pluck('year')->unique()->sortDesc() as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>

                    <!-- Country select filter -->
                    <label class="small text-muted font-weight-bold mb-1">By Country:</label>
                    <select class="form-control africa_constitution_filter_country input-premium mb-3">
                        <option value="">Select Country</option>
                        @foreach($africaConstitutions->pluck('country')->unique()->sort() as $country)
                            <option value="{{ $country }}">{{ $country }}</option>
                        @endforeach
                    </select>

                    <button type="button" class="btn btn-accent w-100 mb-4" id="africa_constitution_filter">
                        <i class="fa-solid fa-filter mr-1"></i> Apply Filter
                    </button>

                    <div class="nav-dropdown-divider mb-3"></div>

                    <!-- Search word in articles -->
                    <form action="{{ url('africa_constitution_index_search') }}" method="GET">
                        {{ csrf_field() }}
                        <label class="small text-muted font-weight-bold mb-1">Search Word in Article:</label>
                        <input class="form-control input-premium" name="search_text" type="text" placeholder="Type keyword...">
                    </form>
                </div>

                <!-- Advertisement Modules -->
                @include('ads.small_ads_image_main_page')
                
                <div class="mt-4">
                    @include('ads.adsense_vertical')
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script src="{{ asset('js/offcanvas.js') }}"></script>
    <script src="{{ asset('js/myscript.js') }}"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>

    <script>
        $(document).ready(function(){
            $('#datatable').DataTable({
                "pageLength": 10,
                "ordering": true,
                "responsive": true
            });
        });

        // Close user dropdown on click outside
        document.addEventListener('click', (e) => {
            const dropdown = document.getElementById('userDropdown');
            if (dropdown && !dropdown.contains(e.target)) {
                dropdown.classList.remove('active');
            }
        });
    </script>
  </body>
</html>
