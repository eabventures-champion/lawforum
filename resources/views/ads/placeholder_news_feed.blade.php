@php
    $carouselId = 'newsFeedCarousel_' . $ad->slot_name;
@endphp

<div class="card mb-3 news-feed-placeholder-ad" id="{{ $carouselId }}" style="background: #0f172a; border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.25); position: relative;">
    <!-- Carousel Header -->
    <div style="background: rgba(255, 255, 255, 0.02); border-bottom: 1px solid rgba(255, 255, 255, 0.06); padding: 10px 16px; display: flex; align-items: center; justify-content: space-between;">
        <div style="display: flex; align-items: center; gap: 6px;">
            <i class="fa-solid fa-square-rss text-primary" style="font-size: 13px;"></i>
            <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #94a3b8; letter-spacing: 0.5px;">Daily Feed</span>
        </div>
        <span style="background: rgba(59, 130, 246, 0.1); color: #3b82f6; border: 1px solid rgba(59, 130, 246, 0.2); font-size: 9px; font-weight: 700; text-transform: uppercase; padding: 2px 6px; border-radius: 100px;">
            News & Blogs
        </span>
    </div>

    <!-- Slides Container -->
    <div class="slides-wrapper" style="position: relative; height: 180px; overflow: hidden;">
        <!-- Slide 1 -->
        <div class="carousel-slide active" data-slide="0" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; padding: 16px; display: flex; flex-direction: column; justify-content: space-between; transition: opacity 0.5s ease-in-out; opacity: 1; z-index: 2;">
            <div>
                <div style="color: #f59e0b; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">
                    <i class="fa-solid fa-scale-balanced mr-1"></i> Supreme Court
                </div>
                <h6 style="color: #f8fafc; font-weight: 700; font-size: 13px; line-height: 1.4; margin-bottom: 6px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                    Landmark Decision: Clarifying Constitutional Executive Limits
                </h6>
                <p style="color: #94a3b8; font-size: 11px; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; margin-bottom: 0;">
                    In a unanimous ruling, the Supreme Court has set clear boundaries on the exercise of discretionary power under Article 296, reinforcing institutional accountability.
                </p>
            </div>
            <div style="display: flex; align-items: center; justify-content: space-between; font-size: 10px; color: #64748b; margin-top: 10px;">
                <span><i class="fa-regular fa-clock mr-1"></i> Just now</span>
                <span style="color: #3b82f6; font-weight: 600; cursor: pointer;">Read More <i class="fa-solid fa-arrow-right ml-1"></i></span>
            </div>
        </div>

        <!-- Slide 2 -->
        <div class="carousel-slide" data-slide="1" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; padding: 16px; display: flex; flex-direction: column; justify-content: space-between; transition: opacity 0.5s ease-in-out; opacity: 0; z-index: 1; pointer-events: none;">
            <div>
                <div style="color: #10b981; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">
                    <i class="fa-solid fa-file-invoice mr-1"></i> Parliament
                </div>
                <h6 style="color: #f8fafc; font-weight: 700; font-size: 13px; line-height: 1.4; margin-bottom: 6px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                    New Digitization & Data Protection Bill Tabled
                </h6>
                <p style="color: #94a3b8; font-size: 11px; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; margin-bottom: 0;">
                    The Ministry has proposed comprehensive amendments to the Data Protection Act to enforce stricter compliance on digital platforms and protect user privacy rights.
                </p>
            </div>
            <div style="display: flex; align-items: center; justify-content: space-between; font-size: 10px; color: #64748b; margin-top: 10px;">
                <span><i class="fa-regular fa-clock mr-1"></i> 2 hours ago</span>
                <span style="color: #3b82f6; font-weight: 600; cursor: pointer;">Read More <i class="fa-solid fa-arrow-right ml-1"></i></span>
            </div>
        </div>

        <!-- Slide 3 -->
        <div class="carousel-slide" data-slide="2" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; padding: 16px; display: flex; flex-direction: column; justify-content: space-between; transition: opacity 0.5s ease-in-out; opacity: 0; z-index: 1; pointer-events: none;">
            <div>
                <div style="color: #a855f7; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">
                    <i class="fa-solid fa-feather-pointed mr-1"></i> Legal Blog
                </div>
                <h6 style="color: #f8fafc; font-weight: 700; font-size: 13px; line-height: 1.4; margin-bottom: 6px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                    Analyzing the Evolution of Customary Land Law
                </h6>
                <p style="color: #94a3b8; font-size: 11px; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; margin-bottom: 0;">
                    An expert review on the recent Land Act, 2020 (Act 1036) and its impact on disputes, registry digitization, and traditional customary ownership systems.
                </p>
            </div>
            <div style="display: flex; align-items: center; justify-content: space-between; font-size: 10px; color: #64748b; margin-top: 10px;">
                <span><i class="fa-regular fa-clock mr-1"></i> Yesterday</span>
                <span style="color: #3b82f6; font-weight: 600; cursor: pointer;">Read More <i class="fa-solid fa-arrow-right ml-1"></i></span>
            </div>
        </div>
    </div>

    <!-- Carousel Footer Controls -->
    <div style="background: rgba(255, 255, 255, 0.01); border-top: 1px solid rgba(255, 255, 255, 0.05); padding: 8px 16px; display: flex; align-items: center; justify-content: space-between; height: 36px;">
        <!-- Arrows -->
        <div style="display: flex; gap: 10px;">
            <button class="carousel-arrow prev" style="background: none; border: none; padding: 0; color: #64748b; cursor: pointer; transition: color 0.2s;" onmouseover="this.style.color='#f8fafc'" onmouseout="this.style.color='#64748b'">
                <i class="fa-solid fa-circle-chevron-left" style="font-size: 14px;"></i>
            </button>
            <button class="carousel-arrow next" style="background: none; border: none; padding: 0; color: #64748b; cursor: pointer; transition: color 0.2s;" onmouseover="this.style.color='#f8fafc'" onmouseout="this.style.color='#64748b'">
                <i class="fa-solid fa-circle-chevron-right" style="font-size: 14px;"></i>
            </button>
        </div>
        
        <!-- Dots -->
        <div class="carousel-indicators" style="display: flex; gap: 6px;">
            <span class="carousel-dot active" data-index="0" style="width: 6px; height: 6px; border-radius: 50%; background: #3b82f6; cursor: pointer; transition: background 0.2s;"></span>
            <span class="carousel-dot" data-index="1" style="width: 6px; height: 6px; border-radius: 50%; background: #475569; cursor: pointer; transition: background 0.2s;"></span>
            <span class="carousel-dot" data-index="2" style="width: 6px; height: 6px; border-radius: 50%; background: #475569; cursor: pointer; transition: background 0.2s;"></span>
        </div>
    </div>
</div>

<script>
(function() {
    const container = document.getElementById('{{ $carouselId }}');
    if (!container) return;
    
    const slides = container.querySelectorAll('.carousel-slide');
    const dots = container.querySelectorAll('.carousel-dot');
    const prevBtn = container.querySelector('.carousel-arrow.prev');
    const nextBtn = container.querySelector('.carousel-arrow.next');
    let currentIndex = 0;
    let autoPlayInterval;
    
    function showSlide(index) {
        slides.forEach(slide => {
            slide.style.opacity = '0';
            slide.style.zIndex = '1';
            slide.style.pointerEvents = 'none';
        });
        dots.forEach(dot => {
            dot.style.background = '#475569';
        });
        
        slides[index].style.opacity = '1';
        slides[index].style.zIndex = '2';
        slides[index].style.pointerEvents = 'auto';
        dots[index].style.background = '#3b82f6';
        
        currentIndex = index;
    }
    
    function nextSlide() {
        let index = (currentIndex + 1) % slides.length;
        showSlide(index);
    }
    
    function prevSlide() {
        let index = (currentIndex - 1 + slides.length) % slides.length;
        showSlide(index);
    }
    
    function startAutoPlay() {
        stopAutoPlay();
        autoPlayInterval = setInterval(nextSlide, 5000);
    }
    
    function stopAutoPlay() {
        if (autoPlayInterval) clearInterval(autoPlayInterval);
    }
    
    prevBtn.addEventListener('click', () => {
        prevSlide();
        startAutoPlay();
    });
    
    nextBtn.addEventListener('click', () => {
        nextSlide();
        startAutoPlay();
    });
    
    dots.forEach(dot => {
        dot.addEventListener('click', () => {
            const index = parseInt(dot.getAttribute('data-index'), 10);
            showSlide(index);
            startAutoPlay();
        });
    });
    
    // Hover events to pause
    container.addEventListener('mouseenter', stopAutoPlay);
    container.addEventListener('mouseleave', startAutoPlay);
    
    // Initial start
    startAutoPlay();
})();
</script>
