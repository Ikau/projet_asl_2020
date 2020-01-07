@extends('layouts.app')

@section('titre', $titre)


@section('contenu')
<div>
    Information sur une entreprise
</div>

@foreach($entreprise->toArray() as $key => $value)
<div>
    {{ $key }} : {{ $value }}
</div>
@endforeach
<div>
</div>
@endsection