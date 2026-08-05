            

<?php $oldpart = ''; $c=1; $closure = ''; ?>

<div class="panel-group table" id="accordion" role="tablist" aria-multiselectable="true">

    @foreach($allAmendedArticles as $allAmendedArticle )    
            <?php 
            
                $ids[] = $allAmendedArticle->id;
                $closure = ($oldpart !== '' && $oldpart !== $allAmendedArticle->part)?"</div></div></div>":"";
                if ($oldpart !== $allAmendedArticle->part){
                    $c++;
                    echo $closure;
            ?>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading{{$c}}">
                <p style="white-space:normal; line-height: 0.4cm;" class="panel-title"> 
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_{{ $c }}" aria-expanded="true" aria-controls="collapse_{{$c}}"><b class="small">{{
                    ($allAmendedArticle->part == '')? 'SECTIONS':$allAmendedArticle->part}}</b></a>
                </p>
            </div>

            <div id="collapse_{{$c}}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading{{$c}}">
                <div class="panel-body" style="padding:0em;">
    <?php }
                        $oldpart = $allAmendedArticle->part; ?>
                    
                        <a data-scroll-to="body"
                        data-scroll-focus="body"
                        data-scroll-speed="400"
                        data-scroll-offset="-60" class="amendments_content_link list-group-item" style="white-space:normal; line-height: 0.4cm;" sid="{{ $allAmendedArticle->id }}"  href="/new-laws/amended_acts/content/{{ $allAmendedArticle->id }}">
                        <li style="list-style: none;">{{ $allAmendedArticle->section }}</li>
                        </a>
                    
    @endforeach 
                <input type="hidden" id="amendments_act_contents" value="<?php echo json_encode($ids); ?>" />
            </div>
        </div>
    </div>

</div>

    