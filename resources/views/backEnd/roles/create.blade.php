@extends('layout.app')
@section('title')
Ajout role
@stop

@section('content')
<div class="panel panel-default">
        <div class="panel-heading">Nouvau role</div>

        <div class="panel-body">

    {!! Form::open(['url' => 'role', 'class' => 'form-horizontal']) !!}

            <div class="form-group {{ $errors->has('slug') ? 'has-error' : ''}}">
                {!! Form::label('slug', 'Identifiant', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('slug', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('slug', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                {!! Form::label('name', 'Libellé', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('name', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit('Enregistrer', ['class' => 'btn btn-success form-control']) !!}
        </div>
            <a href="{{route('role.index')}}" class="btn btn-default">Retour</a>
    </div>
    </div>
    </div>
    {!! Form::close() !!}

@endsection