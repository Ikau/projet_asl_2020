@extends('layouts.app')

@section('title', 'Contact - Create')

@section('sidebar')
@endsection

@section('content')
<div>
    Formulaire de creation d'un contact
</div>

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@endsection