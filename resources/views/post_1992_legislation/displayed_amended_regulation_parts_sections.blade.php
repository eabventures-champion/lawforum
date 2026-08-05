            

<?php $oldpart = ''; $c=1; $closure = ''; ?>

<div class="panel-group table" id="accordion" role="tablist" aria-multiselectable="true">

    @foreach($allAmendedRegulationArticles as $allAmendedRegulationArticle )    
            <?php 
            
                $closure = ($oldpart !== '' && $oldpart !== $allAmendedRegulationArticle->part)?"</div></div></div>":"";
                if ($oldpart !== $allAmendedRegulationArticle->part){
                    $c++;
                    echo $closure;
            ?>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading{{$c}}">
                <p style="white-space:normal; line-height: 0.4cm;" class="panel-title"> 
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_{{ $c }}" aria-expanded="true" aria-controls="collapse_{{$c}}"><b class="small">{{
                    ($allAmendedRegulationArticle->part == '')? 'SECTIONS':$allAmendedRegulationArticle->part}}</b></a>
                </p>
            </div>

            <div id="collapse_{{$c}}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading{{$c}}">
                <div class="panel-body" style="padding:0em;">
    <?php }
                        $oldpart = $allAmendedRegulationArticle->part; ?>
                 
                        <a data-scroll-to="body"
                        data-scroll-focus="body"
                        data-scroll-speed="400"
                        data-scroll-offset="-60" class="amended_regulation_content_link list-group-item" style="white-space:normal; line-height: 0.4cm;" sid="{{ $allAmendedRegulationArticle->id }}"  href="/new-laws/amended_regulation_acts/content/{{ $allAmendedRegulationArticle->id }}">
                        <li style="list-style: none;">{{ $allAmendedRegulationArticle->section }}</li>
                        </a>      
                    
    @endforeach 
        
            </div>
        </div>
    </div>

</div>

    