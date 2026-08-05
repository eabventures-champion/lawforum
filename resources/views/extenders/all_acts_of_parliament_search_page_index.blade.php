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
            <h5 style="color:blue;">Acts of Parliament Search</h5><hr>
            <span style="color:blue;">Filter Options</span>
            <p class="small" style="color:blue;"><b><span style="color:red;">{{number_format($posts_count)}}</span>&nbsp;Results Found&nbsp;for&nbsp;<span style="color:red;">"{{$query}}"</span></b></p>
          </div>
        </div>
      </div>

      <div class="col-md-9">
        <div><br></div>
            @foreach ($posts as $post)
                <div class="search-well">
                    <h5 style="color:blue;"><b>{!! $post->post_act !!}</b></h4>
                    <b>{!! $post->section !!}</b>
                {{-- <a href="/new-laws/content/{{$single_post_act->id}}" target="_blank"><b>{!! $single_post_act->section !!}</b></a> --}}
                <br><br>
                {!! $post->content !!}
                </div>
                <br>
            @endforeach                                     
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

@endsection

    