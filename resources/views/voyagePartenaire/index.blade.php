@extends('layout.app')
@section('content')
    <index-voyage-partenaire></index-voyage-partenaire>
@endsection
@section('js')
    <script>
        title = `Voyages`;
        cumb = `Les offres de Voyage`;
        $('.pagetitle').append(title);
        $('#breadcumb').append(cumb);

    </script>
@endsection
