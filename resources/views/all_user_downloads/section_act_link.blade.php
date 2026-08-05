@if($order_by_section->act_group == 'Judiciary')
        <a href="/new-laws/constitutional-acts-table-of-content/{{$order_by_section->act_group}}/{{$order_by_section->act_title}}/{{$order_by_section->act_id}}" target="_blank">{{$order_by_section->act_section}}</a>
        <br>{{$order_by_section->act_title}}

        @elseif($order_by_section->act_group == 'Acts of Parliament')
            <a href="/new-laws/table-of-content/{{$order_by_section->act_group}}/{{$order_by_section->act_title}}/{{$order_by_section->act_id}}" target="_blank">{{$order_by_section->act_section}}</a>
            <br>{{$order_by_section->act_title}}

        @elseif($order_by_section->act_group == 'Legislative Instruments')
            <a href="/new-laws/regulation_acts_table_of_content/{{$order_by_section->act_group}}/{{$order_by_section->act_title}}/{{$order_by_section->act_id}}" target="_blank">{{$order_by_section->act_section}}</a>
            <br>{{$order_by_section->act_title}}

        @elseif($order_by_section->act_group == 'First Republic')
            <a href="/existing-laws/{{$order_by_section->act_group}}/{{$order_by_section->act_title}}/{{$order_by_section->act_id}}" target="_blank">{{$order_by_section->act_section}}</a>
            <br>{{$order_by_section->act_title}}

        @elseif($order_by_section->act_group == 'Second Republic')
            <a href="/existing-laws/{{$order_by_section->act_group}}/{{$order_by_section->act_title}}/{{$order_by_section->act_id}}" target="_blank">{{$order_by_section->act_section}}</a>
            <br>{{$order_by_section->act_title}}

        @elseif($order_by_section->act_group == 'Third Republic')
            <a href="/existing-laws/{{$order_by_section->act_group}}/{{$order_by_section->act_title}}/{{$order_by_section->act_id}}" target="_blank">{{$order_by_section->act_section}}</a>
            <br>{{$order_by_section->act_title}}

        @elseif($order_by_section->act_group == 'NLC Decree')
            <a href="/existing-laws/{{$order_by_section->act_group}}/{{$order_by_section->act_title}}/{{$order_by_section->act_id}}" target="_blank">{{$order_by_section->act_section}}</a>
            <br>{{$order_by_section->act_title}}

        @elseif($order_by_section->act_group == 'NRC Decree')
            <a href="/existing-laws/{{$order_by_section->act_group}}/{{$order_by_section->act_title}}/{{$order_by_section->act_id}}" target="_blank">{{$order_by_section->act_section}}</a>
            <br>{{$order_by_section->act_title}}
            
        @elseif($order_by_section->act_group == 'SMC Decree')
            <a href="/existing-laws/{{$order_by_section->act_group}}/{{$order_by_section->act_title}}/{{$order_by_section->act_id}}" target="_blank">{{$order_by_section->act_section}}</a>
            <br>{{$order_by_section->act_title}}

        @elseif($order_by_section->act_group == 'AFRC Decree')
            <a href="/existing-laws/{{$order_by_section->act_group}}/{{$order_by_section->act_title}}/{{$order_by_section->act_id}}" target="_blank">{{$order_by_section->act_section}}</a>
            <br>{{$order_by_section->act_title}}

        @elseif($order_by_section->act_group == 'PNDC Law')
            <a href="/existing-laws/{{$order_by_section->act_group}}/{{$order_by_section->act_title}}/{{$order_by_section->act_id}}" target="_blank">{{$order_by_section->act_section}}</a>
            <br>{{$order_by_section->act_title}}

        @else
            <a href="/new-laws/executive-acts-table-of-content/{{$order_by_section->act_group}}/{{$order_by_section->act_title}}/{{$order_by_section->act_id}}" target="_blank">{{$order_by_section->act_section}}</a>
            <br>{{$order_by_section->act_title}}

@endif