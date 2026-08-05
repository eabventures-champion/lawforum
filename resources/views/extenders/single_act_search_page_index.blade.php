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
}#title{
color: green;
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
                    <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                </span>
          </div>
        </form>       
      </div>
      <div class="col-md-2" style="margin-top:25px;">
      <p style="color:blue;"><b class="hidden">Found: {{$single_post_acts_count}} Results</b></p>
      </div>
    
  </div>

  <div class="row">
    {{-- <div class="wrapper"> --}}

      <div class="col-md-3">
        <div class="sidebar">
          <div class="search-well-filter">
            <p class="small" style="color:blue;"><b><span style="color:red;">{{number_format($single_post_acts_count)}}</span>&nbsp;Results Found&nbsp;for&nbsp;<span style="color:red;">"{{$query}}"</span></b></p>
            
            {{-- @foreach ()
                <div class="custom-control custom-radio">
                    <input type="radio" class="custom-control-input all1" id="defaultChecked" name="act-type" value="All" checked>
                    <span class="small"><label class="custom-control-label" for="defaultChecked">{!! $single_post_act->post_act !!}</label>&nbsp;<span class="badge"></span></span>
                </div>
            @endforeach --}}
            {{-- <p style="color:blue;">Temporary Side bar</p>
            <div class="custom-control custom-radio">
              <input type="radio" class="custom-control-input all1" id="defaultChecked" name="act-type" value="All" checked>
              <label class="custom-control-label" for="defaultChecked">All 4th Republic Laws</label>&nbsp;<span class="badge">{{$total_count}}</span>
            </div>
            <br>
            <div class="custom-control custom-radio">
              <input type="radio" class="custom-control-input post1" id="defaultUnchecked" name="act-type" value="Post">
              <label class="custom-control-label" for="defaultUnchecked">Acts of Parliament</label>&nbsp;<span class="badge">{{$posts_count}}</span>
            </div>
            <br>
            <div class="custom-control custom-radio">
              <input type="radio" class="custom-control-input reg1" id="defaultUnchecked" name="act-type" value="Regulation">
              <label class="custom-control-label" for="defaultUnchecked">Legislative Instruments</label>&nbsp;<span class="badge">{{$regulations_count}}</span>
            </div>
            <br>
            <div class="custom-control custom-radio">
              <input type="radio" class="custom-control-input amend_act1" id="defaultUnchecked" name="act-type" value="Amend_Act">
              <label class="custom-control-label" for="defaultUnchecked">Amended Acts</label>&nbsp;<span class="badge">{{$amends_count}}</span>
            </div>
            <br>

              <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input amend_reg1" id="defaultUnchecked" name="act-type" value="Amend_Regulation">
                <label class="custom-control-label" for="defaultUnchecked">Amended Regulations</label>&nbsp;<span class="badge">{{$amends_regs_count}}</span>
              </div> --}}
          </div>
        </div>
      </div>

      <div class="col-md-9">
        <div class="">
          <div class="move_here hidden  top_here"><br></div>
            @foreach ($single_post_acts as $single_post_act)
            <div class="search-well only_post">
                <h4><b>{!! $single_post_act->post_act !!}</b></h4>
                <h5 style="color:blue;"><b>{!! $single_post_act->part !!}</b></h5>
              <b>{!! $single_post_act->section !!}</b>
              {{-- <a href="/new-laws/content/{{$single_post_act->id}}" target="_blank"><b>{!! $single_post_act->section !!}</b></a> --}}
              <br><br>

                {{-- {!! strrpos($post->content, $query) !!} --}}
                {{-- {{str_limit(strip_tags($post->content),100, $query)}} --}}
                {{-- {!!substr($post->content, strpos($post->content, $query) + 1)!!} --}}
                {{-- {!!substr($post->content, (strpos($post->content, $query) ?: -1) + 1)!!} --}}
                
            
              
              {{-- {!! str_limit(strip_tags(strstr($post->content,  $query, false)),600, '...' ) !!} --}}
              
            
            {!! $single_post_act->content !!}

                
                {{-- {!! strrpos($post->content, $query) !!} --}}

                {{-- show all queries in string --}}
                {{-- {!! substr_count($post->content, $query) !!}  --}}
                
            </div>
            <br>
            @endforeach

            {{-- @foreach ($regulations as $regulation)
              <div class="search-well only_regulation">
                <h5 style="color:blue;"><b>{!! $regulation->regulation_title !!}</b></h5>
                <a href="/new-laws/content/{{$regulation->id}}" target="_blank"><b>{!! $regulation->section !!}</b></a>
                <br><br>
                {!! $regulation->content !!}
              </div>
              <br>
            @endforeach

            @foreach ($amends as $amend)
            <div class="search-well only_amend_acts">
              <h5 style="color:blue;"><b>{{ $amend->act_title }}</b></h5>
              <a href="/new-laws/amended_acts/content/{{$amend->id}}" target="_blank"><b>{!! $amend->section !!}</b></a>
              <br><br>
              {!! $amend->content !!}
            </div>
            <br>
            @endforeach

            @foreach ($amends_regs as $amends_reg)
            <div class="search-well only_amend_reg">
              <h5 style="color:blue;"><b>{!! $amends_reg->title !!}</b></h5>
              <a href="/new-laws/amended_regulation_acts/content/{{$amends_reg->id}}" target="_blank"><b>{!! $amends_reg->section !!}</b></a>
              <br><br>
              {!! $amends_reg->content !!}
            </div>
            @endforeach  --}}
        </div>
      </div>

    </div>
  </div>

</div>
    
@endsection 

@section('scripts')
    
@endsection

    
         
 







