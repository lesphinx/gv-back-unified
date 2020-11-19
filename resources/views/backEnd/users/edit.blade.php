@extends('layout.app')
@section('title')
Edition utilisateur
@stop

@section('content')
<div class="card card-default">
<div class="card-body">

<div class="panel panel-default">
   <div class="panel-heading">Editer utilisateur: {{$user->name}}</div>

     <div class="panel-body">                

    {{ Form::model($user, array('method' => 'PATCH', 'url' => route('user.update', $user->id), 'class' => 'form-horizontal', 'files' => true)) }}
      <ul>
            <div class="row form-group {{ $errors->has('first_name') ? 'has-error' : ''}}">
                 {!! Form::label('first_name', 'Nom', ['class' => 'col-md-4 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('first_name', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('first_name', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
           
           <div class="row form-group {{ $errors->has('last_name') ? 'has-error' : ''}}">
                 {!! Form::label('last_name', 'Prénom' , ['class' => 'col-md-4 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('last_name', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('last_name', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="row form-group {{ $errors->has('email') ? 'has-error' : ''}}">
                 {!! Form::label('email', 'Email', ['class' => 'col-md-4 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('email', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="row form-group {{ $errors->has('new_password') ? 'has-error' : ''}}">
                 {!! Form::label('new_password', 'Mot de passe', ['class' => 'col-md-4 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::password('new_password', ['class' => 'form-control']) !!}
                    {!! $errors->first('new_password', '<p class="help-block">:message</p>') !!}
                </div>
            </div>

            <div class="row form-group {{ $errors->has('new_password_confirmation') ? 'has-error' : ''}}">
                 {!! Form::label('new_password_confirmation', 'Confirmation Mot de passe', ['class' => 'col-md-4 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::password('new_password_confirmation', ['class' => 'form-control']) !!}
                    {!! $errors->first('new_password_confirmation', '<p class="help-block">:message</p>') !!}
                </div>
            </div>

            <div id="role" class="row form-group {{ $errors->has('role') ? 'has-error' : ''}}">
                 {!! Form::label('role','Role Utilisateur', ['class' => 'col-md-4 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::select('role', $roles, null, ['class' => 'form-control']) !!}
                    {!! $errors->first('role', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
           
            <div class="row form-group">
                <div class="col-sm-offset-4 col-sm-3">
                    {!! Form::submit('Enregistrer', ['class' => 'btn btn-success form-control']) !!}
                </div>
                <a href="{{route('user.index')}}" class="btn btn-default">Retour liste</a>
            </div>
           

        </ul>
    {{ Form::close() }}
    </div>
    </div>

    </div>
</div>
@stop

@section('js')

@endsection