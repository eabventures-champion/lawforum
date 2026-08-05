{{-- @extends('extenders.main') --}}
@extends('layouts.app_search_only')

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
  padding: .1px; */
  /* margin-top: 20px;
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
.back-to-top {
  position: sticky;
  bottom: 80px;
  left: 1295px;
}
</style>
@endsection

@section('content')

<div class="container-fluid mt-customised">
  <div class="row">
      <div class="col-md-3 mx-auto">
        <div class="sidebar">
          <div class="search-well-filter">
            <h5 style="color:blue;">All New Laws Search</h5><hr>
            <span style="color:blue;">Filter Options</span>
            <p class="small" style="color:blue;"><b><span style="color:red;">{{number_format($total_posts_count)}}</span>&nbsp;Results Found&nbsp;for&nbsp;<span style="color:red;">"{{$query}}"</span></b></p><hr>
            
              <div class="custom-radio mb-2"> 
                <input type="radio" class="all1" id="all_posts" name="act-type" value="All" checked>&nbsp;All&nbsp;<span class="badge badge-secondary">{{$total_posts_count}}</span>
              </div>
              
              <div class="custom-radio mb-2">
                <input type="radio" class="post1" id="for_post" name="act-type" value="Post">&nbsp;Acts of Parliament&nbsp;<span class="badge badge-secondary">{{$posts_count}}</span>
              </div>

              <div class="custom-radio mb-2">
                <input type="radio" class="reg1" id="for_regulations" name="act-type" value="Regulation">&nbsp;Legislative Instruments&nbsp;<span class="badge badge-secondary">{{$regulations_count}}</span>
              </div>

              <div class="custom-radio mb-2">
                <input type="radio" class="consti1" id="for_constitutional" name="act-type" value="Constitutional">&nbsp;Constitutional Instruments&nbsp;<span class="badge badge-secondary">{{$constitutional_count}}</span>
              </div>

              <div class="custom-radio mb-2">
                <input type="radio" class="exe1" id="for_executive" name="act-type" value="Executive">&nbsp;Executive Instruments&nbsp;<span class="badge badge-secondary">{{$executives_count}}</span>
              </div>

              <div class="custom-radio mb-2">
                <input type="radio" class="amend_act1" id="for_amended_acts" name="act-type" value="Amend_Act">&nbsp;Amended Acts&nbsp;<span class="badge badge-secondary">{{$amends_count}}</span>
              </div>

              <div class="custom-radio mb-2">
                <input type="radio" class="amend_reg1" id="for_amended_regulation" name="act-type" value="Amend_Regulation">&nbsp;Amended Regulations&nbsp;<span class="badge badge-secondary">{{$amends_regs_count}}</span>
              </div>

            </div>
        </div>
      </div>

      <div class="col-md-9">
          <div class="move_here hidden"><br></div>
          @include('extenders.query_post_1992_legislation')                                          
      </div>
      <a id="back-to-top" href="#" class="back-to-top">
        <svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-arrow-up-circle-fill" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-10.646.354a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 6.207V11a.5.5 0 0 1-1 0V6.207L5.354 8.354z"/>
        </svg>
      </a>
  </div>
</div>
    
@endsection 

@section('scripts')

<script>
  $(document).ready(function(){
		// scroll body to 0px on click
		$('#back-to-top').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 400);
			return false;
		});
  });
</script>

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

    $(function () {
      $("input[name=act-type]:radio").click(function () {
        
        if ($('input[name=act-type]:checked').val() == "All") {
          $('.all1').click(function() {

          $('html, body').animate({
            scrollTop: $("body").offset().top
          }, 1000)
          });
          $('.only_post').fadeIn();
          $('.only_amend_acts').fadeIn();
          $('.only_regulation').fadeIn();
          $('.only_constitutional').fadeIn();
          $('.only_executive').fadeIn();
          $('.only_amend_reg').fadeIn();

        } else if ($('input[name=act-type]:checked').val() == "Post") {
          $('.post1').click(function() {

          $('html, body').animate({
            scrollTop: $("body").offset().top
          }, 1000)
          });

          $('.only_post').fadeIn().insertAfter( ".move_here" );
          $('.only_amend_acts').fadeOut();
          $('.only_regulation').fadeOut();
          $('.only_amend_reg').fadeOut();
          $('.only_constitutional').fadeOut();
          $('.only_executive').fadeOut();


        }
        else if ($('input[name=act-type]:checked').val() == "Regulation") {
          // $('.only_regulation').fadeIn().insertAfter( ".move_here" ).scrollTo('.top_here');
          $('.reg1').click(function() {

            $('html, body').animate({
              scrollTop: $("body").offset().top
            }, 1000)
          });

            $('.only_regulation').fadeIn().insertAfter( ".move_here" );
            $('.only_post').fadeOut();
            $('.only_amend_acts').fadeOut();
            $('.only_amend_reg').fadeOut();
            $('.only_constitutional').fadeOut();
            $('.only_executive').fadeOut();
        }
        else if ($('input[name=act-type]:checked').val() == "Constitutional") {
          $('.consti1').click(function() {

            $('html, body').animate({
              scrollTop: $("body").offset().top
            }, 1000)
          });

            $('.only_constitutional').fadeIn().insertAfter( ".move_here" );
            $('.only_post').fadeOut();
            $('.only_regulation').fadeOut();
            $('.only_amend_acts').fadeOut();
            $('.only_amend_reg').fadeOut();
            $('.only_executive').fadeOut();
        }
        else if ($('input[name=act-type]:checked').val() == "Executive") {
          $('.exe1').click(function() {

            $('html, body').animate({
              scrollTop: $("body").offset().top
            }, 1000)
          });

            $('.only_executive').fadeIn().insertAfter( ".move_here" );
            $('.only_post').fadeOut();
            $('.only_regulation').fadeOut();
            $('.only_amend_acts').fadeOut();
            $('.only_amend_reg').fadeOut();
            $('.only_constitutional').fadeOut();
        }
        else if ($('input[name=act-type]:checked').val() == "Amend_Act") {
          $('.amend_act1').click(function() {

          $('html, body').animate({
            scrollTop: $("body").offset().top
          }, 1000)
          });

          $('.only_amend_acts').fadeIn().insertAfter( ".move_here" );
          $('.only_post').fadeOut();
          $('.only_regulation').fadeOut();
          $('.only_amend_reg').fadeOut();
          $('.only_constitutional').fadeOut();
          $('.only_executive').fadeOut();


        }
        else if ($('input[name=act-type]:checked').val() == "Amend_Regulation") {
          $('.amend_reg1').click(function() {

          $('html, body').animate({
            scrollTop: $("body").offset().top
          }, 1000)
          });

          $('.only_amend_reg').fadeIn().insertAfter( ".move_here" );
          $('.only_post').fadeOut();
          $('.only_amend_acts').fadeOut();
          $('.only_regulation').fadeOut();
          $('.only_constitutional').fadeOut();
          $('.only_executive').fadeOut();

        }
      });
    });
</script>
@endsection

    