@extends('layouts.app')

@section('titre', $titre)


@section('contenu')
<div>
    Nombre d'entrees dans la base : {{ $etudiants->count() }}
</div>

<div>
<a href="{{ route('admin.index') }}">Zone administrateur</a>
<a href="{{ route('etudiants.create') }}">Créer</a>
</div>
<div>
    <table>
        <tr>
            @foreach($attributs as $attribut)
            <th>{{ $attribut }}</th>
            @endforeach
        </tr>
        @foreach($etudiants as $etudiant)
        <tr>
            @foreach($attributs as $attribut)
            <td>{{ $etudiant[$attribut] }}</td>
            @endforeach
            
            <td>
                <form method="GET" action="{{ route('etudiants.show', [$etudiant->id]) }}">
                    @csrf
                    @method('GET')
                    <button type="submit">Profil</button>
                </form>
            </td>
            <td>
                <form method="GET" action="{{ route('etudiants.edit', [$etudiant->id]) }}">
                    @csrf
                    @method('GET')
                    <button type="submit">Modifier</button>
                </form>
            </td>
            <td>
                <form method="POST" action="{{ route('etudiants.destroy', [$etudiant->id]) }}">
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