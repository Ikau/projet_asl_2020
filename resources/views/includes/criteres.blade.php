{{--
    Ajoute tous les criteres avec les donnees enregistrees le cas echeant

    Variables a definir depuis le controller appelant :
        'criteres' => array(String)     Ensemble des intitules de criteres sur lesquels iterer
        'donnees'  => array(indexChoix) Le contenu de la fiche pour la section courante
        'nbChoix'  => int                Le nombre de choix de la section
--}}
@foreach($criteres as $intituleCritere)
<tr class="row">
    <th class="col-7 border font-weight-light">{{ $intituleCritere }}</th>

    {{-- Si l'array enregistre est vide ou non coherent --}}
    @if([] === $donnees || $nbChoix !== count($donnees))
        {{-- Il n'y a aucun choix enregistre donc champs vides --}}
        @for($i=0; $i<$nbChoix; $i++)
        <th class="col border"> ... </th>
        @endfor
    @else {{-- L'array est bon donc on affiche son contenu --}}
        @for($i=0; $i<$nbChoix; $i++)
            @if($donnees[$i] === $i)
            <th class="col border">  X  </th>
            @else
            <th class="col border"> ... </th>
            @endif
        @endfor
    @endif
</tr>
@endforeach
