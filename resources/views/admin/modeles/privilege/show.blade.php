@extends('layouts.app')

@section('titre', $titre)


@section('contenu')
<div>
    Information sur un privilege
</div>

@foreach($privilege->toArray() as $key => $value)
<div>
    {{ $key }} : {{ $value }}
</div>
@endforeach
<div>
</div>
@endsection