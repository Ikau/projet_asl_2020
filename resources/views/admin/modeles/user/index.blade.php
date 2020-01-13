@extends('layouts.app')

@section('titre', $titre)


@section('contenu')
<div>
    Nombre d'entrees dans la base : {{ $users->count() }}
</div>

<div>
<a href="/tests">Retour</a>
<a href="{{ route('users.create') }}">Créer</a>
</div>
<div>
    <table>
        <tr>
            @foreach($attributs as $attribut)
            <th>{{ $attribut }}</th>
            @endforeach
        </tr>
        @foreach($users as $user)
        <tr>
            @foreach($attributs as $attribut)
            <td>{{ $user[$attribut] }}</td>
            @endforeach
            
            <td>
                <form method="GET" action="{{ route('users.show', [$user->id]) }}">
                    @csrf
                    @method('GET')
                    <button type="submit">Profil</button>
                </form>
            </td>
            <td>
                <form method="GET" action="{{ route('users.edit', [$user->id]) }}">
                    @csrf
                    @method('GET')
                    <button type="submit">Modifier</button>
                </form>
            </td>
            <td>
                <form method="POST" action="{{ route('users.destroy', [$user->id]) }}">
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