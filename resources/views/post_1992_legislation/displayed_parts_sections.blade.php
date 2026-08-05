{{-- Accordion for sections --}}

<?php $oldpart = ''; $c=1; $closure = ''; ?>
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="false">
            @foreach($allPost1992Articles as $allPost1992Article )    
                    <?php
                    
                        $ids[] = $allPost1992Article->id;
                        $closure = ($oldpart !== '' && $oldpart !== $allPost1992Article->part)?"</div></div></div>":"";
                        if ($oldpart !== $allPost1992Article->part){
                            $c++;
                            echo $closure;
                    ?>
            <div class="panel panel-default">
                {{-- show the Parts --}}
                <div class="panel-heading" role="tab" id="heading{{$c}}">
                    <span style="line-height: 0.7cm;"> 
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_{{ $c }}" aria-expanded="true" aria-controls="collapse_{{$c}}">
                            <span style="color: blue;">{{($allPost1992Article->part == '')? 'Sections':$allPost1992Article->part}}</span>
                        </a>
                    </span>
                </div>

                {{-- show the sections --}}
                <div id="collapse_{{$c}}" class="collapse show" role="tabpanel" aria-labelledby="heading{{$c}}">
                    <div class="panel-body" style="padding:0em;">
            <?php }
                                $oldpart = $allPost1992Article->part;
            ?>
                             <ul>
                                 <li>
                                    <a data-scroll-to="body"
                                    data-scroll-focus="body"
                                    data-scroll-speed="400"
                                    data-scroll-offset="-60" class="content_link" sid="{{ $allPost1992Article->id }}"  href="/new-laws/content/{{ $allPost1992Article->id }}">
                                    <span style="color:black;">{{ $allPost1992Article->section }}</span>
                                    </a>
                                 </li>
                             </ul>
                                           
            @endforeach 
                    <input type="hidden" id="act_contents" value="<?php echo json_encode($ids); ?>" /> 

                    </div>
                </div>
            </div>

        </div>

        {{-- data-scroll-to="body"
        data-scroll-focus="body"
        data-scroll-speed="400"
        data-scroll-offset="-60"  --}}

        
