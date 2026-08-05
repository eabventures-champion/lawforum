            

<?php $oldpart = ''; $c=1; $closure = ''; ?>

<div class="panel-group table" id="accordion" role="tablist" aria-multiselectable="true">

    @foreach($allPre1992Articles as $allPre1992Article )    
            <?php 
            
                $ids[] = $allPre1992Article->id;
                $closure = ($oldpart !== '' && $oldpart !== $allPre1992Article->part)?"</div></div></div>":"";
                if ($oldpart !== $allPre1992Article->part){
                    $c++;
                    echo $closure;
            ?>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading{{$c}}">
                <p class="panel-title" style="white-space:normal; line-height: 0.4cm;"> 
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_{{ $c }}" aria-expanded="true" aria-controls="collapse_{{$c}}"><b class="small">{{
                    ($allPre1992Article->part == '')? 'SECTIONS':$allPre1992Article->part}}</b></a>
                </p>
            </div>

            <div id="collapse_{{$c}}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading{{$c}}">
                <div class="panel-body" style="padding:0em;">
    <?php }
                        $oldpart = $allPre1992Article->part; ?>
            
                <a data-scroll-to="body"
                data-scroll-focus="body"
                data-scroll-speed="400"
                data-scroll-offset="-60" class="pre_content_link list-group-item" style="white-space:normal; line-height: 0.4cm;" sid="{{ $allPre1992Article->id }}"  href="/existing-laws/content/{{ $allPre1992Article->id }}">
                <li style="list-style: none;">{{ $allPre1992Article->section }}</li>
                </a>      
            
    @endforeach 
        <input type="hidden" id="pre_act_contents" value="<?php echo json_encode($ids); ?>" />
            </div>
        </div>
    </div>

</div>

    