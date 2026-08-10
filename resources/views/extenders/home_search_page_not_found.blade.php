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
</style>
@endsection

@section('content')

<div class="container-fluid mt-customised">
  <div class="row">
      <div class="col-md-3 mx-auto">
        <div class="sidebar">
          <div class="search-well-filter">
            <h5 style="color:blue;">All Laws Search</h5><hr>
            <span style="color:blue;">Filter Options</span>
              <p class="small" style="color:blue;"><b><span style="color:red;">{{number_format($all_total_count)}}</span>&nbsp;Results Found&nbsp;for&nbsp;<span style="color:red;">"{{$query}}"</span></b></p><hr>
            
            <div class="custom-radio mb-2"> 
              <input type="radio" class="all1" id="all_laws" name="act-type" value="All">&nbsp;All&nbsp;<span class="badge badge-secondary">{{$all_total_count}}</span>
            </div>
            
            <div class="custom-radio mb-2">
              <input type="radio" class="consti_ghana1" id="consti_ghana" name="act-type" value="Constitution_Ghana">&nbsp;Constitution(Ghana)&nbsp;<span class="badge badge-secondary">{{$total_constitution_articles_count}}</span>
            </div>

            <div class="custom-radio mb-2">
              <input type="radio" class="consti_others1" id="consti_others" name="act-type" value="Constitution_Others">&nbsp;Constitution(Countries)&nbsp;<span class="badge badge-secondary">{{$total_constitution_countries}}</span>
            </div>

            <div class="custom-radio mb-2">
              <input type="radio" class="pre_4th1" id="pre_4th" name="act-type" value="Pre_4th_Republic">&nbsp;Existing Laws&nbsp;<span class="badge badge-secondary">{{$pre_total_count}}</span>
            </div>

            <div class="custom-radio mb-2">
              <input type="radio" class="4th_rep1" id="4th_rep" name="act-type" value="4th_Republic">&nbsp;New Laws&nbsp;<span class="badge badge-secondary">{{$posts_total_count}}</span>
            </div>

            <div class="custom-radio mb-2">
              <input type="radio" class="cases1" id="case_laws" name="act-type" value="Case_Laws">&nbsp;Case Laws&nbsp;<span class="badge badge-secondary">{{$cases_total_count}}</span>
            </div>

          </div>
        </div>
      </div>

      <div class="col-md-9">
        <div class="row">
          <div class="col-md-1"></div>
          <div class="col-md-6" style="background-color: white; padding: 10px; margin-top: 80px; border: 1px solid; box-shadow: 5px 5px 5px grey">
            <center><h4>Results for <span style="color:red;">"{{$query}}"</span> not found</h4></center>    
            <center><h6>please try again with related words</h6></center>    
            <div class="col-md-5"></div>                                 
          </div>
        </div>
      </div>
  </div>

</div>
    
@endsection 

@section('scripts')
<script>
  if ( {{$all_total_count}} == 0 ) {
    document.getElementById("all_laws").disabled = true;
    document.getElementById("consti_ghana").disabled = true;
    document.getElementById("consti_others").disabled = true;
    document.getElementById("pre_4th").disabled = true;
    document.getElementById("4th_rep").disabled = true;
    document.getElementById("case_laws").disabled = true;   
  }
  
  if ( {{$posts_total_count}} == 0 ) {
    document.getElementById("4th_rep").disabled = true;   
  }
  if ( {{$cases_total_count}} == 0 ) {
    document.getElementById("case_laws").disabled = true;   
  }
  if ( {{$pre_total_count}} == 0 ) {
    document.getElementById("pre_4th").disabled = true;   
  }
  if ( {{$total_constitution_countries}} == 0 ) {
    document.getElementById("consti_others").disabled = true;   
  }
  if ( {{$total_constitution_articles_count}} == 0 ) {
    document.getElementById("consti_ghana").disabled = true;   
  }
</script>


@endsection

    