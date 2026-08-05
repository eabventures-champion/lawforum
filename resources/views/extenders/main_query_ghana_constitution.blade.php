    
    <div class="only_constitution_ghana">
        @foreach ($ghana_articles as $ghana_article)
                    <div class="search-well">
                        <h5 class="all_specific"><b>{!! $ghana_article->gh_title !!}</b></h5>
                        <h5><b>{!! $ghana_article->chapter !!}</b></h5>
                        <h5 style="color:blue;"><b>{!! $ghana_article->section !!}</b></h5>
                    {{-- <a href="/new-laws/content/{{$single_post_act->id}}" target="_blank"><b>{!! $single_post_act->section !!}</b></a> --}}
                    <br>
                    {!! $ghana_article->articles !!}
                    </div>
                    <br>
        @endforeach

        @foreach ($ghana_amended_articles as $ghana_amended_article)
        <div class="search-well">
            <h5 class="all_specific"><b>{!! $ghana_amended_article->gh_title !!}</b></h5>
            <h5><b>{!! $ghana_amended_article->chapter !!}</b></h5>
            <h5 style="color:blue;"><b>{!! $ghana_amended_article->section !!}</b></h5>
        {{-- <a href="/new-laws/content/{{$single_post_act->id}}" target="_blank"><b>{!! $single_post_act->section !!}</b></a> --}}
        <br>
        {!! $ghana_amended_article->articles !!}
        </div>
        <br>
        @endforeach
    </div>
        