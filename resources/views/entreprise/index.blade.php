@extends('layouts.app')

@section('titre', $titre)

@section('sidebar')
@endsection

@section('contenu')
<div>
    Nombre d'entrees dans la base : {{ $entreprises->count() }}
</div>

<div>
<a href="/tests">Retour</a>
<a href="{{ route('entreprises.create') }}">Créer</a>
</div>
<div>
    <table>
        <tr>
            @foreach($attributs as $attribut)
            <th>{{ $attribut }}</th>
            @endforeach
        </tr>
        @foreach($entreprises as $entreprise)
        <tr>
            @foreach($attributs as $attribut)
            <td>{{ $entreprise[$attribut] }}</td>
            @endforeach
            
            <td>
                <form method="GET" action="{{ route('entreprises.show', [$entreprise->id]) }}">
                    @csrf
                    @method('GET')
                    <button type="submit">Profil</button>
                </form>
            </td>
            <td>
                <form method="GET" action="{{ route('entreprises.edit', [$entreprise->id]) }}">
                    @csrf
                    @method('GET')
                    <button type="submit">Modifier</button>
                </form>
            </td>
            <td>
                <form method="POST" action="{{ route('entreprises.destroy', [$entreprise->id]) }}">
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