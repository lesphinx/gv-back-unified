@extends('layout.app')
@section('title')
Role utilisateur
@stop

@section('content')
<div class="panel panel-default">
<div class="panel-heading">Roles utilisateurs</div>
<div class="panel-body">
    <a href="{{ url('role/create') }}" class="btn btn-success">Nouveau role</a>
    <div class="table">
        <table class="table table-bordered table-striped table-hover" id="tblroles">
            <thead>
                <tr>
                    <th>ID</th><th>Identifiant</th><th>Libélé</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
           
            @foreach($roles as $item)
              
                <tr>
                    <td>{{ $item->id }}</td>
                    <td><a href="{{ url('role', $item->id) }}">{{ $item->slug }}</a></td><td>{{ $item->name }}</td>
                    <td>
                     <a href="{{route('user.index',['type='.$item->name])}}" class="btn btn-success btn-xs">Détail </a>
                        <a href="{{ url('role/' . $item->id . '/edit') }}" class="btn btn-success btn-xs">Editer</a> 
                        <a href="{{ url('role/' . $item->id . '/permissions') }}" class="btn btn-warning btn-xs">Perrmissions</a> 
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['role', $item->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs deleteconfirm']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    </div>
    </div>
 
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#tblroles').DataTable({
                columnDefs: [{
                    targets: [0],
                    visible: false,
                    searchable: false
                    },
                ],
                order: [[0, "asc"]],
            });
        });
     $(".deleteconfirm").on("click", function(){
            return confirm("Etes vous sûr de supprimer ?");
        });
    </script>
@endsection