@extends('layout.app')
@section('content')
    <location-partenaire></location-partenaire>
@endsection
@section('js')
    <script>
        title = `Les locations`;
        cumb = `Les offres de locations`;
        $('.pagetitle').append(title);
        $('#breadcumb').append(cumb);

    </script>
@endsection
