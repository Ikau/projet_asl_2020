@extends('layouts.app')

@section('titre', $titre)


@section('contenu')
<div>
    Nombre d'entrees dans la base : {{ $contacts->count() }}
</div>

<div>
    <a href="{{ route('admin.index') }}">Zone administrateur</a>
    <a href="{{ route('contacts.create') }}">Créer</a>
</div>
<div>
    <table>
        <tr>
            <th>id</th>
            <th>nom</th>
            <th>prenom</th>
            <th>civilite</th>
            <th>type</th>
            <th>email</th>
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
            <td>{{ $c->email }}</td>
            <td>{{ $c->telephone }}</td>
            <td>{{ $c->adresse }}</td>
            <td>
                <form method="GET" action="{{ route('contacts.show', [$c->id]) }}">
                    @csrf
                    @method('GET')
                    <button type="submit">Profil</button>
                </form>
            </td>
            <td>
                <form method="GET" action="{{ route('contacts.edit', [$c->id]) }}">
                    @csrf
                    @method('GET')
                    <button type="submit">Modifier</button>
                </form>
            </td>
            <td>
                <form method="POST" action="{{ route('contacts.destroy', [$c->id]) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Supprimer</button>
                </form>
            </td>
        </tr>
        @endforeach

    </table>
</div>
@endsection