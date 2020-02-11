{{--
    Affiche les informations situees dans les entetes de fiche

    Variables a definir depuis le controller appelant :
        'campus' => 'Bourges'|'Blois' Le campus ou se trouve la fiche
        'numero' => 1|2|3|4           Le numero de la fiche
        'stage'  => $stage            Le stage lie a la fiche de rapport
--}}
<div class="row">
    {{-- Logo, campus, numero fiche --}}
    <div class="col text-center border p-3">
        <div class="m-3">
            <img src="{{asset('images/insa-cvl.png')}}"/>
        </div>
        <div>
            <h2>Campus de {{ $campus }}</h2>
            <h3>FICHE N° {{ $numero }}</h3>
        </div>
    </div>
    {{-- Intitule + annee --}}
    <div class="col text-center border p-3">
        <div>
            <h1>EVALUATION</h1>
            <h1>RAPPORT DE STAGE</h1>
        </div>
        <div>
            <h3> {{ $stage->annee_etudiant }}e ANNEE 2019 - 2020</h3>
        </div>
    </div>
</div>
<div class="row">
    {{-- Stagiaire, Departement/Option, Enseignant Refereent --}}
    <div class="col text-center border p-3">
        <div>Stagiaire : {{ $stage->etudiant->prenom }} {{ $stage->etudiant->nom }}</div>
        <div>Département / Option : {{ $stage->etudiant->departement->intitule }} / {{ $stage->etudiant->option->intitule }}</div>
        <div>Enseignant référent : {{ $stage->referent->prenom }} {{ $stage->referent->nom }}</div>
    </div>
    {{-- Entreprise, Tueur entreprise --}}
    <div class="col text-center border p-3">
        <div>
            Entreprise : WIPWIP
        </div>
        <div>
            Tuteur entreprise : WIPWIP
        </div>
    </div>
</div>
