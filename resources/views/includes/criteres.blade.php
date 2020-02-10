{{--
    Ajoute tous les criteres avec les donnees enregistrees le cas echeant

    Variables a definir depuis le controller appelant :
        'criteres'   => array(String)     Ensemble des intitules de criteres sur lesquels iterer
        'arrayIndex' => array(indexChoix) Le contenu de la fiche pour la section courante
        'nbChoix'    => int               Le nombre de choix de la section
--}}
@for($i=0; $i<count($criteres); $i++)
<tr class="row">
    <th class="col-7 border font-weight-light">{{ $criteres[$i] }}</th>{{-- Intitule du critere --}}

    {{-- Si l'array enregistre est vide ou non coherent --}}
    @if([] === $arrayIndex || count($criteres) !== count($arrayIndex))
        {{-- Il n'y a aucun choix enregistre donc champs vides --}}
        @for($i=0; $i<$nbChoix; $i++)
        <th class="col border"> ... </th>
        @endfor
    @else {{-- L'array est bon donc on affiche son contenu --}}
        @for($j=0; $j<$nbChoix; $j++)
            @if($arrayIndex[$i] === $j)
            <th class="col border">  X  </th>
            @else
            <th class="col border"> ... </th>
            @endif
        @endfor
    @endif
</tr>
@endfor
