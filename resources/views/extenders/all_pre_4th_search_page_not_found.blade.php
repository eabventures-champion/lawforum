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
            <h5 style="color:blue;">Existing Laws Search</h5><hr>
            <span style="color:blue;">Filter Options</span>
            <p class="small" style="color:blue;"><b><span style="color:red;">{{number_format($total_pre_laws)}}</span>&nbsp;Results Found&nbsp;for&nbsp;<span style="color:red;">"{{$query}}"</span></b></p><hr>
            
              <div class="custom-radio mb-2"> 
                <input type="radio" class="all1" id="all_laws" name="act-type" value="All" checked>&nbsp;All&nbsp;<span class="badge badge-secondary">{{$total_pre_laws}}</span>
              </div>
              
              <div class="custom-radio mb-2">
                <input type="radio" class="1strep1" id="1st_republic" name="act-type" value="1st_Republic">&nbsp;1st Republic Laws&nbsp;<span class="badge badge-secondary">{{$first_republic_laws_count}}</span>
              </div>

              <div class="custom-radio mb-2">
                <input type="radio" class="2ndrep1" id="2nd_republic" name="act-type" value="2nd_Republic">&nbsp;2nd Republic Laws&nbsp;<span class="badge badge-secondary">{{$second_republic_laws_count}}</span>
              </div>

              <div class="custom-radio mb-2">
                <input type="radio" class="3rdrep1" id="3rd_republic" name="act-type" value="3rd_Republic">&nbsp;3rd Republic Laws&nbsp;<span class="badge badge-secondary">{{$third_republic_laws_count}}</span>
              </div>

              <div class="custom-radio mb-2">
                <input type="radio" class="nlcd1" id="nlcd" name="act-type" value="NLCD">&nbsp;NLC Decree&nbsp;<span class="badge badge-secondary">{{$nlc_decree_laws_count}}</span>
              </div>

              <div class="custom-radio mb-2">
                <input type="radio" class="nrcd1" id="nrcd" name="act-type" value="NRCD">&nbsp;NRC Decree&nbsp;<span class="badge badge-secondary">{{$nrc_decree_laws_count}}</span>
              </div>

              <div class="custom-radio mb-2">
                <input type="radio" class="amend_reg1" id="smcd1" name="act-type" value="SMCD">&nbsp;SMC Decree&nbsp;<span class="badge badge-secondary">{{$smc_decree_laws_count}}</span>
              </div>

              <div class="custom-radio mb-2">
                <input type="radio" class="afrcd1" id="afrcd" name="act-type" value="AFRCD">&nbsp;AFRC Decree&nbsp;<span class="badge badge-secondary">{{$afrc_decree_laws_count}}</span>
              </div>

              <div class="custom-radio mb-2">
                <input type="radio" class="pndc1" id="pndc" name="act-type" value="PNDC">&nbsp;PNDC Law&nbsp;<span class="badge badge-secondary">{{$pndc_laws_count}}</span>
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
  if ( {{$total_pre_laws}} == 0 ) {
    document.getElementById("all_laws").disabled = true;
    document.getElementById("1st_republic").disabled = true;
    document.getElementById("2nd_republic").disabled = true;
    document.getElementById("3rd_republic").disabled = true;
    document.getElementById("nlcd").disabled = true;
    document.getElementById("nrcd").disabled = true;
    document.getElementById("smcd").disabled = true;
    document.getElementById("afrcd").disabled = true;
    document.getElementById("pndc").disabled = true;
  }
</script>

@endsection

    