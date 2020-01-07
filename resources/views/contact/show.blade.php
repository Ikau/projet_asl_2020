@extends('layouts.app')

@section('titre', $titre)


@section('contenu')
<div>
    Information sur un contact
</div>

@foreach($contact->toArray() as $key => $value)
<div>
    {{ $key }} : {{ $value }}
</div>
@endforeach
<div>
</div>
@endsection