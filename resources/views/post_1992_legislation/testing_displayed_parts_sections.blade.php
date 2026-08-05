{{-- Accordion for sections --}}

<?php $oldpart = ''; $c=1; $closure = ''; ?>
        <div class="accordion" id="accordionExample">
            @foreach($allPost1992Articles as $allPost1992Article )    
                    <?php
                    
                        $ids[] = $allPost1992Article->id;
                        $closure = ($oldpart !== '' && $oldpart !== $allPost1992Article->part)?"</div></div></div>":"";
                        if ($oldpart !== $allPost1992Article->part){
                            $c++;
                            echo $closure;
                    ?>
            {{-- <div class=""> --}}
                {{-- show the Parts --}}
                <div class="card-header" id="heading{{$c}}">
                    <h2 style="white-space:normal; line-height: 0.4cm;" class="mb-0"> 
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse_{{ $c }}" aria-expanded="false" aria-controls="collapse_{{$c}}">
                             <b class="small">{{($allPost1992Article->part == '')? 'SECTIONS':$allPost1992Article->part}}</b>
                        </button>
                    </h2>
                </div>

                {{-- show the sections --}}
                <div id="collapse_{{$c}}" class="collapse" aria-labelledby="heading{{$c}}" data-parent="#accordionExample">
                    <div class="card-body" style="padding:0em;">
            <?php }
                                $oldpart = $allPost1992Article->part;
            ?>
                             
                                <a data-scroll-to="body"
                                data-scroll-focus="body"
                                data-scroll-speed="400"
                                data-scroll-offset="-60" class="content_link list-group-item" style="white-space:normal; line-height: 0.4cm;" sid="{{ $allPost1992Article->id }}"  href="/new-laws/content/{{ $allPost1992Article->id }}">
                                {{ $allPost1992Article->section }}
                                </a>
                                           
            @endforeach 
                    <input type="hidden" id="act_contents" value="<?php echo json_encode($ids); ?>" /> 

                    </div>
                </div>
            {{-- </div> --}}

        </div>

        
