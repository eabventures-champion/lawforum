{{-- FOR CONSTITUTIONAL ACTS --}}
@if($order_by_act->act_group == 'Judiciary')
    <a href="/new-laws/constitutional-acts-table-of-content/{{$order_by_act->act_group}}/{{$order_by_act->act_title}}/{{$order_by_act->act_id}}" target="_blank">{{$order_by_act->act_title}}</a>
        
    
        {{-- FOR ACTS OF PARLIAMENT --}}
        @elseif($order_by_act->act_group == 'Acts of Parliament')
            <a href="/new-laws/table-of-content/{{$order_by_act->act_group}}/{{$order_by_act->act_title}}/{{$order_by_act->act_id}}" target="_blank">{{$order_by_act->act_title}}</a>


        {{-- REGULATIONS --}}
        @elseif($order_by_act->act_group == 'Legislative Instruments')
            <a href="/new-laws/regulation_acts_table_of_content/{{$order_by_act->act_group}}/{{$order_by_act->act_title}}/{{$order_by_act->act_id}}" target="_blank">{{$order_by_act->act_title}}</a>
         
            
        {{-- FOR PRE-LEGISLATION ACTS --}}
        @elseif($order_by_act->act_group == 'First Republic')
            <a href="/existing-laws/{{$order_by_act->act_group}}/{{$order_by_act->act_title}}/{{$order_by_act->act_id}}" target="_blank">{{$order_by_act->act_title}}</a>

        @elseif($order_by_act->act_group == 'Second Republic')
            <a href="/existing-laws/{{$order_by_act->act_group}}/{{$order_by_act->act_title}}/{{$order_by_act->act_id}}" target="_blank">{{$order_by_act->act_title}}</a>

        @elseif($order_by_act->act_group == 'Third Republic')
            <a href="/existing-laws/{{$order_by_act->act_group}}/{{$order_by_act->act_title}}/{{$order_by_act->act_id}}" target="_blank">{{$order_by_act->act_title}}</a>

        @elseif($order_by_act->act_group == 'NLC Decree')
            <a href="/existing-laws/{{$order_by_act->act_group}}/{{$order_by_act->act_title}}/{{$order_by_act->act_id}}" target="_blank">{{$order_by_act->act_title}}</a>

        @elseif($order_by_act->act_group == 'NRC Decree')
            <a href="/existing-laws/{{$order_by_act->act_group}}/{{$order_by_act->act_title}}/{{$order_by_act->act_id}}" target="_blank">{{$order_by_act->act_title}}</a>

        @elseif($order_by_act->act_group == 'SMC Decree')
            <a href="/existing-laws/{{$order_by_act->act_group}}/{{$order_by_act->act_title}}/{{$order_by_act->act_id}}" target="_blank">{{$order_by_act->act_title}}</a>

        @elseif($order_by_act->act_group == 'AFRC Decree')
            <a href="/existing-laws/{{$order_by_act->act_group}}/{{$order_by_act->act_title}}/{{$order_by_act->act_id}}" target="_blank">{{$order_by_act->act_title}}</a>
            
        @elseif($order_by_act->act_group == 'PNDC Law')
            <a href="/existing-laws/{{$order_by_act->act_group}}/{{$order_by_act->act_title}}/{{$order_by_act->act_id}}" target="_blank">{{$order_by_act->act_title}}</a>



        {{-- FOR JUDGEMENT --}}
        @elseif($order_by_act->act_group == 'Supreme-Court')
            <a href="/judgement/Ghana/{{$order_by_act->act_group}}/{{$order_by_act->act_id}}" target="_blank">{{$order_by_act->act_title}}</a>

        @elseif($order_by_act->act_group == 'Court-of-Appeal')
            <a href="/judgement/Ghana/{{$order_by_act->act_group}}/{{$order_by_act->act_id}}" target="_blank">{{$order_by_act->act_title}}</a>
                     
        @elseif($order_by_act->act_group == 'High-Court')
            <a href="/judgement/Ghana/{{$order_by_act->act_group}}/{{$order_by_act->act_id}}" target="_blank">{{$order_by_act->act_title}}</a>


        {{-- FOR EXECUTIVE ACTS --}}
        @else
            <a href="/new-laws/executive-acts-table-of-content/{{$order_by_act->act_group}}/{{$order_by_act->act_title}}/{{$order_by_act->act_id}}" target="_blank">{{$order_by_act->act_title}}</a>

@endif