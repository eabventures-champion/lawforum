<style>
    /* Premium Sidebar Cards */
    .premium-filter-card {
       background: rgba(30, 41, 59, 0.45);
       backdrop-filter: blur(16px);
       -webkit-backdrop-filter: blur(16px);
       border: 1px solid var(--border-color);
       border-radius: 12px;
       padding: 20px;
       margin-bottom: 20px;
       box-shadow: 0 4px 30px rgba(0, 0, 0, 0.2);
       transition: border-color 0.3s ease;
       position: relative !important;
       z-index: 100 !important;
       overflow: visible !important;
   }
   
   .premium-filter-card:hover {
       border-color: rgba(255, 255, 255, 0.12);
   }
   
   .filter-header-title {
       font-size: 11px;
       font-weight: 700;
       letter-spacing: 1.5px;
       text-transform: uppercase;
       color: var(--text-secondary);
       margin-bottom: 16px;
       display: flex;
       align-items: center;
       gap: 8px;
   }
   
   .filter-header-title i {
       color: var(--gold);
       font-size: 12px;
   }
   
   /* View Options Button Dropdown */
   .dropdown-btn-premium {
       width: 100%;
       background: rgba(255, 255, 255, 0.02) !important;
       border: 1px solid var(--border-color) !important;
       color: var(--text-primary) !important;
       padding: 10px 16px !important;
       border-radius: 8px !important;
       font-size: 13px !important;
       font-weight: 600 !important;
       display: flex !important;
       align-items: center !important;
       justify-content: space-between !important;
       transition: all 0.2s ease !important;
       text-decoration: none !important;
   }
   
   .dropdown-btn-premium:hover, .dropdown-btn-premium:focus {
       background: rgba(255, 255, 255, 0.06) !important;
       border-color: rgba(255, 255, 255, 0.15) !important;
       color: #fff !important;
   }
   
   .dropdown-menu-premium {
       width: 100%;
       background: #0f172a !important;
       border: 1px solid var(--border-color) !important;
       border-radius: 8px !important;
       box-shadow: 0 10px 35px rgba(0, 0, 0, 0.85) !important;
       padding: 6px !important;
       z-index: 999999 !important;
   }
   
   .dropdown-item-premium {
       color: var(--text-secondary) !important;
       font-size: 13px !important;
       font-weight: 500 !important;
       padding: 8px 12px !important;
       border-radius: 6px !important;
       transition: all 0.2s ease !important;
       text-align: left !important;
       display: flex !important;
       align-items: center;
       gap: 8px;
   }
   
   .dropdown-item-premium:hover {
       background: rgba(255, 255, 255, 0.05) !important;
       color: #fff !important;
   }
   
   .dropdown-item-premium i {
       font-size: 12px;
       width: 14px;
       text-align: center;
   }
   
   /* Ad Banner Slot Premium */
    .premium-ad-card {
        border-radius: 12px;
        overflow: hidden;
        border: none !important;
        background: transparent !important;
        box-shadow: none !important;
        position: relative !important;
        z-index: 1 !important;
    }
     
     .premium-ad-card:hover {
         transform: translateY(-2px);
     }
</style>



<div class="premium-ad-card">
    @include('ads.small_ads_image_main_page')
</div>

@include('layouts.plain_create_account')