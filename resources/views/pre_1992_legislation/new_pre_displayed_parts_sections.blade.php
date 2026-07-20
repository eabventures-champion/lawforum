            

<?php $oldpart = ''; $c=1; $closure = ''; ?>

<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

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
                <span style="line-height: 0.7cm;"> 
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_{{ $c }}" aria-expanded="true" aria-controls="collapse_{{$c}}">
                    <span style="color: blue;">{{($allPre1992Article->part == '')? 'Sections':$allPre1992Article->part}}</span>
                    </a>
                </span>
            </div>

            <div id="collapse_{{$c}}" class="collapse show" role="tabpanel" aria-labelledby="heading{{$c}}">
                <div class="panel-body" style="padding:0em;">
    <?php }
                        $oldpart = $allPre1992Article->part; ?>
            <ul>
                <li style="list-style: none !important;">
                <a data-scroll-to="body"
                data-scroll-focus="body"
                data-scroll-speed="400"
                data-scroll-offset="-60" class="pre_content_link" sid="{{ $allPre1992Article->id }}"  href="/pre_1992_legislation/content/{{ $allPre1992Article->id }}">
                <span>{{ $allPre1992Article->section }}</span>
                </a> 
                </li>
            </ul>     
            
    @endforeach 
        <input type="hidden" id="pre_act_contents" value="<?php echo json_encode($ids); ?>" />
            </div>
        </div>
    </div>

</div>

    