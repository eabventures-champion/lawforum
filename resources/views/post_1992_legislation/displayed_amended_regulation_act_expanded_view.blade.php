
<div>
{{--
<div class="header_only" style="margin-bottom: 5px;">
    <p><b>{{ $amendedRegulationAct['title'] }}</b></p>
</div>
--}}

<div style="margin-bottom: 5px;">
      <a class="pull-right" id="print_options" href="#">Print Options</a>
      <div class="menu_options pull-right" style="display: none;">
          <a href="/new-laws/pdf_expanded_regulation_amended_act/content/{{$amendedRegulationAct['act_category']}}/{{$amendedRegulationAct['title']}}/{{ $amendedRegulationAct['id'] }}"><img alt="Brand" src="{{ asset('/logo/pdf.png') }}" style="width:1.5em;">&nbsp;PDF</a>&nbsp;&nbsp;||&nbsp;
          <a href="/new-laws/plain_expanded_regulation_amended_act/content/{{$amendedRegulationAct['act_category']}}/{{$amendedRegulationAct['title']}}/{{ $amendedRegulationAct['id'] }}" target="_blank">Plain View</a>&nbsp;&nbsp;||&nbsp;
          <a href="/new-laws/print_expanded_regulation_amended_act/content/{{$amendedRegulationAct['act_category']}}/{{$amendedRegulationAct['title']}}/{{ $amendedRegulationAct['id'] }}" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true"></span>&nbsp;Print Preview</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      </div>
</div>

<div class="content">	
    <label>Preamble</label>: <p><b>{{ $amendedRegulationAct['preamble'] }}</b></p>
      <hr>
    @foreach($allAmendedRegulationArticles as $allAmendedRegulationArticle)
      <h4><b>{!! $allAmendedRegulationArticle->section !!}</b></h4>
        {!! $allAmendedRegulationArticle->content !!}
      <hr><br>
    @endforeach
</div>

</div









