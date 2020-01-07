@extends('layouts.app')

@section('titre', $titre)


@section('contenu')
<div>
    Information sur un etudiant
</div>

@foreach($etudiant->toArray() as $key => $value)
<div>
    {{ $key }} : {{ $value }}
</div>
@endforeach
<div>
</div>
@endsection