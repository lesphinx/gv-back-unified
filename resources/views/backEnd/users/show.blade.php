@extends('layout.app')
@section('title')
Détail de  {{$user->first_name}}
@stop

@section('content')
<div class="card card-default">
<div class="card-body">

<div class="panel panel-default">
        <div class="panel-heading">L'Utlisateur :  {{$user->first_name}}</div>

        <div class="panel-body">
  
 <ul>
        <div class="row">
             {!! Form::label('first_name','Nom', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-sm-6">
                {{$user->first_name}}
            </div>
        </div>
       
       <div class="row">
             {!! Form::label('last_name', 'Prénom', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-sm-6">
               {{$user->last_name}}
            </div>
        </div>

        <div class="row">
             {!! Form::label('email', 'Email', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-sm-6">
               {{$user->email}}
            </div>
        </div>

         <div class="row">
             {!! Form::label('role', 'Role', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-sm-6">
                {{$user->roles->first()->name}}
            </div>
        </div>
    
        <div class="row">
        <br>
        <div class="col-md-6 col-md-offset-4">
            <a href="{{route('user.index')}}" class="btn btn-default">Retour </a>
            </div>
        </div>
    </ul>
    </div>
    </div>                
    </div>
</div>
@stop