<div class="only_post">
  @foreach ($posts as $post)
  <div class="search-well">
    <h5 style="color:blue;"><b>{!! $post->post_act !!}</b></h5>
    {{-- <a href="/new-laws/content/{{$post->id}}" target="_blank"><b style="color:black;">{!! $post->section !!}</b></a> --}}
    <a href=""><b style="color:black;">{!! $post->section !!}</b></a>
    <br>
    {!! $post->content !!}
  </div>
  <br>
  @endforeach
</div>
    
<div class="only_regulation">
  @foreach ($regulations as $regulation)
  <div class="search-well">
    <h5 style="color:blue;"><b>{!! $regulation->regulation_title !!}</b></h5>
    <a href=""><b style="color:black;">{!! $regulation->section !!}</b></a>
    {{-- <a href="/new-laws/content/{{$regulation->id}}" target="_blank"><b style="color:black;">{!! $regulation->section !!}</b></a> --}}
    <br>
    {!! $regulation->content !!}
  </div>
  <br>
  @endforeach
</div>

<div class="only_constitutional">
  @foreach ($constitutionals as $constitutional)
  <div class="search-well">
    <h5 style="color:blue;"><b>{!! $constitutional->constitutional_act !!}</b></h5>
    <a href=""><b style="color:black;">{!! $constitutional->section !!}</b></a>
    {{-- <a href="/new-laws/content/{{$constitutional->id}}" target="_blank"><b style="color:black;">{!! $constitutional->section !!}</b></a> --}}
    <br>
    {!! $constitutional->content !!}
  </div>
  <br>
  @endforeach
</div>

<div class="only_executive">
  @foreach ($executives as $executive)
  <div class="search-well">
    <h5 style="color:blue;"><b>{!! $executive->executive_act !!}</b></h5>
    <a href=""><b style="color:black;">{!! $executive->section !!}</b></a>
    {{-- <a href="/new-laws/content/{{$executive->id}}" target="_blank"><b style="color:black;">{!! $executive->section !!}</b></a> --}}
    <br>
    {!! $executive->content !!}
  </div>
  <br>
  @endforeach
</div>
  
<div class="only_amend_acts">
  @foreach ($amends as $amend)
    <div class="search-well">
      <h5 style="color:blue;"><b>{!! $amend->act_title !!}</b></h5>
      <a href=""><b style="color:black;">{!! $amend->section !!}</b></a>
      {{-- <a href="/new-laws/amended_acts/content/{{$amend->id}}" target="_blank"><b style="color:black;">{!! $amend->section !!}</b></a> --}}
      <br>
      {!! $amend->content !!}
    </div>
    <br>
    @endforeach
</div>
    
<div class="only_amend_reg">
  @foreach ($amends_regs as $amends_reg)
  <div class="search-well">
    <h5 style="color:blue;"><b>{!! $amends_reg->title !!}</b></h5>
    <a href=""><b style="color:black;">{!! $amends_reg->section !!}</b></a>
    {{-- <a href="/new-laws/amended_regulation_acts/content/{{$amends_reg->id}}" target="_blank"><b style="color:black;">{!! $amends_reg->section !!}</b></a> --}}
    <br>
    {!! $amends_reg->content !!}
  </div>
  @endforeach
</div>
   


