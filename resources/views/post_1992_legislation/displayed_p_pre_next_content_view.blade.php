
<div style="margin-top: 0.1em;">
    
        <h4><b>{{ $allPost1992Article['section'] }}</b></h4>

    <a id="print_options" href="#">Print & Download&raquo;</a>
    <div class="menu_options pull-right" style="display: none;">
        <a href="/new-laws/pdf_content/{{$allPost1992Article['post_act']}}/{{ $allPost1992Article['id'] }}"><img alt="Brand" src="{{ asset('/logo/pdf.png') }}" style="width:1.5em;">&nbsp;PDF</a>&nbsp;&nbsp;||&nbsp;
        <a href="/new-laws/print_section_content/{{ $allPost1992Article['id'] }}" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true"></span>&nbsp;Print Preview</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    </div>
    <br>
    <div class="content">
        <p>{!! $allPost1992Article['content'] !!}</p>
    </div>

</div>





   


