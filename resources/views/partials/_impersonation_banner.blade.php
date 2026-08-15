@if(session()->has('impersonated_by'))
<div class="impersonation-top-banner">
    <div class="impersonation-content">
        <div class="impersonation-icon-box">
            <i class="fa-solid fa-user-secret"></i>
        </div>
        <div class="impersonation-text">
            <span>Admin Impersonation Mode: Currently viewing as <strong>{{ auth()->user()->name }} {{ auth()->user()->lname }}</strong> ({{ auth()->user()->email }})</span>
        </div>
    </div>
    <form action="{{ route('impersonate.leave') }}" method="POST" class="impersonation-form">
        @csrf
        <button type="submit" class="btn-leave-impersonate">
            <i class="fa-solid fa-arrow-right-from-bracket"></i>
            <span>Exit to Admin Panel</span>
        </button>
    </form>
</div>

<style>
.impersonation-top-banner {
    position: sticky;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 2147483645;
    background: linear-gradient(90deg, #7c3aed 0%, #4f46e5 50%, #2563eb 100%);
    color: #fff;
    padding: 8px 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
    box-sizing: border-box;
    gap: 12px;
    font-family: inherit;
}

.impersonation-content {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13px;
    font-weight: 500;
}

.impersonation-icon-box {
    width: 26px;
    height: 26px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    flex-shrink: 0;
}

.impersonation-text {
    line-height: 1.3;
}

.impersonation-form {
    margin: 0;
    flex-shrink: 0;
}

.btn-leave-impersonate {
    background: rgba(255, 255, 255, 0.95);
    color: #4338ca;
    border: none;
    padding: 5px 14px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s ease;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
}

.btn-leave-impersonate:hover {
    background: #fff;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
}

@media (max-width: 768px) {
    .impersonation-top-banner {
        flex-direction: column;
        align-items: flex-start;
        padding: 8px 12px;
        gap: 8px;
    }
    .btn-leave-impersonate {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endif
