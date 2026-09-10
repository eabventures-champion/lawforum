@if($newsSelectors->count() > 0)
    <div class="news-grid-feed">
        @foreach($newsSelectors as $article)
            @php
                $words = str_word_count(strip_tags($article->content ?? $article->extract));
                $readTime = max(1, ceil($words / 200));
                $cleanCategory = str_replace('-', ' ', $article->news_category);
            @endphp
            <article class="news-feed-card">
                <a href="/News/{{ $article->news_category }}/{{ $article->title }}/{{ $article->id }}" class="card-image-link">
                    @if(!empty($article->image))
                        <img src="{{ url('storage/'.$article->image) }}" alt="{{ $article->title }}" class="feed-card-thumb" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="card-img-fallback" style="display: none;">
                            <i class="fa-solid fa-scale-balanced fallback-icon"></i>
                            <span class="fallback-cat">{{ $cleanCategory }}</span>
                        </div>
                    @else
                        <div class="card-img-fallback">
                            <i class="fa-solid fa-scale-balanced fallback-icon"></i>
                            <span class="fallback-cat">{{ $cleanCategory }}</span>
                        </div>
                    @endif
                    <span class="card-badge-pill">{{ $cleanCategory }}</span>
                </a>

                <div class="card-body-content">
                    <div class="card-meta-line">
                        <span><i class="fa-regular fa-calendar"></i> {{ $article->created_at ? $article->created_at->format('M d, Y') : 'Recent' }}</span>
                        <span>&bull;</span>
                        <span><i class="fa-regular fa-clock"></i> {{ $readTime }} min read</span>
                    </div>

                    <h3 class="card-headline">
                        <a href="/News/{{ $article->news_category }}/{{ $article->title }}/{{ $article->id }}">
                            {{ $article->title }}
                        </a>
                    </h3>

                    <p class="card-excerpt">
                        {{ Str::limit(strip_tags($article->extract ?: $article->content), 140, '...') }}
                    </p>

                    <div class="card-footer-cta">
                        <a href="/News/{{ $article->news_category }}/{{ $article->title }}/{{ $article->id }}" class="read-more-link">
                            <span>Read Full Story</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </article>
        @endforeach
    </div>

    <!-- Pagination Controls -->
    <div class="news-pagination-wrapper">
        {!! $newsSelectors->links('news.pagination') !!}
    </div>
@else
    <div class="news-empty-state">
        <div class="empty-icon-wrap">
            <i class="fa-solid fa-newspaper"></i>
        </div>
        <h4>No News Articles Found</h4>
        <p>There are currently no published stories matching your criteria in this section.</p>
    </div>
@endif
