            

<?php $oldpart = ''; $c=1; $closure = ''; ?>

<div class="panel-group table" id="accordion" role="tablist" aria-multiselectable="true">

@foreach($regulationsContents as $regulationContent )    
<?php 
$ids[] = $regulationContent->id;
$closure = ($oldpart !== '' && $oldpart !== $regulationContent->part)?"</div></div></div>":"";
if ($oldpart !== $regulationContent->part){
    $c++;
    echo $closure;
    ?>
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="heading{{$c}}">
            <p class="panel-title"  style="white-space:normal; line-height: 0.4cm;"> 
            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_{{ $c }}" aria-expanded="true" aria-controls="collapse_{{$c}}"><b class="small">{{
                ($regulationContent->part == '')? 'SECTIONS':$regulationContent->part}}</b></a>
            </p>
        </div>

        <div id="collapse_{{$c}}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading{{$c}}">
            <div class="panel-body" style="padding:0em;">
<?php }
                    $oldpart = $regulationContent->part; ?>
        
            <a data-scroll-to="body"
               data-scroll-focus="body"
               data-scroll-speed="400"
               data-scroll-offset="-60" class="sinlge_regulation_act_content_link list-group-item" sid="{{$regulationContent->id}}" style="white-space:normal; line-height: 0.4cm;" href="/new-laws/regulations_content/{{ $regulationContent->id }}"><li style="list-style: none;">{{ $regulationContent->section }}</li></a>
@endforeach 
<input type="hidden" id="regulation_under_act_contents" value="<?php echo json_encode($ids); ?>" />
</div>
</div>
</div>

</div>

    