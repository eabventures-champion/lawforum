@extends('extenders.main')

@section('assets')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <style type="text/css">
        .navbar {
          min-height: 5px;
        }
        .navbar-brand {
          padding-top: 17px;
          padding-top: 17px;
          line-height: 15px;
        }
        .navbar-toggle {
          /* (80px - button height 34px) / 2 = 23px */
          margin-top: 23px;
          padding: 9px 10px !important;
        }
        @media (min-width: 768px) {
          .navbar-nav > li > a {
            /* (80px - line-height of 27px) / 2 = 26.5px */
            padding-top: 17px;
            padding-bottom: 17px;
            line-height: 15px;
          }
        }
        .content {
            padding: 0.1px;
        }
    </style>
@endsection

@section('content')

@include('post_1992_legislation.post_1992_legislation_menu')

    <div class="container-fluid content">
        <div class="row">
            <div class="col-md-7">
                <div class="list-group">
                    <table class="table table-striped table-condensed" id="datatable">
                        <thead>
                            <tr>
                                <th>Legislative Instruments</th>
                                <th>Year</th>
                            </tr>
                        </thead>
                        <tbody>
                    
                        @foreach($legislativeInstruments as $legislativeInstrument)
                            <tr>
                                <td>
                                    <a href="/new-laws/regulation_table_of_content/{{$legislativeInstrument->post_group}}/{{ $legislativeInstrument->title }}/{{ $legislativeInstrument->id}}"><li style="list-style: none;">{{ $legislativeInstrument->title }}</li></a>
                                </td> 
                                <td>{{ $legislativeInstrument->year }}</td>
                            </tr>
                        @endforeach 
                        
                        </tbody>
                    </table>
                </div>
            </div>
                            @include('post_1992_legislation.legislative_instruments_container_main')
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