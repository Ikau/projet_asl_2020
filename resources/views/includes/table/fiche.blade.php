{{--
     Affiche un lien vers une fiche ainsi que l'etat de completion

     Variables a definir depuis la source appelante :
        'statut' : bool   Le statut de la fiche
        'route'  : string Le lien d'affichage de la fiche
--}}
@if($statut === 0)
    <a class="text-danger font-weight-bold font-weight-light" href="{{ route('fiches.rapport.show', $stage->fiche_rapport->id) }}"><u>Vide</u></a>
@elseif($statut === 1)
    <a class="text-info font-weight-bold font-weight-light" href="{{ route('fiches.rapport.show', $stage->fiche_rapport->id) }}"><u>En cours</u></a>
@else
    <a class="text-success font-weight-bold font-weight-light" href="{{ route('fiches.rapport.show', $stage->fiche_rapport->id) }}"><u>Remplie</u></a>
@endif
