@extends('layouts.app')

@section('title', 'Contact - Index')

@section('sidebar')
@endsection

@section('content')
<div>
    Nombre d'entrees dans la base : {{ $nombre }}
</div>

<div>
    <a href="contacts/create">Créer</a>
</div>
<div>
    <table>
        <tr>
            <th>id</th>
            <th>nom</th>
            <th>prenom</th>
            <th>civilite</th>
            <th>type</th>
            <th>mail</th>
            <th>telephone</th>
            <th>adresse</th>
        </tr>
        @foreach($contacts as $c)
        <tr>
            <td>{{ $c->id }}</td>
            <td>{{ $c->nom }}</td>
            <td>{{ $c->prenom }}</td>
            <td>{{ $c->civilite }}</td>
            <td>{{ $c->type }}</td>
            <td>{{ $c->mail }}</td>
            <td>{{ $c->telephone }}</td>
            <td>{{ $c->adresse }}</td>
        </tr>
        @endforeach

    </table>
</div>
@endsection