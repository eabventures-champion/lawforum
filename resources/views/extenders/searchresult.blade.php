{{-- @foreach($posts as $post)
    {{$post->part}}
@endforeach
{{ $posts->links() }} --}}

<div class="">
    @foreach ($posts as $post)
    <div class="search-well">
      <h5 style="color:blue;"><b>{{ $post->post_act }}</b></h5>
      <a href="/new-laws/content/{{$post->id}}" target="_blank"><b>{{ $post->section }}</b></a>
      <br><br>
      {!! $post->content !!}
    </div>
    <br>
    @endforeach
    <div>{!! $posts->links() !!}</div>
</div>