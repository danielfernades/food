@extends('templates/main')

@section('css')
    <link rel="stylesheet" type="text/css" href="/packages/datatables/css/jquery.dataTables.css">
@stop

@section('content')
    <h1>{{ $schema->getTableDisplay() . ' List' }}</h1>
    <table id="data-table">
        <thead>
            <tr>
                @foreach($schema->getIndexFields() as $field)
                    <th>{{ $schema->getFieldParam($field, 'display') }}</th>
                @endforeach
            </tr>
        </thead>
            @foreach($items as $item)
                <tr>
                    @foreach($schema->getIndexFields() as $field)
                        <td><a href="{{ URL::action($schema->getController().'@edit', array($item->id))}}" title="Edit this record">{{ $item->$field }}</a></td>
                    @endforeach
                </tr>
            @endforeach
        <tbody>
            
        </tbody>
    </table>

    <div style="clear: both; margin: 30px 0px 60px 0px ;">
    <p><a href="{{URL::action($schema->getController().'@create')}}">Add a new {{ str_singular($schema->getTableDisplay()) }} record</a></p>
    </div>


@stop

@section('js')
    <script src="/packages/datatables/js/jquery.dataTables.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $("#data-table").dataTable({
            "iDisplayLength": 100,
        });
    });        
    </script>
@stop

