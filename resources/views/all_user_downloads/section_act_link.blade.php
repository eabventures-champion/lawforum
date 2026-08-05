@if($order_by_section->act_group == 'Judiciary')
        <a href="/post-1992-legislation/constitutional-acts-table-of-content/{{$order_by_section->act_group}}/{{$order_by_section->act_title}}/{{$order_by_section->act_id}}" target="_blank">{{$order_by_section->act_section}}</a>
        <br>{{$order_by_section->act_title}}

        @elseif($order_by_section->act_group == 'Acts of Parliament')
            <a href="/post-1992-legislation/table-of-content/{{$order_by_section->act_group}}/{{$order_by_section->act_title}}/{{$order_by_section->act_id}}" target="_blank">{{$order_by_section->act_section}}</a>
            <br>{{$order_by_section->act_title}}

        @elseif($order_by_section->act_group == 'Legislative Instruments')
            <a href="/post_1992_legislation/regulation_acts_table_of_content/{{$order_by_section->act_group}}/{{$order_by_section->act_title}}/{{$order_by_section->act_id}}" target="_blank">{{$order_by_section->act_section}}</a>
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
            <a href="/post-1992-legislation/executive-acts-table-of-content/{{$order_by_section->act_group}}/{{$order_by_section->act_title}}/{{$order_by_section->act_id}}" target="_blank">{{$order_by_section->act_section}}</a>
            <br>{{$order_by_section->act_title}}

@endif