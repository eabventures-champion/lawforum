            

<?php $oldpart = ''; $c=1; $closure = ''; ?>

<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

    @foreach($allRegulationArticles as $allRegulationArticle )    
            <?php 
            
                $ids[] = $allRegulationArticle->id;
                $closure = ($oldpart !== '' && $oldpart !== $allRegulationArticle->part)?"</div></div></div>":"";
                if ($oldpart !== $allRegulationArticle->part){
                    $c++;
                    echo $closure;
            ?>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading{{$c}}">
                <span style="line-height: 0.7cm;"> 
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_{{ $c }}" aria-expanded="true" aria-controls="collapse_{{$c}}">
                        <span style="color: blue;">{{($allRegulationArticle->part == '')? 'Sections':$allRegulationArticle->part}}</span>
                    </a>
                </span>
            </div>

            <div id="collapse_{{$c}}" class="collapse show" role="tabpanel" aria-labelledby="heading{{$c}}">
                <div class="panel-body" style="padding:0em;">
    <?php }
                        $oldpart = $allRegulationArticle->part; ?>
                    
                            <ul>
                                <li>
                                <a data-scroll-to="body"
                                data-scroll-focus="body"
                                data-scroll-speed="400"
                                data-scroll-offset="-60" class="regulation_content_link" sid="{{ $allRegulationArticle->id }}" data-section-index="{{ $loop->iteration }}" href="/new-laws/regulation_act/content/{{ $allRegulationArticle->id }}">
                                <span style="color:black;">{{ $allRegulationArticle->section }}</span>
                                @guest
                                    @if($loop->iteration > 3)
                                        <i class="fa-solid fa-lock" style="font-size: 10px; margin-left: 6px; color: #f59e0b;" title="Locked for Guests"></i>
                                    @endif
                                @endguest
                                </a>
                            </li>
                        </ul> 
    @endforeach 
                <input type="hidden" id="regulation_act_contents" value="<?php echo json_encode($ids); ?>" />
            </div>
        </div>
    </div>

</div>

    