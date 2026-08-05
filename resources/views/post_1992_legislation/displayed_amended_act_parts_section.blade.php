            

<?php $oldpart = ''; $c=1; $closure = ''; ?>

<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

@foreach($amendedContents as $amendedContent )    
<?php 
$ids[] = $amendedContent->id;
$closure = ($oldpart !== '' && $oldpart !== $amendedContent->part)?"</div></div></div>":"";
if ($oldpart !== $amendedContent->part){
    $c++;
    echo $closure;
    ?>
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="heading{{$c}}">
            <span style="line-height: 0.7cm;"> 
            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_{{ $c }}" aria-expanded="true" aria-controls="collapse_{{$c}}">
                <span style="color: blue;">{{($amendedContent->part == '')? 'Sections':$amendedContent->part}}</span>
            </a>
            </span>
        </div>

        <div id="collapse_{{$c}}" class="collapse show" role="tabpanel" aria-labelledby="heading{{$c}}">
            <div class="panel-body" style="padding:0em;">
<?php }
                    $oldpart = $amendedContent->part; ?>
         <ul>
            <li>
            <a data-scroll-to="body"
               data-scroll-focus="body"
               data-scroll-speed="400"
               data-scroll-offset="-60" class="sinlge_amended_act_content_link" sid="{{$amendedContent->id}}" href="/new-laws/amended_act_content/{{ $amendedContent->id }}">
               <span style="color:black;">{{ $amendedContent->section }}</span>
            </a> 
            </li>
         </ul>
@endforeach 
<input type="hidden" id="amends_under_act_contents" value="<?php echo json_encode($ids); ?>" />
</div>
</div>
</div>

</div>

    