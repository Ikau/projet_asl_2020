@extends('layouts.app')

@section('titre', $titre)

@section('sidebar')
@endsection

@section('contenu')
<div>
    Information sur une soutenance
</div>

@foreach($soutenance->toArray() as $key => $value)
<div>
    {{ $key }} : {{ $value }}
</div>
@endforeach
<div>
</div>
@endsection