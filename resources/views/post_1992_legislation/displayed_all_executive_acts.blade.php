@extends('extenders.main')

@section('title', 'Executive Instruments')
@section('assets')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" href="{{ asset('css/pre_second_nav.css') }}">
    <style type="text/css">
    </style>
@endsection

@section('content')

    <div class="container-fluid content">
        <div class="row">
            <div class="col-md-9">
                <div class="shadow-background">
                <div style="padding: 15px;">
            @include('post_1992_legislation.post_1992_legislation_menu')
                <div class="row">
                    <div class="col-md-9">
                        <div class="list-group">
                            <table class="table table-striped table-condensed" id="datatable">
                                <thead>
                                    <tr>
                                        <th>Executive Instruments</th>
                                        <th>Year</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <!-- Amendments for Acts -->
                                @foreach($allExecutiveActs as $allExecutiveAct)
                                    <tr>
                                        <td>
                                            <a href="/new-laws/executive-acts-table-of-content/{{$allExecutiveAct->executive_group}}/{{ $allExecutiveAct->title }}/{{ $allExecutiveAct->id}}"><li style="list-style: none;">{{ $allExecutiveAct->title }}</li></a>
                                        </td> 
                                        <td>{{ $allExecutiveAct->year }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div> 
                    @include('post_1992_legislation.executive_container_main')
                </div> 
                </div>
                </div>
            </div>
            @include('extenders.ads')
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