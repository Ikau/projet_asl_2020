@extends('layouts.app')

@section('titre', $titre)


@section('contenu')
<div>
    Information sur un stage
</div>

@foreach($stage->toArray() as $key => $value)
<div>
    {{ $key }} : {{ $value }}
</div>
@endforeach
<div>
</div>
@endsection