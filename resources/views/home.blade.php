@extends('layouts.app')

@section('contenu')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>

                </div>
                    Bienvenue {{ $identite->prenom }} {{ $identite->nom }}
                </div>
                <div>
                    Liens de test
                    <div>
                        <a href="{{ route('referents.index') }}">Espace enseignant</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
