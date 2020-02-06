{{--
    TEMPTEMPTEMPTEMPTEMPTEMPTEMP

    Variables a definir depuis le controller appelant :
        'stage' => Stage Le stage lie a la fiche de rapport
--}}
<div>
    <!-- Logo, campus, numero fiche -->
    <div>
        <br/> <a>LOGO</a>
        <br/> <a>Campus de {{ 'Bourges' }}</a>
        <br/> <a>FICHE N° 2</a>
    </div>

    <!-- Intitule + annee -->
    <div>
        <br/> <h1>EVALUATION DU RAPPORT DE STAGE</h1>
        <br/> <h1> {{ $stage->annee }}e ANNEE 2019 - 2020</h1>
    </div>

    <!-- Stagiaire, Departement/Option, Enseignant Refereent -->
    <div>
        <br/> <a>Stagiaire : {{ $stage->etudiant->prenom }} {{ $stage->etudiant->nom }}</a>
        <br/> <a>Département / Option : {{ $stage->etudiant->departement->intitule }} / {{ $stage->etudiant->option->intitule }}</a>
        <br/> <a>Enseignant référent : {{ $stage->referent->prenom }} {{ $stage->referent->nom }}</a>
    </div>

    <!-- Entreprise, Tueur entreprise -->
    <div>
        <br/> <a>Entreprise : WIPWIP</a>
        <br/> <a>Tuteur entreprise : WIPWIP</a>
    </div>
</div>
