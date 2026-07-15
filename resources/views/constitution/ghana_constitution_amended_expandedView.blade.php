
<div>
    {{-- <div class="header_only" style="margin-bottom: 5px;">
        <p><b>{{ $ghana_act_amended['title'] }}</b></p>
    </div> --}}



    <div class="content">
    {!! $ghana_act_amended['preamble'] !!}
      <hr>	
    @foreach($ghanaArticlesAmendeds as $ghanaArticlesAmended)
      <h4><b>{!! $ghanaArticlesAmended->section !!}</b></h4>
        {!! $ghanaArticlesAmended->articles !!}
      <hr><br>
    @endforeach
    </div>
</div









