


<table class="table table-striped table-condensed" id="regulated_datatable">
    <thead>
        <tr>
            <th>All Regulations on <b>{{ $allPost1992Act['title'] }}</b></th>
            <th>Year</th>
        </tr>
    </thead>
    <tbody>
        @foreach($regulationsActs as $regulationsAct)
        <tr>
            <td>
                <a href="/new-laws/regulations_table_of_content/{{$regulationsAct->act_category}}/{{$regulationsAct->title}}/{{ $regulationsAct->id }}" class="regulated_link"><li style="list-style: none;">{{ $regulationsAct->title }}</li></a>
            </td> 
            <td>{{ $regulationsAct->year }}</td>    
        </tr>
        @endforeach
    </tbody>
</table>




            


                