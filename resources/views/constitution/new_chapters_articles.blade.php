            

<?php $oldchapter = ''; $c=1; $closure = ''; ?>

<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

    @foreach($constitutionContents as $constitutionContent )    
            <?php 
                $ids[] = $constitutionContent->id;
                $closure = ($oldchapter !== '' && $oldchapter !== $constitutionContent->chapter)?"</div></div></div>":"";
                if ($oldchapter !== $constitutionContent->chapter){
                    $c++;
                    echo $closure;
            ?>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading{{$c}}">
                <span style="line-height: 0.7cm;"> 
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_{{ $c }}" aria-expanded="true" aria-controls="collapse_{{$c}}">
                    <span style="color: blue;">{{($constitutionContent->chapter == '')? 'Sections':$constitutionContent->chapter}}</span>
                    </a>
                </span>
            </div>

            <div id="collapse_{{$c}}" class="collapse show" role="tabpanel" aria-labelledby="heading{{$c}}">
                <div class="panel-body" style="padding:0em;">
    <?php }
                        $oldchapter = $constitutionContent->chapter; ?>
            <ul>
                <li style="list-style: none !important;">
                    <a data-scroll-to="body"
                    data-scroll-focus="body"
                    data-scroll-speed="400"
                    data-scroll-offset="-60" class="constitution_content_link" sid="{{ $constitutionContent->id }}"  href="/constitution/Republic/constitution_content/{{ $constitutionContent->id }}">
                    <span>{{ $constitutionContent->section }}</span>
                    </a>
                </li>
            </ul>      
            
    @endforeach 
        <input type="hidden" id="constitution_act_contents" value="<?php echo json_encode($ids); ?>" />
            </div>
        </div>
    </div>

</div>

    