<table class="table table-striped table-condensed" id="amend_datatable">
    <thead>
        <tr>
            <th>Amendments</th>
            <th>Year</th>
        </tr>
    </thead>
    <tbody>
    @foreach($amendedRegulationActs as $amendedRegulationAct)
        <tr>
            <td>
                <a class="amended_for_regulation_link" href="/new-laws/amended_regulation_act_table_of_content/{{$amendedRegulationAct->act_category}}/{{$amendedRegulationAct->title}}/{{ $amendedRegulationAct->id }}"><li style="list-style: none;">{{ $amendedRegulationAct['title'] }}</li></a>
            </td> 
            <td>{{ $amendedRegulationAct->year }}</td>  
        </tr>
    @endforeach
    </tbody>
</table>




            


                