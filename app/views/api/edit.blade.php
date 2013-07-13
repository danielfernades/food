@extends('templates/main')

@section('content')
    {{-- Open the form --}}
    @if(!isset($item))
        {{ var_dump($schema->getRules()) }}
        <h1>Create a new {{ str_singular($schema->getTableDisplay()) }} record</h1>
        {{ Form::open(array('url'=>URL::action( $schema->getController().'@store'), 'method'=>'POST')) }}
    @else
        {{ var_dump($schema->getRules($item->id)) }}
        <h1>Edit a {{ str_singular($schema->getTableDisplay()) }} record</h1>
        {{Form::model($item, array(
            'url'=>URL::action($schema->getController().'@update', $item->id), 
            'method'=>'PUT'))}}

        <p>{{$schema->getTableDisplay()}} ID: {{$item->id}}</p>
        <p>Global Object ID: {{$item->oid}}</p>
    @endif

    {{-- Show errors, if any came up --}}
    @include('partials/errors')


    {{-- Show the editable fields --}}
    @foreach($schema->getFillableFields() as $field)
        <p>
            {{ Form::label($field['name'], $field['display'] . ':') }}
        </p>
        <p>
            @if ($field['fillable'])
                @if( $field['type']=='String' )
                    {{ Form::input($field['name'], $field['name']) }}
                @elseif( $field['type'] == 'textarea' )
                    {{ Form::textarea($field['name']) }}
                @elseif( $field['type']=='Integer' )
                    {{ Form::input('number', $field['name']) }}
                @elseif( $field['type']=='Date' )
                    {{ Form::input('date', $field['name']) }}
                @else
                    {{ Form::input($field['name'], $field['name']) }}
                @endif
            @endif
        </p>
    @endforeach


    {{-- Write the footer to close the form --}}
    <p>
        {{ Form::button('<i class="icon-ok"></i> Save Changes', 
            array('type' => 'submit', 'class' => 'btn btn-success')) }}
        {{-- Form::button('<i class="icon-undo"></i> Reset', 
            array('type' => 'reset', 'class' => 'btn btn-primary')) --}}
        @if(isset($item))
            {{ Form::button('<i class="icon-trash icon-large"></i> Delete', 
                array('type' => 'submit', 'form'=>'delItem', 'class' => 'btn btn-danger')) }}
        @endif
    </p>
    <p>
        {{ Form::button('<i class="icon-long-arrow-left icon-large"></i> Return to Index',
            array('type' => 'submit', 'form'=>'gotoIndex', 'class' => 'btn btn-primary')) }}
    </p>
    {{ Form::close() }}

    @if(isset($item))
        {{ Form::open(array('url'=>URL::action($schema->getController().'@destroy', $item->id), 
            'method'=>'delete', 'id'=>'delItem', 'hidden'=>'hidden')) }}
        {{ Form::close() }}
    @endif

    {{ Form::open(array('url'=>URL::action($schema->getController().'@index'), 
        'method'=>'GET', 'id'=>'gotoIndex', 'hidden'=>'hidden'))}}
    {{ Form::close() }}



@stop
