@extends('templates/main')

@section('content')
    <dl>
    <dt>{{$schema->getTableDisplay()}} ID</dt><dd>{{$item->id}}</dt>
    <dt>Global Object ID</dt><dd>{{$item->oid}}</dd>

    {{-- Show the editable fields --}}
    @foreach($schema->getFillableFields() as $field)
        <dt>
            {{ $field['display'] }}
        </dt>
        <dd>
            {{ $item->$field['name'] }}
        </dd>
    @endforeach

    <p>
        {{ Form::button('<i class="icon-long-arrow-left icon-large"></i> Return to Index',
            array('type' => 'submit', 'form'=>'gotoIndex', 'class' => 'btn btn-primary')) }}
    </p>

    {{ Form::open(array('url'=>URL::action($schema->getController().'@index'), 
        'method'=>'GET', 'id'=>'gotoIndex', 'hidden'=>'hidden'))}}
    {{ Form::close() }}

@stop
