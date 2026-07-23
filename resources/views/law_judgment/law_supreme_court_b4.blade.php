<!doctype html>
<html lang="en" style="background-color:#070a13;">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Browse and search Ghana Supreme Court case laws and judgements on Legals Forum.">
    <title>Supreme Court - Legals Forum</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('logo/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('logo/favicon/favicon-16x16.png') }}">
    <style>
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
        body { font-family: var(--font); background-color: var(--bg-primary); color: var(--text-primary); min-height: 100vh; padding-top: 90px; padding-bottom: 40px; }
        .nav-wrap { position: fixed; top: 0; left: 0; width: 100%; height: 70px; z-index: 1000; background: rgba(6, 10, 19, 0.88); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border-bottom: 1px solid var(--border-color); }
        .nav-inner { max-width: 1440px; margin: 0 auto; padding: 16px 24px; display: flex; align-items: center; justify-content: space-between; }
        .nav-menu-links-premium { display: flex; align-items: center; gap: 4px; }
        .nav-link-dropdown { position: relative; }
        .nav-link-btn { font-size: 14px; font-weight: 500; color: var(--text-secondary); padding: 8px 14px; border-radius: 8px; background: transparent; border: none; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; gap: 6px; }
        .nav-link-btn:hover { color: var(--text-primary); background: rgba(255, 255, 255, 0.05); }
        .nav-link-btn i { font-size: 10px; color: var(--text-muted); }
        .nav-dropdown-menu { position: absolute; top: calc(100% + 8px); left: 0; min-width: 220px; background: rgba(17, 24, 39, 0.95); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border: 1px solid var(--border-color); border-radius: 12px; padding: 8px; opacity: 0; visibility: hidden; transform: translateY(-10px); transition: all 0.3s ease; z-index: 100; box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5); }
        .nav-link-dropdown:hover .nav-dropdown-menu { opacity: 1; visibility: visible; transform: translateY(0); }
        .nav-dropdown-menu a { display: flex; align-items: center; gap: 10px; padding: 10px 14px; border-radius: 8px; font-size: 14px; color: var(--text-secondary); transition: all 0.2s ease; text-decoration: none !important; }
        .nav-dropdown-menu a:hover { color: var(--text-primary); background: rgba(255, 255, 255, 0.06); }
        .nav-dropdown-divider { height: 1px; background: var(--border-color); margin: 6px 0; }
        .nav-auth { display: flex; align-items: center; gap: 12px; }
        .btn-login { font-size: 13px; font-weight: 600; color: var(--text-primary); padding: 8px 18px; border-radius: 8px; border: 1px solid var(--border-hover); background: transparent; cursor: pointer; transition: all 0.3s ease; text-decoration: none !important; }
        .btn-login:hover { background: rgba(255, 255, 255, 0.06); border-color: rgba(255, 255, 255, 0.2); color: var(--text-primary); }
        .btn-signup { font-size: 13px; font-weight: 600; color: #fff; padding: 8px 18px; border-radius: 8px; border: none; background: var(--accent-gradient); cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 12px var(--accent-glow); text-decoration: none !important; }
        .btn-signup:hover { transform: translateY(-1px); box-shadow: 0 6px 18px var(--accent-glow); color: #fff; }
        .nav-user-dropdown { position: relative; }
        .nav-user-btn { display: flex; align-items: center; gap: 8px; padding: 8px 14px; border-radius: 8px; border: 1px solid var(--border-color); background: var(--card-bg); color: var(--text-primary); font-size: 14px; font-weight: 500; cursor: pointer; transition: all 0.3s ease; }
        .nav-user-btn:hover { background: var(--card-bg-hover); border-color: var(--border-hover); }
        .nav-user-dropdown.active .nav-dropdown-menu { opacity: 1; visibility: visible; transform: translateY(0); }
        .nav-dropdown-menu a.logout-link { color: #f43f5e; }
        .nav-dropdown-menu a.logout-link:hover { background: rgba(244, 63, 94, 0.1); }
        .premium-card { background: var(--bg-secondary) !important; border: 1px solid var(--border-color) !important; border-radius: 16px !important; padding: 24px !important; box-shadow: 0 10px 30px rgba(0,0,0,0.5) !important; margin-bottom: 24px; }
        .premium-sidebar-card { background: var(--bg-secondary) !important; border: 1px solid var(--border-color) !important; border-radius: 16px !important; padding: 20px !important; box-shadow: 0 8px 24px rgba(0,0,0,0.5) !important; margin-bottom: 24px; }
        .nav-underline-premium { display: flex; gap: 6px; overflow-x: auto; padding: 8px; background: rgba(148, 163, 184, 0.08) !important; backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 1px solid rgba(148, 163, 184, 0.25) !important; border-radius: 12px; margin-bottom: 24px; flex-wrap: nowrap !important; position: sticky; top: 62px; z-index: 99; }
        .nav-link-premium { font-size: 13px !important; font-weight: 600 !important; color: var(--text-secondary) !important; background: transparent !important; border: 1px solid transparent !important; padding: 8px 16px !important; border-radius: 8px !important; transition: all 0.2s ease !important; white-space: nowrap !important; text-decoration: none !important; display: inline-flex !important; align-items: center; }
        .nav-link-premium:hover { color: var(--text-primary) !important; background: rgba(255, 255, 255, 0.05) !important; border-color: var(--border-color) !important; }
        .nav-link-premium.active { color: #fff !important; background: var(--accent-gradient) !important; border-color: var(--accent) !important; box-shadow: 0 4px 12px var(--accent-glow) !important; }
        .table-loading-overlay { position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(6,10,19,0.7); display: flex; align-items: center; justify-content: center; z-index: 10; border-radius: 16px; backdrop-filter: blur(4px); opacity: 0; visibility: hidden; transition: all 0.2s ease; }
        .table-loading-overlay.show { opacity: 1; visibility: visible; }
        .spinner-dot { width: 10px; height: 10px; border-radius: 50%; margin: 0 4px; animation: dotPulse 1.2s ease-in-out infinite; }
        .spinner-dot:nth-child(1) { background: var(--accent); animation-delay: 0s; }
        .spinner-dot:nth-child(2) { background: #8b5cf6; animation-delay: 0.15s; }
        .spinner-dot:nth-child(3) { background: var(--accent-light); animation-delay: 0.3s; }
        @keyframes dotPulse { 0%, 80%, 100% { transform: scale(0.6); opacity: 0.4; } 40% { transform: scale(1); opacity: 1; } }
        #datatable { background-color: #0c1220 !important; color: var(--text-secondary) !important; border-collapse: collapse !important; }
        #datatable th { background-color: #0c1220 !important; border-bottom: 2px solid var(--border-color) !important; color: var(--text-primary) !important; font-weight: 700 !important; font-size: 12px !important; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px !important; }
        #datatable td { background-color: #0c1220 !important; border-bottom: 1px solid var(--border-color) !important; color: rgba(255, 255, 255, 0.8) !important; font-size: 14px !important; padding: 14px 16px !important; }
        #datatable tbody tr:hover, #datatable tbody tr:hover td, table.dataTable.hover tbody tr:hover, table.dataTable.display tbody tr:hover, .table-hover tbody tr:hover, .table-hover tbody tr:hover td { background-color: rgba(255, 255, 255, 0.05) !important; background: rgba(255, 255, 255, 0.05) !important; color: #fff !important; }
        #datatable td a { color: var(--accent-light) !important; font-weight: 600 !important; text-decoration: none !important; }
        #datatable td a:hover { color: var(--gold) !important; text-decoration: underline !important; }
        .dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter, .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_paginate { color: var(--text-secondary) !important; font-size: 13px !important; margin-bottom: 15px; }
        .dataTables_wrapper .dataTables_filter input { background: rgba(17, 24, 39, 0.7) !important; border: 1px solid var(--border-color) !important; border-radius: 8px !important; color: var(--text-primary) !important; padding: 6px 12px !important; font-size: 13px !important; outline: none !important; margin-left: 8px; }
        .dataTables_wrapper .dataTables_length select { background: rgba(17, 24, 39, 0.7) !important; border: 1px solid var(--border-color) !important; border-radius: 8px !important; color: var(--text-primary) !important; padding: 4px 8px !important; outline: none !important; margin: 0 4px; }
        .dataTables_wrapper .dataTables_paginate .paginate_button { color: var(--text-secondary) !important; border-radius: 6px !important; border: 1px solid var(--border-color) !important; padding: 4px 10px !important; margin: 0 2px !important; cursor: pointer !important; background: transparent !important; }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover { background: rgba(255, 255, 255, 0.05) !important; color: #fff !important; }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover { background: var(--accent-gradient) !important; color: #fff !important; border: 1px solid var(--accent) !important; box-shadow: 0 4px 12px var(--accent-glow) !important; }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: var(--bg-primary); }
        ::-webkit-scrollbar-thumb { background: var(--border-color); border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--border-hover); }
        .mobile-menu-btn { display: none; background: transparent; border: 1px solid var(--border-color); border-radius: 8px; padding: 8px 12px; color: var(--text-primary); cursor: pointer; font-size: 18px; }
        @media (max-width: 991px) { .nav-menu-links-premium { display: none; } .mobile-menu-btn { display: block; } .nav-menu-links-premium.show { display: flex; flex-direction: column; position: absolute; top: 70px; left: 0; right: 0; background: rgba(6, 10, 19, 0.95); backdrop-filter: blur(20px); padding: 16px; border-bottom: 1px solid var(--border-color); gap: 4px; } }
    </style>
  </head>
  <body>
    <nav class="nav-wrap" id="mainNav">
        <div class="nav-inner">
            <a href="/" style="display: inline-flex; align-items: center; gap: 10px; text-decoration: none; padding-left: 0px; padding-top: 5px; padding-bottom: 5px; transition: transform 0.2s ease;" onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
                <i class="fa fa-balance-scale fa-lg" style="color: #3b82f6; font-size: 22px; margin: 0; line-height: 1;"></i>
                <span style="font-size: 22px; font-weight: 800; letter-spacing: 0.5px; background: linear-gradient(to right, #3b82f6, #60a5fa); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-family: 'Inter', sans-serif; margin: 0; line-height: 1.3;">Legals Forum</span>
            </a>
            <button class="mobile-menu-btn" onclick="document.querySelector('.nav-menu-links-premium').classList.toggle('show')"><i class="fa-solid fa-bars"></i></button>
            <div class="nav-menu-links-premium">
                @foreach($headerMenus as $menu)
                    @if($menu->is_dropdown)
                        <div class="nav-link-dropdown">
                            <button class="nav-link-btn">{{ $menu->title }} <i class="fa-solid fa-chevron-down" style="font-size: 10px;"></i></button>
                            <div class="nav-dropdown-menu">
                                @foreach($menu->children as $child)
                                    <a href="{{ $child->custom_content ? route('dynamic.page', $child->slug) : $child->url }}">{{ $child->title }}</a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <a href="{{ $menu->custom_content ? route('dynamic.page', $menu->slug) : $menu->url }}" class="nav-link-btn" style="text-decoration:none !important;">{{ $menu->title }}</a>
                    @endif
                @endforeach
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
                            <i class="fa-solid fa-circle-user"></i> {{ Auth::user()->name }} <i class="fa-solid fa-chevron-down" style="font-size: 10px; margin-left: 2px;"></i>
                        </button>
                        <div class="nav-dropdown-menu" style="right: 0; left: auto;">
                            <a href="/home"><i class="fa-solid fa-house"></i> Dashboard</a>
                            <a href="/accounts/profile/{{ Auth::user()->id }}"><i class="fa-solid fa-user"></i> Profile</a>
                            <a href="/accounts/manage-password"><i class="fa-solid fa-gear"></i> Settings</a>
                            <div class="nav-dropdown-divider"></div>
                            <a href="/accounts/downloads/{{ Auth::user()->id }}"><i class="fa-solid fa-download"></i> Downloads</a>
                            <a href="/accounts/bookmarks/{{ Auth::user()->id }}"><i class="fa-solid fa-bookmark"></i> Bookmarks</a>
                            <a href="/subscription"><i class="fa-solid fa-credit-card"></i> Subscription</a>
                            <div class="nav-dropdown-divider"></div>
                            <a href="{{ route('logout') }}" class="logout-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa-solid fa-power-off"></i> Sign Out</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </nav>
    <div class="container-fluid px-md-5 mt-4">
        <div class="mb-4">
            <h1 class="page-title" style="font-size: 2.2rem; font-weight: 800; font-family: 'Outfit', sans-serif; letter-spacing: -0.5px; background: linear-gradient(135deg, #fff 0%, #94a3b8 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Supreme Court</h1>
            <p class="page-subtitle" style="font-size: 15px; color: var(--text-secondary); line-height: 1.6;">Browse and search Ghana Supreme Court case laws and judgements.</p>
        </div>
        <div class="row">
            <div class="col-md-9">
                <div class="nav-underline-premium">
                    <a class="nav-link-premium" href="/judgement/Ghana"><i class="fa-solid fa-gavel mr-2"></i> Case Laws</a>
                    <a class="nav-link-premium active" href="/judgement/1/Supreme-Court"><i class="fa-solid fa-landmark mr-2"></i> Supreme Court</a>
                    <a class="nav-link-premium" href="/judgement/3/Court-of-Appeal"><i class="fa-solid fa-scale-balanced mr-2"></i> Court of Appeal</a>
                    <a class="nav-link-premium" href="/judgement/2/High-Court"><i class="fa-solid fa-building-columns mr-2"></i> High Court</a>
                </div>
                <div class="premium-card" style="position: relative;">
                    <div class="table-loading-overlay" id="tableLoader"><div style="display: flex; align-items: center;"><div class="spinner-dot"></div><div class="spinner-dot"></div><div class="spinner-dot"></div></div></div>
                    <div class="table-responsive">
                        <table class="table table-hover" id="datatable" style="width: 100%;">
                            <thead><tr><th>Supreme Court</th><th>Ref No.</th><th>Year</th></tr></thead>
                            <tbody>
                              @foreach($supremeCourts as $supremeCourt)
                                <tr>
                                    <td><a href="/judgement/Ghana/{{ $supremeCourt->gh_law_judgment_group_name }}/{{ $supremeCourt->id}}">{{ $supremeCourt->case_title }}</a></td>
                                    <td>{{ $supremeCourt->reference_number }}</td>
                                    <td>{{ $supremeCourt->year }}</td>
                                </tr>
                              @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="premium-sidebar-card p-2" style="background: transparent !important; border: none !important; box-shadow: none !important;">@include('ads.small_ads_image_main_page')</div>
                <div class="premium-sidebar-card p-2" style="background: transparent !important; border: none !important; box-shadow: none !important; margin-top: 15px;">@include('ads.adsense_vertical')</div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script src="{{ asset('js/offcanvas.js') }}"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function(){
            $('#datatable').DataTable({ "pageLength": 5, "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]], "ordering": true, "responsive": true, "order": [[2, "desc"]] });
            document.addEventListener('click', (e) => { const d = document.getElementById('userDropdown'); if (d && !d.contains(e.target)) d.classList.remove('active'); });
            document.addEventListener('click', (e) => { const m = document.querySelector('.nav-menu-links-premium'); const b = document.querySelector('.mobile-menu-btn'); if (m && b && !m.contains(e.target) && !b.contains(e.target)) m.classList.remove('show'); });
        });
    </script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-174662621-1"></script>
    <script>window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'UA-174662621-1');</script>
    <script type="text/javascript">var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date(); (function(){ var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0]; s1.async=true; s1.src='https://embed.tawk.to/5e398d16298c395d1ce62ab4/default'; s1.charset='UTF-8'; s1.setAttribute('crossorigin','*'); s0.parentNode.insertBefore(s1,s0); })();</script>
  </body>
</html>