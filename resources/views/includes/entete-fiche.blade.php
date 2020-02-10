{{--
    Affiche les informations situees dans les entetes de fiche

    Variables a definir depuis le controller appelant :
        'campus' => 'Bourges'|'Blois' Le campus ou se trouve la fiche
        'numero' => 1|2|3|4           Le numero de la fiche
        'stage'  => $stage            Le stage lie a la fiche de rapport
--}}
<div class="row">
    <div class="col">
        <div class="container">
            {{-- Logo, campus, numero fiche --}}
            <div class="row">
                <div class="col">
                    <div>LOGO INSA</div>
                    <div>
                        <p>Campus de {{ $campus }}</p>
                        <p>FICHE N° {{ $numero }}</p>
                    </div>
                </div>

                {{-- Intitule + annee --}}
                <div class="col">
                    <div>
                        <h1>EVALUATION DU RAPPORT DE STAGE</h1>
                    </div>
                    <div>
                        <h2> {{ $stage->annee_etudiant }}e ANNEE 2019 - 2020</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                {{-- Stagiaire, Departement/Option, Enseignant Refereent --}}
                <div class="col">
                    <div>
                        Stagiaire : {{ $stage->etudiant->prenom }} {{ $stage->etudiant->nom }}
                    </div>
                    <div>
                        Département / Option : {{ $stage->etudiant->departement->intitule }} / {{ $stage->etudiant->option->intitule }}
                    </div>
                    <div>
                        Enseignant référent : {{ $stage->referent->prenom }} {{ $stage->referent->nom }}
                    </div>
                </div>

                {{-- Entreprise, Tueur entreprise --}}
                <div class="col">
                    <div>
                        Entreprise : WIPWIP
                    </div>
                    <div>
                        Tuteur entreprise : WIPWIP
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
