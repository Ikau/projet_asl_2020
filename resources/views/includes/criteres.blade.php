{{--
    Ajoute tous les criteres avec les donnees enregistrees le cas echeant

    Variables a definir depuis le controller appelant :
        'criteres'   => array(String)     Ensemble des intitules de criteres sur lesquels iterer
        'arrayIndex' => array(indexChoix) Le contenu de la fiche pour la section courante
        'nbChoix'    => int               Le nombre de choix de la section
--}}
@for($i=0; $i<count($criteres); $i++)
<tr class="row">
    <td class="col-7 border font-weight-light bg-success">{{ $criteres[$i] }}</td>{{-- Intitule du critere --}}

    {{-- Si l'array enregistre est vide ou non coherent --}}
    @if([] === $arrayIndex || count($criteres) !== count($arrayIndex))
        {{-- Il n'y a aucun choix enregistre donc champs vides --}}
        @for($i=0; $i<$nbChoix; $i++)
        <td class="col border"></td>
        @endfor
    @else {{-- L'array est bon donc on affiche son contenu --}}
        @for($j=0; $j<$nbChoix; $j++)
            @if($arrayIndex[$i] === $j)
            <td class="col border text-white text-center align-middle bg-secondary">X</td>
            @else
            <td class="col border"></td>
            @endif
        @endfor
    @endif
</tr>
@endfor
