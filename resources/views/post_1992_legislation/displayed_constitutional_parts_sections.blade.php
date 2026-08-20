<?php 
    $oldpart = ''; $c=1; $closure = ''; 
    $freePreviewCount = (int) \App\ReadingLimitSetting::get('free_preview_sections_count', 3);
    $readingLimitEnabled = \App\ReadingLimitSetting::get('reading_limit_enabled', '1') == '1';
?>
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="false">
            @foreach($allConstitutionalArticles as $allConstitutionalArticle)    
                    <?php
                    
                        $ids[] = $allConstitutionalArticle->id;
                        $closure = ($oldpart !== '' && $oldpart !== $allConstitutionalArticle->part)?"</div></div></div>":"";
                        if ($oldpart !== $allConstitutionalArticle->part){
                            $c++;
                            echo $closure;
                    ?>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading{{$c}}">
                    <p style="white-space:normal; line-height: 0.4cm;" class="panel-title"> 
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_{{ $c }}" aria-expanded="true" aria-controls="collapse_{{$c}}"> <b class="small">{{($allConstitutionalArticle->part == '')? 'SECTIONS':$allConstitutionalArticle->part}}</b>
                    </a>
                    </p>
                </div>
                <div id="collapse_{{$c}}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading{{$c}}">
                    <div class="panel-body" style="padding:0em;">
            <?php }
                                $oldpart = $allConstitutionalArticle->part;
            ?>
                             
                                <a data-scroll-to="body"
                                data-scroll-focus="body"
                                data-scroll-speed="400"
                                data-scroll-offset="-60" class="constitutional_content_link list-group-item" style="white-space:normal; line-height: 0.4cm;" sid="{{ $allConstitutionalArticle->id }}" data-section-index="{{ $loop->iteration }}" href="/new-laws/constitutional-acts/content/{{ $allConstitutionalArticle->id }}">
                                {{ $allConstitutionalArticle->section }}
                                @guest
                                    @if($readingLimitEnabled && $loop->iteration > $freePreviewCount)
                                        <i class="fa-solid fa-lock" style="font-size: 10px; margin-left: 6px; color: #f59e0b;" title="Locked for Guests"></i>
                                    @endif
                                @endguest
                                </a>
                                           
            @endforeach 
                    <input type="hidden" id="constitutional_act_contents" value="<?php echo json_encode($ids); ?>" /> 

                    </div>
                </div>
            </div>

        </div>

        
