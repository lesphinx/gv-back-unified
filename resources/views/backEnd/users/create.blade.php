@extends('layout.app')
@section('title')
Create user
@stop

@section('content')

        <div class="panel panel-default">
        <div class="panel-heading">Créer Utilisateur</div>

        <div class="panel-body">

        @if (count($errors) > 0)
                <div class="form-group">
                    <div class="col-sm-10 col-sm-offset-1">
                        <div class="alert alert-danger">
                            <strong>Upsss !</strong> Il ya une erreure...<br /><br />
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

{{ Form::open(array('url' => route('user.store'), 'class' => 'form-horizontal','files' => true)) }}
    <ul>
        <div class="form-group {{ $errors->has('first_name') ? 'has-error' : ''}}">
             {!! Form::label('first_name', 'Nom', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::text('first_name', null, ['class' => 'form-control']) !!}
                {!! $errors->first('first_name', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
       
       <div class="form-group {{ $errors->has('last_name') ? 'has-error' : ''}}">
             {!! Form::label('last_name', 'Prénom' , ['class' => 'col-md-4 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::text('last_name', null, ['class' => 'form-control']) !!}
                {!! $errors->first('last_name', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
             {!! Form::label('email', 'Email', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::text('email', null, ['class' => 'form-control']) !!}
                {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('password') ? 'has-error' : ''}}">
             {!! Form::label('password', 'Mot de Passe', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::password('password', ['class' => 'form-control']) !!}
                {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
            </div>
        </div>

        <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : ''}}">
             {!! Form::label('password_confirmation', 'Confirmation Mot de Passe', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                {!! $errors->first('password_confirmation', '<p class="help-block">:message</p>') !!}
            </div>
        </div>

        <div id="role" class="form-group {{ $errors->has('role') ? 'has-error' : ''}}">
             {!! Form::label('role','Role utilisateur', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::select('role', $roles, null, ['class' => 'form-control']) !!}
                {!! $errors->first('role', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
       
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-3">
                {!! Form::submit('Enregistrer', ['class' => 'btn btn-success form-control']) !!}
            </div>
            <a href="{{route('user.index')}}" class="btn btn-default">Liste utilisateurs</a>
        </div>
       

    </ul>
  
{{ Form::close() }}

  </div>
    </div>


@stop

@section('js')

@endsection