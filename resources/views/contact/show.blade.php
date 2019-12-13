@extends('layouts.app')

@section('title', $titre)

@section('sidebar')
@endsection

@section('content')
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