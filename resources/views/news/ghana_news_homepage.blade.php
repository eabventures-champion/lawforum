@extends('extenders.news-main')

@section('title', ucwords(strtolower($newscategory['name'])))

@section('assets')
    
@endsection

@section('content')

    <!-- The Carousel Part 1 -->
    <div class="container-fluid">
    <div class="row">
    <div class="col-lg-9">
    <div class="site-section py-0">
      <div class="owl-carousel hero-slide owl-style">
        @foreach($carouselSelectors as $newsContent)
        <div class="site-section">
          <div class="container-fluid">
            <div class="half-post-entry d-block d-lg-flex" style="height: 410px;">
              <!-- <div class="img-bg" style='background-image: url("/storage/$newsContent->picture");'></div> -->
              <img src="{{ url('storage/'.$newsContent->image) }}" />
              <div class="contents bg-light">
                <!-- <span class="caption">Editor's Pick</span> -->
                <h2><a href="/News/{{ $newsContent->news_category }}/{{ $newsContent->title }}/{{ $newsContent->id }}">{{ $newsContent->title }}</a></h2>
                <p class="mb-3">
                {{ Str::limit($newsContent->extract, 200, ' ...') }}                
                </p>
                <!-- <div class="post-meta">
                  <span class="d-block"><a href="#">Dave Rogers</a> in <a href="#">Food</a></span>
                  <span class="date-read">Jun 14 <span class="mx-1">&bullet;</span> 3 min read <span class="icon-star2"></span></span>
                </div> -->
              </div>
            </div>
          </div>
        </div>
      @endforeach  
      </div>
    </div>
    </div>
    <div class="col-lg-3 bg-light"></div>
    </div>
    </div>
    <!-- End of The Carousel Part 1 -->

    <!-- Advertisement -->
    <div class="site-section">
      <div class="container-fluid">
          <div class="col-lg-12 bg-light" style="height: 120px;">
          
          </div>
      </div>
    </div>
    

    <!-- PART 2 -->
    <div class="site-section">
      <div class="container">
      <div class="row">
        <!-- the news part -->
          <div class="col-lg-10">
            <!-- <div class="row">
              <div class="col-12">
                <div class="section-title">
                  <h2>The latest News Entry shows here</h2>
                </div>
              </div>
            </div> -->
            <div class="row">
              <div class="col-md-5">
                <div class="post-entry-1">
                  <a href="/News/{{ $newsContent->news_category }}/{{ $newsContent->title }}/{{ $newsContent->id }}"><img src="{{ url('storage/'.$newsContent->image) }}" alt="Image" class="img-fluid" height="1px" width="100%"></a>
                  <h2><a href="/News/{{ $newsContent->news_category }}/{{ $newsContent->title }}/{{ $newsContent->id }}">{{ $newsContent->title }}</a></h2>
                  
                  
                  {{ Str::limit($newsContent->extract, 170, ' ...') }} 
                  
                  {{--
                  <div class="post-meta">
                    <span class="d-block"><a href="#">Dave Rogers</a> in <a href="#">News</a></span>
                    <span class="date-read">Jun 14 <span class="mx-1">&bullet;</span> 3 min read <span class="icon-star2"></span></span>
                  </div>
                  --}}
                </div>
              </div>
              
              <div class="col-md-7">
              @foreach($latestNewsContents as $latestNewsContent)
                <div class="post-entry-2 d-flex">
                <!-- <img src="{{ url('storage/'.$latestNewsContent->picture) }}" alt="Image" class="thumbnail"> -->
                <!-- <div class="thumbnail" style="background-image: url('./$latestNewsContent->picture');"></div> -->
                <img src="{{ url('storage/'.$latestNewsContent->image) }}" alt="Image" class="thumbnail" style="height: 40px; width: 40px;">
                <!-- <div class="img-bg" style="background-image: url('storage/'.$latestNewsContent->picture);"  style="height: 50px; width: 50px;"></div> -->
                  &nbsp;&nbsp;
                  <div class="contents bg-light">
                    <h2><a href="/News/{{ $latestNewsContent->news_category }}/{{ $latestNewsContent->title }}/{{ $latestNewsContent->id }}">{{ $latestNewsContent->title }}</a></h2>
                    <span>
                    {{ Str::limit($latestNewsContent->extract, 170, ' ...') }}                   
                    </span>
                    {{--                    
                    <div class="post-meta">
                      <span class="d-block"><a href="#">Dave Rogers</a> in <a href="#">News</a></span>
                      <span class="date-read">Jun 14 <span class="mx-1">&bullet;</span> 3 min read <span class="icon-star2"></span></span>
                    </div>
                    --}}
                  </div>
                </div>
              @endforeach
              </div>
            </div>
          </div>
          <!-- the ads part -->
          <div class="col-lg-2 bg-light">
            

          </div>
        </div>
      </div>
    </div>
    <!-- END OF PART 2 -->

    <!-- Advertisement -->
    <div class="site-section">
      <div class="container-fluid">
          <div class="col-lg-12 bg-light" style="height: 120px;">

          </div>
      </div>
    </div>

    
    <!-- PART 3 -->
    <div class="site-section">
      <div class="container">
        <div class="row">
        <div class="col-lg-2 bg-light"></div>
          <div class="col-lg-8">
            <div id="table_data">
                @include('news.displayed_all_ghana_news')
            </div>
          </div>
          <!-- end of 1st 6column -->
          <div class="col-lg-2 bg-light"></div>
        </div>
      </div>
    </div>
    <!-- END OF PART 3 -->

@endsection

@section('scripts')
<script>
        $(document).ready(function(){
            $(document).on('click', '.pagination a', function(event){
              event.preventDefault();
              var page = $(this).attr('href').split('page=')[1];
              fetch_data(page);
            });

            function fetch_data(page){
              $.ajax({
                url:"/News/Next/{{$newscategory['name']}}/fetch_data?page="+page,
                success:function(data){
                    $('#table_data').html(data);
                }
              }).fail(function(jqXHR, ajaxOptions, thrownError){
              alert('No response from server');
              });
            }
        });
</script>

@endsection