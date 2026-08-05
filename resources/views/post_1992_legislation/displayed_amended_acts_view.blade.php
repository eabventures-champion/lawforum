@extends('extenders.main')

@section('assets')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
@endsection

@section('content')

@include('post_1992_legislation.post_1992_legislation_menu')

    <div class="container-fluid row-margin">
        <div class="row">
            <div class="col-md-8">
                <div class="list-group">
                    <table class="table table-striped table-condensed" id="datatable">
                        <thead>
                            <tr>
                                <th>Amended Acts</th>
                                <th>Year</th>
                            </tr>
                        </thead>
                        <tbody>
                    
                        @foreach($amendedActs as $amendedAct)
                            <tr>
                                <td>
                                    <a href="/new-laws/general_table_of_content/{{$amendedAct->post_group}}/{{ $amendedAct->title }}/{{ $amendedAct->id}}"><li style="list-style: none;">{{ $amendedAct->title }}</li></a>
                                </td> 
                                <td>{{ $amendedAct->year }}</td>
                            </tr>
                        @endforeach 
                        
                        </tbody>
                    </table>
                </div>
            </div>
                            @include('post_1992_legislation.amended_acts_container_main')
        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function(){
            $('#datatable').DataTable();
        });
    </script>
@endsection