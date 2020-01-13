@extends('layouts.app')

@section('titre', $titre)


@section('contenu')
<div>
    Nombre d'entrees dans la base : {{ $enseignants->count() }}
</div>

<div>
<a href="{{ route('admin.index') }}">Zone administrateur</a>
<a href="{{ route('enseignants.create') }}">Créer</a>
</div>
<div>
    <table>
        <tr>
            @foreach($attributs as $a)
            <th>{{ $a }}</th>
            @endforeach
        </tr>
        @foreach($enseignants as $e)
        <tr>
            @foreach($attributs as $a)
            <td>{{ $e[$a] }}</td>
            @endforeach
            <td>
                <form method="GET" action="{{ route('enseignants.show', [$e->id]) }}">
                    @csrf
                    @method('GET')
                    <button type="submit">Profil</button>
                </form>
            </td>
            <td>
                <form method="GET" action="{{ route('enseignants.edit', [$e->id]) }}">
                    @csrf
                    @method('GET')
                    <button type="submit">Modifier</button>
                </form>
            </td>
            <td>
                <form method="POST" action="{{ route('enseignants.destroy', [$e->id]) }}">
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