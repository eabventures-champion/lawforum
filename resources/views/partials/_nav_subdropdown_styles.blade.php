{{-- Sub-dropdown CSS styles for nested menu items --}}
@include('partials._nav_master_styles')
<style>
    /* Sub-dropdown within a dropdown menu */
    .nav-sub-dropdown {
        position: relative;
    }

    .nav-sub-dropdown-trigger {
        display: flex !important;
        align-items: center;
        gap: 10px;
        padding: 10px 14px;
        border-radius: 8px;
        font-size: 14px;
        color: var(--text-secondary);
        transition: all 0.2s ease;
        text-align: left;
        text-decoration: none !important;
        cursor: pointer;
    }

    .nav-sub-dropdown-trigger:hover {
        color: var(--text-primary);
        background: rgba(255, 255, 255, 0.06);
    }

    .nav-sub-dropdown-menu {
        position: absolute;
        top: 0;
        left: calc(100% + 4px);
        min-width: 200px;
        background: rgba(17, 24, 39, 0.97);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 8px;
        opacity: 0;
        visibility: hidden;
        transform: translateX(-8px);
        transition: all 0.25s ease;
        z-index: 110;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
    }

    .nav-sub-dropdown:hover .nav-sub-dropdown-menu {
        opacity: 1;
        visibility: visible;
        transform: translateX(0);
    }

    .nav-sub-dropdown-menu a {
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

    .nav-sub-dropdown-menu a:hover {
        color: var(--text-primary);
        background: rgba(255, 255, 255, 0.06);
    }
</style>
