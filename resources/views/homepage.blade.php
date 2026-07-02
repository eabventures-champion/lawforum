@extends('layouts.app')

@section('assets')
  <style>
    a:hover{
    text-decoration: none;
    }
    .card-deck .card {
    display: flex;
    flex: 1 0 0%;
    flex-direction: column;
    margin-right: 1.5px;
    margin-bottom: 0;
    margin-left: 1.5px;
    }
    .carousel-item {
    height: 75vh;
    min-height: 150px;
    background: no-repeat center center scroll;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
    }
    .carousel-caption {
    position: absolute;
    right: 15%;
    bottom: 150px;
    left: 15%;
    z-index: 10;
    padding-top: 20px;
    padding-bottom: 20px;
    color: #fff;
    text-align: center;
    }
    .carousel-indicators{
      bottom: 80px;
    }
    
  </style>
@endsection
    
@section('content')
<header>
  <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <div class="carousel-indicators">
      <form action="{{ url('main_home_search') }}" method="GET">
        {{ csrf_field() }}
        <div class="input-group">         
          <input style="font-size:12pt; height:35px; width:350px;" type="text" class="form-control border border-dark rounded-lg" name="search_text" placeholder="Search any law or case in Ghana...">
        </div>
      </form>
    </div>
  
    <div class="carousel-inner" role="listbox">
      <!-- Slide One - Set the background image for this slide in the line below -->
      <div class="carousel-item active" style="background-image: url(home_background/hall.jpg)">
        <div class="carousel-caption d-none d-md-block">
          <h1 class="display-4"><b>Efficient Legal Research</b></h1>
          <p class="lead">Fast and accurate insight into laws and cases in Ghana</p>
        </div>
      </div>
      <!-- Slide Two - Set the background image for this slide in the line below -->
      <div class="carousel-item" style="background-image: url(home_background/parliament.jpg)">
        <div class="carousel-caption d-none d-md-block">
          <h1 class="display-4"><b>Flexible Access to Resources</b></h1>
          <p class="lead">Multiple search and filter for need-based research</p>
        </div>
      </div>
      <!-- Slide Three - Set the background image for this slide in the line below -->
      <div class="carousel-item" style="background-image: url(home_background/text_book.jpeg)">
        <div class="carousel-caption d-none d-md-block">
          <h1 class="display-4"><b>Convenient & Cost Effective</b></h1>
          <p class="lead">Access thousands of Cases and laws for free</p>
        </div>
      </div>
      <!-- Slide Four - Set the background image for this slide in the line below -->
      <div class="carousel-item" style="background-image: url(home_background/scholar.jpg)">
        <div class="carousel-caption d-none d-md-block">
          <h1 class="display-4"><b>Precise Search Navigation</b></h1>
          <p class="lead">Explore and find your desired searches</p>
        </div>
      </div>
    </div>
    {{-- <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
    </a> --}}
  </div>
  @include('ads.manual_ads_homepage_popup')
</header>
<!-- Page Content -->
<section class="pt-1">
  <div class="container-fluid mb-0 mt-0">
    <div class="pricing card-deck flex-column flex-md-row mb-0">
        <div class="card card-pricing text-center pt-1 mb-0">
            <span class="h5 w-60 mx-auto px-4 py-1 rounded-bottom text-primary shadow-sm"><a href="/constitution/Republic/Ghana/1"><b>Constitution</b></a></span>
            <a href="/constitution/Republic/Ghana/1">
              <div class="card-body pt-0">
                <ul class="list-unstyled mb-0 text-dark">
                    <li><b>Access constitution of Ghana along with constitution of over 100 countries in Africa, Asia, America and Europe</b></li>
                </ul>
            </div>
            </a>
        </div>
        <div class="card card-pricing text-center pt-1 mb-0">
          <span class="h5 w-60 mx-auto px-4 py-1 rounded-bottom text-primary shadow-sm"><a href="/pre-1992-legislation"><b>Old Laws</b></a></span>
          <a href="/pre-1992-legislation">
          <div class="card-body pt-0">
              <ul class="list-unstyled mb-0 text-dark">
                  <li><b>Access over 200 Ghanaian laws and enactments before the Fourth Republic</b></li>
              </ul>
          </div>
          </a>
        </div>
        <div class="card card-pricing text-center pt-1 mb-0">
          <span class="h5 w-60 mx-auto px-4 py-1 rounded-bottom text-primary shadow-sm"><a href="/post-1992-legislation"><b>New Laws</b></a></span>
          <a href="/post-1992-legislation">
          <div class="card-body pt-0">
              <ul class="list-unstyled mb-0 text-dark">
                  <li><b>Access over 200 consolidated laws of Ghana including Acts, Regulations and Amendments in the Fourth Republic</b></li>
              </ul>
          </div>
          </a>
        </div>
        <div class="card card-pricing text-center pt-1 mb-0">
          <span class="h5 w-60 mx-auto px-4 py-1 rounded-bottom text-primary shadow-sm"><a href="/judgement/Ghana"><b>Case Laws</b></a></span>
          <a href="/judgement/Ghana">
          <div class="card-body pt-0">
              <ul class="list-unstyled mb-0 text-dark">
                  <li><b>Access several decided cases in Ghana including Supreme Court, High Court and Court of Appeal cases</b></li>
              </ul>
          </div>
          </a>
        </div>
        <div class="card card-pricing text-center pt-1 mb-0">
          <span class="h5 w-60 mx-auto px-4 py-1 rounded-bottom text-primary shadow-sm"><a href="/News/Ghana-News/1"><b>News</b></a></span>
          {{-- <span class="h5 w-60 mx-auto px-4 py-1 rounded-bottom text-primary shadow-sm"><b>News</b></span> --}}
          <a href="/News/Ghana-News/1">
          <div class="card-body pt-0">
              <ul class="list-unstyled mb-0 text-dark">
                  <li><b>Access relevant legal and business news content in Ghana, Africa, Asia, Europe and America</b></li>
              </ul>
          </div>
          {{-- </a> --}}
        </div>
      
    </div>
  </div>
</section>
@endsection

@section('scripts')
  {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
  {{-- <script src="{{ asset('js/jquery-3.0.0.js') }}"></script> --}}
  <script>
    $(document).ready(function(){
      $('#exampleModal').modal('show');
    });
  </script>
@endsection
