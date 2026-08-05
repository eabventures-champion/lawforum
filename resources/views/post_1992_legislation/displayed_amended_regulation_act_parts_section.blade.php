            

<?php $oldpart = ''; $c=1; $closure = ''; ?>

<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

@foreach($amendedRegulationContents as $amendedRegulationContent )    
<?php 
$ids[] = $amendedRegulationContent->id;
$closure = ($oldpart !== '' && $oldpart !== $amendedRegulationContent->part)?"</div></div></div>":"";
if ($oldpart !== $amendedRegulationContent->part){
    $c++;
    echo $closure;
    ?>
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="heading{{$c}}">
            <span style="line-height: 0.7cm;"> 
            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_{{ $c }}" aria-expanded="true" aria-controls="collapse_{{$c}}">
                <span style="color: blue;">{{($amendedRegulationContent->part == '')? 'Sections':$amendedRegulationContent->part}}</span>
            </a>
            </span>
        </div>

        <div id="collapse_{{$c}}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading{{$c}}">
            <div class="panel-body" style="padding:0em;">
<?php }
                    $oldpart = $amendedRegulationContent->part; ?>
            <ul>
                <li>
                    <a data-scroll-to="body"
                    data-scroll-focus="body"
                    data-scroll-speed="400"
                    data-scroll-offset="-60" class="single_amendments_to_regulation_link" sid="{{$amendedRegulationContent->id}}" href="/new-laws/amended_act_regulation_content/{{ $amendedRegulationContent->id }}">
                    <span style="color:black;">{{ $amendedRegulationContent->section }}</span>
                    </a> 
                </li>
            </ul>
                
@endforeach 
<input type="hidden" id="amends_under_regulations_contents" value="<?php echo json_encode($ids); ?>" />
</div>
</div>
</div>

</div>

    