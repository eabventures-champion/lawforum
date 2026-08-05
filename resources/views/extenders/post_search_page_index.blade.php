@extends('extenders.main')

@section('title', 'Search Results')

@section('assets')
<style type="text/css">
        .header {
          background: #888888;
          color: #f1f1f1;
          text-align: center;
          position: -webkit-sticky;
          position: sticky;
          top: 0;
        }
        ::-webkit-scrollbar {
        width: 7px;
        }
        div::-webkit-scrollbar-button {
          display: block;
          width: 17px;
          height: 17px;
        }
        div::-webkit-scrollbar-button:decrement:start {
          background-color:lightblue;
          border:1px solid #eee;
        }
        div::-webkit-scrollbar-button:increment:start {
          background-color:lightblue;
          border:1px solid #eee;
        }
        div::-webkit-scrollbar-button:decrement:end {
          background-color:lightblue;
          border:1px solid #eee;
        }
        div::-webkit-scrollbar-button:increment:end {
          background-color:lightblue;
          border:1px solid #eee;;
        }
        ::-webkit-scrollbar-thumb {
        background: #888; 
        }

        ::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3); 
        border-radius: 10px;
        } 
        ::-webkit-scrollbar-thumb:hover {
        background: #555; 
        }
        .content {
          padding: 16px;
        }
        .search-well-filter{
          background-color: #ffffff;
          border: 1px solid #e2e2e2;
          border-radius: 6px;
          box-shadow: 0 1px 5px #e0e0e0;
          padding: 25px 25px;
          font-size: 16px;
        }.search-well{
          background-color: #ffffff;
          border: 1px solid #e2e2e2;
          border-radius: 6px;
          box-shadow: 0 1px 5px #e0e0e0;
          padding: 25px 25px;
        }
        .wrapper {
  display: flex;
  justify-content: space-between;
}.main,
.sidebar {
  border: 5px solid $color-dark;
  background-color: $color-background;
  border-radius: 2px;
  color: $color-dark;
  padding: .1px;
  /* margin-top: 20px; */
}.main {
  width: 80%;
  /* height: 200vh; */
  /* min-height: 1000px; */
  display: flex;
  flex-direction: column;
}.sidebar {
  /* width: 25%; */
  /* height: 50vh; */
  /* min-height: 200px; */
  overflow: auto;
  position: -webkit-sticky;
  position: sticky;
  top: 15%;
}.make_stick{
  position: -webkit-sticky;
  position: sticky;
  top: 10%;
}
</style>
@endsection

@section('content')

<div class="container-fluid">

  <div class="row">
      <div class="col-md-3" style="margin-top:10px;">
        {{-- <h4>Filter</h4> --}}
      </div>
      
      <div class="col-md-offset-1 col-md-6" style="margin-top:10px; margin-bottom: 10px;">
        <form action="{{ url('main_home_search') }}" method="GET">
          {{ csrf_field() }}
          <div class="input-group">         
                <input type="text" class="form-control" name="search_text" placeholder="Search any law or case in Ghana"">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
                </span>
          </div>
        </form>       
      </div>
      <div class="col-md-2" style="margin-top:25px;">
      <p style="color:blue;"><b class="hidden">Found: {{$total_posts_count}} Results</b></p>
      </div>
    
  </div>

  <div class="row">
    {{-- <div class="wrapper"> --}}

      <div class="col-md-3">
        <div class="sidebar">
          <div class="search-well-filter">
            <p class="small" style="color:blue;"><b><span style="color:red;">{{number_format($total_posts_count)}}</span>&nbsp;Results Found&nbsp;for&nbsp;<span style="color:red;">"{{$query}}"</span></b></p><hr>
              <p style="color:blue;">Filter Option</p>
              <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input all1" id="all_posts" name="act-type" value="All" checked>
                <label class="custom-control-label" for="defaultChecked">All</label>&nbsp;<span class="badge">{{$total_posts_count}}</span>
              </div>
              <br>
              <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input post1" id="for_post" name="act-type" value="Post">
                <label class="custom-control-label" for="defaultUnchecked">Acts of Parliament</label>&nbsp;<span class="badge">{{$posts_count}}</span>
              </div>
              <br>
              <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input reg1" id="for_regulations" name="act-type" value="Regulation">
                <label class="custom-control-label" for="defaultUnchecked">Legislative Instruments</label>&nbsp;<span class="badge">{{$regulations_count}}</span>
              </div>
              <br>
              <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input consti1" id="for_constitutional" name="act-type" value="Constitutional">
                <label class="custom-control-label" for="defaultUnchecked">Constitutional Instruments</label>&nbsp;<span class="badge">{{$constitutional_count}}</span>
              </div>
              <br>
              <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input exe1" id="for_executive" name="act-type" value="Executive">
                <label class="custom-control-label" for="defaultUnchecked">Executive Instruments</label>&nbsp;<span class="badge">{{$executives_count}}</span>
              </div>
              <br>
              <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input amend_act1" id="for_amended_acts" name="act-type" value="Amend_Act">
                <label class="custom-control-label" for="defaultUnchecked">Amended Acts</label>&nbsp;<span class="badge">{{$amends_count}}</span>
              </div>
              <br>
              <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input amend_reg1" id="for_amended_regulation" name="act-type" value="Amend_Regulation">
                <label class="custom-control-label" for="defaultUnchecked">Amended Regulations</label>&nbsp;<span class="badge">{{$amends_regs_count}}</span>
              </div>
              <br><br><br><br>
          </div>
        </div>
      </div>

      <div class="col-md-9">
        <div id="paginate_data">
          @include('extenders.search_paginate')
        </div>
      </div>

    {{-- </div> --}}
  </div>

</div>
    
@endsection 

@section('scripts')
<script>
  if ( {{$total_posts_count}} == 0 ) {
    document.getElementById("all_posts").disabled = true;
    document.getElementById("for_post").disabled = true;
    document.getElementById("for_regulations").disabled = true;
    document.getElementById("for_constitutional").disabled = true;
    document.getElementById("for_executive").disabled = true;
    document.getElementById("for_amended_acts").disabled = true; 
    document.getElementById("for_amended_regulation").disabled = true;     
  }
  if ( {{$posts_count}} == 0 ) {
    document.getElementById("for_post").disabled = true;   
  }
  if ( {{$regulations_count}} == 0 ) {
    document.getElementById("for_regulations").disabled = true;   
  }
  if ( {{$constitutional_count}} == 0 ) {
    document.getElementById("for_constitutional").disabled = true;   
  }
  if ( {{$executives_count}} == 0 ) {
    document.getElementById("for_executive").disabled = true;   
  }
  if ( {{$amends_count}} == 0 ) {
    document.getElementById("for_amended_acts").disabled = true;   
  }
  if ( {{$amends_regs_count}} == 0 ) {
    document.getElementById("for_amended_regulation").disabled = true;   
  }
</script>

<script>
        $(document).ready(function(){

          $(function () {
    $("input[name=act-type]:radio").click(function () {
      
        if ($('input[name=act-type]:checked').val() == "All") {
          $('.all1').click(function() {

          $('html, body').animate({
            scrollTop: $("body").offset().top
          }, 1000)
          });
          $('.only_post').show();
          $('.only_amend_acts').show();
          $('.only_regulation').show();
          $('.only_constitutional').show();
          $('.only_executive').show();
          $('.only_amend_reg').show();

        } else if ($('input[name=act-type]:checked').val() == "Post") {
          $('.post1').click(function() {

          $('html, body').animate({
            scrollTop: $("body").offset().top
          }, 1000)
          });

          $('.only_post').show().insertAfter( ".move_here" );
          $('.only_amend_acts').hide();
          $('.only_regulation').hide();
          $('.only_amend_reg').hide();
          $('.only_constitutional').hide();
          $('.only_executive').hide();


        }
        else if ($('input[name=act-type]:checked').val() == "Regulation") {
          // $('.only_regulation').fadeIn().insertAfter( ".move_here" ).scrollTo('.top_here');
          $('.reg1').click(function() {

            $('html, body').animate({
              scrollTop: $("body").offset().top
            }, 1000)
          });

            $('.only_regulation').show().insertAfter( ".move_here" );
            $('.only_post').hide();
            $('.only_amend_acts').hide();
            $('.only_amend_reg').hide();
            $('.only_constitutional').hide();
            $('.only_executive').hide();
        }
        else if ($('input[name=act-type]:checked').val() == "Constitutional") {
          $('.consti1').click(function() {

            $('html, body').animate({
              scrollTop: $("body").offset().top
            }, 1000)
          });

            $('.only_constitutional').show().insertAfter( ".move_here" );
            $('.only_post').hide();
            $('.only_regulation').hide();
            $('.only_amend_acts').hide();
            $('.only_amend_reg').hide();
            $('.only_executive').hide();
        }
        else if ($('input[name=act-type]:checked').val() == "Executive") {
          $('.exe1').click(function() {

            $('html, body').animate({
              scrollTop: $("body").offset().top
            }, 1000)
          });

            $('.only_executive').show().insertAfter( ".move_here" );
            $('.only_post').hide();
            $('.only_regulation').hide();
            $('.only_amend_acts').hide();
            $('.only_amend_reg').hide();
            $('.only_constitutional').hide();
        }
        else if ($('input[name=act-type]:checked').val() == "Amend_Act") {
          $('.amend_act1').click(function() {

          $('html, body').animate({
            scrollTop: $("body").offset().top
          }, 1000)
          });

          $('.only_amend_acts').show().insertAfter( ".move_here" );
          $('.only_post').hide();
          $('.only_regulation').hide();
          $('.only_amend_reg').hide();
          $('.only_constitutional').hide();
          $('.only_executive').hide();


        }
        else if ($('input[name=act-type]:checked').val() == "Amend_Regulation") {
          $('.amend_reg1').click(function() {

          $('html, body').animate({
            scrollTop: $("body").offset().top
          }, 1000)
          });

          $('.only_amend_reg').show().insertAfter( ".move_here" );
          $('.only_post').hide();
          $('.only_amend_acts').hide();
          $('.only_regulation').hide();
          $('.only_constitutional').hide();
          $('.only_executive').hide();


        }
    });
  });

            $(document).on('click', '.pagination a', function(event){
              event.preventDefault();
              var page = $(this).attr('href').split('page=')[1];
              fetch_data(page);
            });

            function fetch_data(page){
              $.ajax({
                url:"/Search/Next/{{$query}}/fetch_data/?page="+page,
                success:function(data){
                    $('#paginate_data').html(data);
                }
              }).fail(function(jqXHR, ajaxOptions, thrownError){
              alert('No response from server');
              });
            }
        });
</script>

@endsection

    {{-- <div class="container">
        <center><h3><b>{{ $allPost1992Act['title'] }}</b></h3></center>
    </div> --}}
    {{-- <div class="container">
        <u><h5><b>Searched Results</b></h5></u>
    </div> --}}
    
    {{-- <div class="container-fluid">	

      <div class="row">

        <div class="col-md-3"> --}}
              {{-- <div class="filter-side search-sidebar">
                <div class="right-sidebar-toggle">
                    <a href="#" class="filter-link">
                        <i class="fa fa-filter" aria-hidden="true"></i>
                        <span>FILTER</span>
                    </a>
                </div>
                <div class="search-sidebar-scroll" style="overflow: hidden; width: auto; height: 100%;">
                    <div class="filters-header">
                        <h4>Filter</h4>
                        <div id="btnClearFilter" class="reset-filters"><a href="#/"><i class="os-icon-close os-icon"></i><span>Clear All </span></a></div>
                    </div>
                    <div id="court" class="filter-w"></div>
                    <div id="benchresult" class="filter-w collapsed"></div>
                    <div id="yearfilter" class="filter-w collapsed"></div>
                    <div id="decision" class="filter-w collapsed"></div>
                    <div id="partyfilter" class="filter-w collapsed"></div>
                    <div id="sectionfilter" class="filter-w"></div>
                  </div>
              </div> --}}
        {{-- </div> --}}

        {{-- <div class="col-md-9">
          <u><h5><b>Searched Results</b></h5></u>
            @foreach ($posts as $post)
            <div class="search-well">
              <h5 style="color:blue;"><b>{{ $post->post_act }}</b></h5>
              <a href="/new-laws/content/{{$post->id}}" target="_blank"><b>{{ $post->section }}</b></a>
              <br><br>
              {!! $post->content !!}
            </div>
            <br>
            @endforeach
        </div>
         
      </div>        

    </div>  --}}
         
 








{{-- @foreach ($regulations as $regulation)
                <h5 style="color:blue;"><b>{{ $regulation->regulation_title }}</b></h5>
                <a href="/new-laws/regulation_act/content/{{$regulation->id}}" target="_blank"><b>{{ $regulation->section }}</b></a>
                <br><br>
                {{ Str::limit($regulation->content, 470, '...') }}
                <hr>
            @endforeach

            @foreach ($amends as $amend)
                <h5 style="color:blue;"><b>{{ $amend->act_title }}</b></h5>
                <a href="/new-laws/amended_acts/content/{{$amend->id}}" target="_blank"><b>{{ $amend->section }}</b></a>
                <br><br>
                {{ Str::limit($amend->content, 470, '...') }}
                <hr>
            @endforeach

            @foreach ($amends_regs as $amends_reg)
                <h5 style="color:blue;"><b>{{ $amends_reg->title }}</b></h5>
                <a href="/new-laws/amended_regulation_acts/content/{{$amends_reg->id}}" target="_blank"><b>{{ $amends_reg->section }}</b></a>
                <br><br>
                {{ Str::limit($amends_reg->content, 470, '...') }}
            @endforeach --}}