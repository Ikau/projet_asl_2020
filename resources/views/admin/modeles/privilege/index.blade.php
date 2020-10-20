@extends('layouts.app')

@section('titre', $titre)


@section('contenu')
<div>
    Nombre d'entrees dans la base : {{ $privileges->count() }}
</div>

<div>
<a href="{{ route('admin.index') }}">Zone administrateur</a>
<a href="{{ route('privileges.create') }}">Créer</a>
</div>
<div>
    <table>
        <tr>
            @foreach($attributs as $attribut)
            <th>{{ $attribut }}</th>
            @endforeach
        </tr>
        @foreach($privileges as $privilege)
        <tr>
            @foreach($attributs as $attribut)
            <td>{{ $privilege[$attribut] }}</td>
            @endforeach
            
            <td>
                <form method="GET" action="{{ route('privileges.show', [$privilege->id]) }}">
                    @csrf
                    @method('GET')
                    <button type="submit">Profil</button>
                </form>
            </td>
            <td>
                <form method="GET" action="{{ route('privileges.edit', [$privilege->id]) }}">
                    @csrf
                    @method('GET')
                    <button type="submit">Modifier</button>
                </form>
            </td>
            <td>
                <form method="POST" action="{{ route('privileges.destroy', [$privilege->id]) }}">
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