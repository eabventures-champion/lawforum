{{-- FOR CONSTITUTIONAL ACTS --}}
@if($order_by_act->act_group == 'Judiciary')
    <a href="/post-1992-legislation/constitutional-acts/pdf-full-act-content/{{$order_by_act->act_group}}/{{$order_by_act->act_title}}/{{$order_by_act->act_id}}" class="btn btn-sm btn-outline-secondary">
        <i class="fa fa-cloud-download" aria-hidden="true"></i>
    </a>


        {{-- FOR ACTS OF PARLIAMENT --}}
        @elseif($order_by_act->act_group == 'Acts of Parliament')
            <a href="/post-1992-legislation/1/{{$order_by_act->act_group}}/{{$order_by_act->act_title}}/pdf-view/{{$order_by_act->act_id}}" class="btn btn-sm btn-outline-secondary">
                <i class="fa fa-cloud-download" aria-hidden="true"></i>
            </a>


        {{-- REGULATIONS --}}
        @elseif($order_by_act->act_group == 'Legislative Instruments')
        <a href="/post_1992_legislation/pdf/regulation/expanded/{{$order_by_act->act_group}}/{{$order_by_act->act_title}}/{{$order_by_act->act_id}}" class="btn btn-sm btn-outline-secondary">
            <i class="fa fa-cloud-download" aria-hidden="true"></i>
        </a>


        {{-- FOR PRE-LEGISLATION ACTS --}}
        @elseif($order_by_act->act_group == 'First Republic')
            <a href="/existing-laws/1/{{$order_by_act->act_group}}/{{$order_by_act->act_title}}/pdf_view/{{ $order_by_act->act_id }}" class="btn btn-sm btn-outline-secondary">
                <i class="fa fa-cloud-download" aria-hidden="true"></i>
            </a>

        @elseif($order_by_act->act_group == 'Second Republic')
            <a href="/existing-laws/1/{{$order_by_act->act_group}}/{{$order_by_act->act_title}}/pdf_view/{{ $order_by_act->act_id }}" class="btn btn-sm btn-outline-secondary">
                <i class="fa fa-cloud-download" aria-hidden="true"></i>
            </a>

        @elseif($order_by_act->act_group == 'Third Republic')
            <a href="/existing-laws/1/{{$order_by_act->act_group}}/{{$order_by_act->act_title}}/pdf_view/{{ $order_by_act->act_id }}" class="btn btn-sm btn-outline-secondary">
                <i class="fa fa-cloud-download" aria-hidden="true"></i>
            </a>

        @elseif($order_by_act->act_group == 'NLC Decree')
            <a href="/existing-laws/1/{{$order_by_act->act_group}}/{{$order_by_act->act_title}}/pdf_view/{{ $order_by_act->act_id }}" class="btn btn-sm btn-outline-secondary">
                <i class="fa fa-cloud-download" aria-hidden="true"></i>
            </a>

        @elseif($order_by_act->act_group == 'NRC Decree')
            <a href="/existing-laws/1/{{$order_by_act->act_group}}/{{$order_by_act->act_title}}/pdf_view/{{ $order_by_act->act_id }}" class="btn btn-sm btn-outline-secondary">
                <i class="fa fa-cloud-download" aria-hidden="true"></i>
            </a>

        @elseif($order_by_act->act_group == 'SMC Decree')
            <a href="/existing-laws/1/{{$order_by_act->act_group}}/{{$order_by_act->act_title}}/pdf_view/{{ $order_by_act->act_id }}" class="btn btn-sm btn-outline-secondary">
                <i class="fa fa-cloud-download" aria-hidden="true"></i>
            </a>

        @elseif($order_by_act->act_group == 'AFRC Decree')
            <a href="/existing-laws/1/{{$order_by_act->act_group}}/{{$order_by_act->act_title}}/pdf_view/{{ $order_by_act->act_id }}" class="btn btn-sm btn-outline-secondary">
                <i class="fa fa-cloud-download" aria-hidden="true"></i>
            </a>

        @elseif($order_by_act->act_group == 'PNDC Law')
            <a href="/existing-laws/1/{{$order_by_act->act_group}}/{{$order_by_act->act_title}}/pdf_view/{{ $order_by_act->act_id }}" class="btn btn-sm btn-outline-secondary">
                <i class="fa fa-cloud-download" aria-hidden="true"></i>
            </a>


        {{-- FOR JUDGEMENT --}}
        @elseif($order_by_act->act_group == 'Supreme-Court')
            <a href="/judgement/1/case_law/pdf_view/{{$order_by_act->act_title}}/{{ $order_by_act->act_id }}" class="btn btn-sm btn-outline-secondary">
                <i class="fa fa-cloud-download" aria-hidden="true"></i>
            </a>

        @elseif($order_by_act->act_group == 'Court-of-Appeal')
            <a href="/judgement/1/case_law/pdf_view/{{$order_by_act->act_title}}/{{ $order_by_act->act_id }}" class="btn btn-sm btn-outline-secondary">
                <i class="fa fa-cloud-download" aria-hidden="true"></i>
            </a>

        @elseif($order_by_act->act_group == 'High-Court')
            <a href="/judgement/1/case_law/pdf_view/{{$order_by_act->act_title}}/{{ $order_by_act->act_id }}" class="btn btn-sm btn-outline-secondary">
                <i class="fa fa-cloud-download" aria-hidden="true"></i>
            </a>


        {{-- FOR EXECUTIVE ACTS --}}
        @else
            <a href="/post-1992-legislation/executive-acts/pdf-full-act-content/{{$order_by_act->act_group}}/{{$order_by_act->act_title}}/{{$order_by_act->act_id}}" class="btn btn-sm btn-outline-secondary">
                <i class="fa fa-cloud-download" aria-hidden="true"></i>
            </a>

@endif