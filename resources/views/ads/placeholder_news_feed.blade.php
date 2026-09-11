@php
    $carouselId = 'newsFeedCarousel_' . ($ad->slot_name ?? 'slot_2');

    // Fetch latest news stories from database
    $feedNews = \App\NewsContent::orderBy('created_at', 'desc')->take(5)->get();

    // Category branding & routes
    $catMap = [
        'ghana-news'   => ['id' => 1, 'label' => 'Ghana News',   'color' => '#f59e0b', 'icon' => 'fa-landmark'],
        'africa-news'  => ['id' => 2, 'label' => 'Africa News',  'color' => '#10b981', 'icon' => 'fa-globe-africa'],
        'europe-news'  => ['id' => 3, 'label' => 'Europe News',  'color' => '#a855f7', 'icon' => 'fa-building-columns'],
        'america-news' => ['id' => 4, 'label' => 'America News', 'color' => '#3b82f6', 'icon' => 'fa-scale-balanced'],
        'asia-news'    => ['id' => 5, 'label' => 'Asia News',    'color' => '#ec4899', 'icon' => 'fa-compass'],
    ];

    $getCategoryMeta = function($catName) use ($catMap) {
        $clean = strtolower(trim($catName ?? ''));
        if (isset($catMap[$clean])) {
            return $catMap[$clean];
        }
        foreach ($catMap as $key => $data) {
            if (strpos($clean, str_replace('-news', '', $key)) !== false) {
                return $data;
            }
        }
        return [
            'id'    => 1,
            'label' => ucwords(str_replace(['-', '_'], ' ', $catName ?: 'Legal News')),
            'color' => '#06b6d4',
            'icon'  => 'fa-newspaper',
        ];
    };
@endphp

<style>
    .news-feed-placeholder-ad {
        margin-bottom: 0 !important;
    }
    @media (max-width: 991px) {
        .news-feed-placeholder-ad {
            margin-bottom: 0 !important;
        }
    }
</style>

<div class="card mb-0 news-feed-placeholder-ad" id="{{ $carouselId }}" style="background: #0f172a; border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.25); position: relative;">
    <!-- Carousel Header -->
    <div style="background: rgba(255, 255, 255, 0.02); border-bottom: 1px solid rgba(255, 255, 255, 0.06); padding: 10px 16px; display: flex; align-items: center; justify-content: space-between;">
        <a href="/News/Ghana-News/1" style="display: flex; align-items: center; gap: 6px; text-decoration: none;" title="Go to Newsroom">
            <i class="fa-solid fa-square-rss text-primary" style="font-size: 13px;"></i>
            <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #94a3b8; letter-spacing: 0.5px;">Daily Feed</span>
        </a>
        <a href="/News/Ghana-News/1" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6; border: 1px solid rgba(59, 130, 246, 0.2); font-size: 9px; font-weight: 700; text-transform: uppercase; padding: 2px 6px; border-radius: 100px; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='rgba(59, 130, 246, 0.25)'; this.style.color='#60a5fa'" onmouseout="this.style.background='rgba(59, 130, 246, 0.1)'; this.style.color='#3b82f6'" title="View All News">
            News & Blogs
        </a>
    </div>

    <!-- Slides Container -->
    <div class="slides-wrapper" style="position: relative; height: 185px; overflow: hidden;">
        @forelse($feedNews as $index => $item)
            @php
                $meta = $getCategoryMeta($item->news_category ?? '');
                $categoryUrl = url('/News/' . ($item->news_category ?: 'Ghana-News') . '/' . $meta['id']);
                $articleUrl = url('/News/' . ($item->news_category ?: 'Ghana-News') . '/' . rawurlencode($item->title) . '/' . $item->id);
                $extract = strip_tags($item->extract ?: $item->content ?: '');
                $timeAgo = $item->created_at ? $item->created_at->diffForHumans() : 'Recently';
            @endphp
            <div class="carousel-slide {{ $loop->first ? 'active' : '' }}" data-slide="{{ $index }}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; padding: 16px; display: flex; flex-direction: column; justify-content: space-between; transition: opacity 0.5s ease-in-out; opacity: {{ $loop->first ? '1' : '0' }}; z-index: {{ $loop->first ? '2' : '1' }}; pointer-events: {{ $loop->first ? 'auto' : 'none' }};">
                <div>
                    <div style="margin-bottom: 6px;">
                        <a href="{{ $categoryUrl }}" style="color: {{ $meta['color'] }}; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                            <i class="fa-solid {{ $meta['icon'] }}"></i> 
                            <span>{{ $meta['label'] }}</span>
                        </a>
                    </div>
                    <h6 style="font-weight: 700; font-size: 13px; line-height: 1.4; margin-bottom: 6px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                        <a href="{{ $articleUrl }}" style="color: #f8fafc; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#60a5fa'" onmouseout="this.style.color='#f8fafc'">
                            {{ $item->title }}
                        </a>
                    </h6>
                    <p style="color: #94a3b8; font-size: 11px; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; margin-bottom: 0;">
                        {{ \Illuminate\Support\Str::limit($extract, 130) }}
                    </p>
                </div>
                <div style="display: flex; align-items: center; justify-content: space-between; font-size: 10px; color: #64748b; margin-top: 10px;">
                    <span><i class="fa-regular fa-clock mr-1"></i> {{ $timeAgo }}</span>
                    <a href="{{ $articleUrl }}" style="color: #3b82f6; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; transition: all 0.2s;" onmouseover="this.style.color='#60a5fa'; this.style.transform='translateX(2px)';" onmouseout="this.style.color='#3b82f6'; this.style.transform='translateX(0)';">
                        Read More <i class="fa-solid fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        @empty
            <div class="carousel-slide active" data-slide="0" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; padding: 16px; display: flex; flex-direction: column; justify-content: space-between; opacity: 1; z-index: 2;">
                <div>
                    <div style="color: #f59e0b; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">
                        <i class="fa-solid fa-landmark mr-1"></i> Ghana News
                    </div>
                    <h6 style="color: #f8fafc; font-weight: 700; font-size: 13px; line-height: 1.4; margin-bottom: 6px;">
                        <a href="/News/Ghana-News/1" style="color: inherit; text-decoration: none;">Explore News & Legal Updates</a>
                    </h6>
                    <p style="color: #94a3b8; font-size: 11px; line-height: 1.4; margin-bottom: 0;">
                        Stay informed with accredited legal reporting, judicial pronouncements, and parliamentary updates.
                    </p>
                </div>
                <div style="display: flex; align-items: center; justify-content: space-between; font-size: 10px; color: #64748b; margin-top: 10px;">
                    <span><i class="fa-regular fa-clock mr-1"></i> Recent</span>
                    <a href="/News/Ghana-News/1" style="color: #3b82f6; font-weight: 600; text-decoration: none;">Read More <i class="fa-solid fa-arrow-right ml-1"></i></a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Carousel Footer Controls -->
    @if(count($feedNews) > 1)
    <div style="background: rgba(255, 255, 255, 0.01); border-top: 1px solid rgba(255, 255, 255, 0.05); padding: 8px 16px; display: flex; align-items: center; justify-content: space-between; height: 36px;">
        <!-- Arrows -->
        <div style="display: flex; gap: 10px;">
            <button type="button" class="carousel-arrow prev" style="background: none; border: none; padding: 0; color: #64748b; cursor: pointer; transition: color 0.2s;" onmouseover="this.style.color='#f8fafc'" onmouseout="this.style.color='#64748b'" title="Previous story">
                <i class="fa-solid fa-circle-chevron-left" style="font-size: 14px;"></i>
            </button>
            <button type="button" class="carousel-arrow next" style="background: none; border: none; padding: 0; color: #64748b; cursor: pointer; transition: color 0.2s;" onmouseover="this.style.color='#f8fafc'" onmouseout="this.style.color='#64748b'" title="Next story">
                <i class="fa-solid fa-circle-chevron-right" style="font-size: 14px;"></i>
            </button>
        </div>
        
        <!-- Dots -->
        <div class="carousel-indicators" style="display: flex; gap: 6px;">
            @foreach($feedNews as $index => $item)
                <span class="carousel-dot {{ $loop->first ? 'active' : '' }}" data-index="{{ $index }}" style="width: 6px; height: 6px; border-radius: 50%; background: {{ $loop->first ? '#3b82f6' : '#475569' }}; cursor: pointer; transition: background 0.2s;"></span>
            @endforeach
        </div>
    </div>
    @endif
</div>

<script>
(function() {
    const container = document.getElementById('{{ $carouselId }}');
    if (!container) return;
    
    const slides = container.querySelectorAll('.carousel-slide');
    const dots = container.querySelectorAll('.carousel-dot');
    const prevBtn = container.querySelector('.carousel-arrow.prev');
    const nextBtn = container.querySelector('.carousel-arrow.next');
    if (!slides.length || slides.length <= 1) return;

    let currentIndex = 0;
    let autoPlayInterval;
    
    function showSlide(index) {
        slides.forEach((slide, i) => {
            if (i === index) {
                slide.style.opacity = '1';
                slide.style.zIndex = '2';
                slide.style.pointerEvents = 'auto';
            } else {
                slide.style.opacity = '0';
                slide.style.zIndex = '1';
                slide.style.pointerEvents = 'none';
            }
        });
        dots.forEach((dot, i) => {
            dot.style.background = (i === index) ? '#3b82f6' : '#475569';
        });
        
        currentIndex = index;
    }
    
    function nextSlide() {
        if (slides.length <= 1) return;
        let index = (currentIndex + 1) % slides.length;
        showSlide(index);
    }
    
    function prevSlide() {
        if (slides.length <= 1) return;
        let index = (currentIndex - 1 + slides.length) % slides.length;
        showSlide(index);
    }
    
    function startAutoPlay() {
        stopAutoPlay();
        if (slides.length > 1) {
            autoPlayInterval = setInterval(nextSlide, 5000);
        }
    }
    
    function stopAutoPlay() {
        if (autoPlayInterval) clearInterval(autoPlayInterval);
    }
    
    if (prevBtn) {
        prevBtn.addEventListener('click', (e) => {
            e.preventDefault();
            prevSlide();
            startAutoPlay();
        });
    }
    
    if (nextBtn) {
        nextBtn.addEventListener('click', (e) => {
            e.preventDefault();
            nextSlide();
            startAutoPlay();
        });
    }
    
    dots.forEach(dot => {
        dot.addEventListener('click', (e) => {
            e.preventDefault();
            const index = parseInt(dot.getAttribute('data-index'), 10);
            if (!isNaN(index)) {
                showSlide(index);
                startAutoPlay();
            }
        });
    });
    
    // Hover events to pause
    container.addEventListener('mouseenter', stopAutoPlay);
    container.addEventListener('mouseleave', startAutoPlay);
    
    // Initial start
    startAutoPlay();
})();
</script>