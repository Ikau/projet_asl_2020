@extends('layouts.app')

@section('titre', $titre)


@section('contenu')
<div>
    Nombre d'entrees dans la base : {{ $soutenances->count() }}
</div>

<div>
<a href="{{ route('admin.index') }}">Zone administrateur</a>
<a href="{{ route('soutenances.create') }}">Créer</a>
</div>
<div>
    <table>
        <tr>
            @foreach($attributs as $attribut)
            <th>{{ $attribut }}</th>
            @endforeach
        </tr>
        @foreach($soutenances as $soutenance)
        <tr>
            @foreach($attributs as $attribut)
            <td>{{ $soutenance[$attribut] }}</td>
            @endforeach
            
            <td>
                <form method="GET" action="{{ route('soutenances.show', [$soutenance->id]) }}">
                    @csrf
                    @method('GET')
                    <button type="submit">Profil</button>
                </form>
            </td>
            <td>
                <form method="GET" action="{{ route('soutenances.edit', [$soutenance->id]) }}">
                    @csrf
                    @method('GET')
                    <button type="submit">Modifier</button>
                </form>
            </td>
            <td>
                <form method="POST" action="{{ route('soutenances.destroy', [$soutenance->id]) }}">
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