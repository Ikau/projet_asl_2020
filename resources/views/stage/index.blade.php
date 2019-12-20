@extends('layouts.app')

@section('titre', $titre)

@section('sidebar')
@endsection

@section('contenu')
<div>
    Nombre d'entrees dans la base : {{ $stages->count() }}
</div>

<div>
<a href="/tests">Retour</a>
<a href="{{ route('stages.create') }}">Créer</a>
</div>
<div>
    <table>
        <tr>
            @foreach($attributs as $attribut)
            <th>{{ $attribut }}</th>
            @endforeach
        </tr>
        @foreach($stages as $stage)
        <tr>
            @foreach($attributs as $attribut)
            <td>{{ $stage[$attribut] }}</td>
            @endforeach
            
            <td>
                <form method="GET" action="{{ route('stages.show', [$stage->id]) }}">
                    @csrf
                    @method('GET')
                    <button type="submit">Profil</button>
                </form>
            </td>
            <td>
                <form method="GET" action="{{ route('stages.edit', [$stage->id]) }}">
                    @csrf
                    @method('GET')
                    <button type="submit">Modifier</button>
                </form>
            </td>
            <td>
                <form method="POST" action="{{ route('stages.destroy', [$stage->id]) }}">
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