@extends('layout.app')
@section('title')
Utilisateur
@stop

@section('content')
<div class="card card-default">
<div class="card-body">
<div class="">
        <div class="">Utilisateurs</div>

        <div class="">

@if (Sentinel::getUser()->hasAccess(['user.create']))
<a href="{{route('user.create')}}" class="btn btn-success">Nouveau Utilisateur</a>
@endif
<table class="table table-bordered table-striped table-hover" id="tblUsers">
    <thead>
        <tr>

            <th>Tout selectionner <input name="select_all" value="1" id="example-select-all" type="checkbox" /></th>
            <th>Nom</th>
            <th>Prénon</th>
            <th>E-mail</th>
            <th>Role</th>
            <th>Date Création</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ Form::checkbox('sel', $user->id, null, ['class' => ''])}}</td>
                <td><a href="{{route('user.show', $user->id)}}">{{$user->first_name}}</a></td>
                <td><a href="{{route('user.show', $user->id)}}">{{$user->last_name}}</a></td>
                <td>{{$user->email}}</td>
                
                <td> <a href="{{route('user.index',['type='.$user->roles()->first()->name])}}">{{empty($user->roles()->first())?"":$user->roles()->first()->name}}</a>  </td>
                <td>{{$user->created_at}}</td>
                <td>
                    @if (Sentinel::getUser()->hasAccess(['user.show']))
                    <a href="{{route('user.show', $user->id)}}" class="btn btn-success btn-xs">Détail</a>
                    @endif
                    @if (Sentinel::getUser()->hasAccess(['user.edit']))
                    <a href="{{route('user.edit', $user->id)}}" class="btn btn-success btn-xs">Editer</a>
                    @endif
                    @if (Sentinel::getUser()->hasAccess(['user.permissions']))
                    <a href="{{route('user.permissions', $user->id)}}" class="btn btn-warning btn-xs">Permissions</a>
                    @endif
                    @if (Sentinel::getUser()->hasAccess(['user.destroy']))
                    {!! Form::open(['method'=>'DELETE', 'route' => ['user.destroy', $user->id], 'style' => 'display:inline']) !!}
                    {!! Form::submit('Supprimer', ['class' => 'btn btn-danger btn-xs','id'=>'delete-confirm']) !!}
                    {!! Form::close() !!}
                    @endif
                    
                    @if(sizeof($user->activations) == 0)
                    @if (Sentinel::getUser()->hasAccess(['user.activate']))
                    <a href="{{route('user.activate', $user->id)}}" class="btn btn-primary btn-xs">Activer</a>
                    @endif
                    @else
                    @if (Sentinel::getUser()->hasAccess(['user.deactivate']))
                     <a href="{{route('user.deactivate', $user->id)}}" class="btn btn-warning btn-xs">Désactiver</a>
                     @endif
                    @endif
                    
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@if (Sentinel::getUser()->hasAccess(['user.destroy']))
<button id="delete_all" class='btn btn-danger btn-xs'>Supprimer la selection</button>
@endif
@if (Sentinel::getUser()->hasAccess(['user.activate']))
<button id="activate_all" class='btn btn-primary btn-xs'>Tout activer</button>
@endif
@if (Sentinel::getUser()->hasAccess(['user.deactivate']))
<button id="deactivate_all" class='btn btn-warning btn-xs'>Tout désactiver</button>
@endif
</div>
</div>
</div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    $(document).ready(function(){
        table = $('#tblUsers').DataTable({
            'columnDefs': [{
         'targets': 0,
         'searchable':false,
         'orderable':false,
            }],
          'order': [1, 'asc']
            });
    });
      // Handle click on "tout selectionner" control
   $('#example-select-all').on('click', function(){
      // Check/uncheck all checkboxes in the table
      var rows = table.rows({ 'search': 'applied' }).nodes();
      $('input[type="checkbox"]', rows).prop('checked', this.checked);
   });
  $("input#delete-confirm").on("click", function(){
        return confirm("êtes vous sûr de supprimer?");
    });
  // start Delete All function
  $("#delete_all").click(function(event){
        event.preventDefault();
        if (confirm("Etes vous sûr de supprimer?")) {
            var value=get_Selected_id();
            if (value!='') {

                 $.ajax({
                    type: "POST",
                    cache: false,
                    url : "{{action('UserController@ajax_all')}}",
                    data: {all_id:value,action:'delete'},
                        success: function(data) {
                          location.reload()
                        }
                    })

                }else{return confirm("Selectioner d'abord");}
        }
        return false;
   });
  //End Delete All Function
  //Start Deactivate all Function
    $("#deactivate_all").click(function(event){
        event.preventDefault();
        if (confirm("Etes vous sûr de désactiver ?")) {
            var value=get_Selected_id();
            if (value!='') {

                 $.ajax({
                    type: "POST",
                    cache: false,
                    url : "{{action('UserController@ajax_all')}}",
                    data: {all_id:value,action:'deactivate'},
                        success: function(data) {
                          location.reload()
                        }
                    })

                }else{return confirm("Selectionner d'abord");}
        }
        return false;
    });
    //fin Deactivate Function
      //debut Activate all Function
    $("#activate_all").click(function(event){
        event.preventDefault();
        if (confirm("Etes vous sur d'activer cet utilisateur ?")) {
            var value=get_Selected_id();
            if (value!='') {

                 $.ajax({
                    type: "POST",
                    cache: false,
                    url : "{{action('UserController@ajax_all')}}",
                    data: {all_id:value,action:'activate'},
                        success: function(data) {
                          location.reload()
                        }
                    })

                }else{return confirm("Selectionner d'abord");}
        }
        return false;
    });
    //fin Activate Function



   
   function get_Selected_id() {
    var searchIDs = $("input[name=sel]:checked").map(function(){
      return $(this).val();
    }).get();
    return searchIDs;
   }
</script>


@endsection
