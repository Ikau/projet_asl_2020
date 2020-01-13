@extends('layouts.app')

@section('titre', $titre)


@section('contenu')
<div>
    Information sur un utilisateur
</div>

@foreach($user->toArray() as $key => $value)
<div>
    {{ $key }} : {{ $value }}
</div>
@endforeach
<div>
</div>
@endsection