@extends('layouts.app')

@section('titre', $titre)

@section('sidebar')
@endsection

@section('contenu')
<div>
    Information sur un enseignant
</div>

@foreach($enseignant->toArray() as $key => $value)
<div>
    {{ $key }} : {{ $value }}
</div>
@endforeach
<div>
</div>
@endsection