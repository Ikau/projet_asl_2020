@extends('layouts.app')

@section('titre', $titre)

@section('sidebar')
@endsection

@section('contenu')
<div>
    Nombre d'entrees dans la base : {{ $enseignants->count() }}
</div>

<div>
<a href="{{ route('enseignants.create') }}">Créer</a>
</div>
<div>
    <table>
        <tr>
            <th>id</th>
            <th>nom</th>
            <th>prenom</th>
            <th>email</th>
            <th>responsable_option</th>
            <th>responsable_departement</th>
            <th>soutenances_candide</th>
            <th>soutenances_referent</th>
            <th>stages</th>
        </tr>
        @foreach($enseignants as $c)
        <tr>
            <td>{{ $c->id }}</td>
            <td>{{ $c->nom }}</td>
            <td>{{ $c->prenom }}</td>
            <td>{{ $c->email }}</td>
            <td>{{ $c->responsable_option }}</td>
            <td>{{ $c->responsable_departement }}</td>
            <td>{{ $c->soutenances_candide }}</td>
            <td>{{ $c->soutenances_referent }}</td>
            <td>{{ $c->stages }}</td>
            <td>
                <form method="GET" action="{{ route('enseignants.show', [$c->id]) }}">
                    @csrf
                    @method('GET')
                    <button type="submit">Profil</button>
                </form>
            </td>
            <td>
                <form method="GET" action="{{ route('enseignants.edit', [$c->id]) }}">
                    @csrf
                    @method('GET')
                    <button type="submit">Modifier</button>
                </form>
            </td>
            <td>
                <form method="POST" action="{{ route('enseignants.destroy', [$c->id]) }}">
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