<div class="card mb-3 premium-placeholder-ad" style="background: linear-gradient(135deg, #0f172a, #1e293b); border: 1px dashed rgba(245, 158, 11, 0.25); border-radius: 12px; overflow: hidden; padding: 24px; text-align: center; box-shadow: 0 4px 20px rgba(0,0,0,0.25); transition: all 0.3s ease;">
    <div class="placeholder-icon mb-3" style="display: inline-flex; align-items: center; justify-content: center; width: 60px; height: 60px; border-radius: 50%; background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.2);">
        <i class="fa-solid fa-rectangle-ad text-warning" style="font-size: 24px;"></i>
    </div>
    
    <h5 class="text-white" style="font-weight: 700; font-size: 15px; letter-spacing: 0.5px; margin-bottom: 8px;">ADVERTISE YOUR PRODUCT</h5>
    
    <p style="color: #94a3b8; font-size: 12px; line-height: 1.5; margin-bottom: 20px;">
        Sponsor this premium sidebar slot to get your brand, product, or services in front of thousands of legal practitioners, scholars, and researchers.
    </p>
    
    <a href="{{ $ad->target_url ?? 'mailto:advertise@legalsforum.com?subject=Advertise%20on%20Legals%20Forum' }}" 
       class="btn btn-outline-warning btn-sm btn-block" 
       style="border-radius: 8px; font-weight: 600; font-size: 12px; padding: 8px 12px; transition: all 0.2s ease; border: 1px solid var(--gold); color: var(--gold); background: transparent;"
       onmouseover="this.style.background='var(--accent-gradient)'; this.style.color='#fff'; this.style.border='1px solid transparent';"
       onmouseout="this.style.background='transparent'; this.style.color='var(--gold)'; this.style.border='1px solid var(--gold)';"
       target="_blank">
        <i class="fa-solid fa-bullhorn mr-1"></i> Advertise With Us
    </a>
</div>
