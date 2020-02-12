{{--
    Ajoute un formulaire pour les criteres donnees

    Variables a definir depuis le controller appelant :
        'criteres'     => array(String) Ensemble des intitules de criteres sur lesquels iterer
        'indexSection' => int           L'index de la section que l'on affiche actuellement
        'nbChoix'      => int           Le nombre de choix de la section
--}}
@for($i=0; $i<count($criteres); $i++)
    <tr class="row">
        <td class="col-7 border font-weight-light bg-success">{{ $criteres[$i] }}</td>{{-- Intitule du critere --}}

        @for($j=0; $j<$nbChoix; $j++)
            <td class="col p-0">
                <label class="btn btn-block h-100 border" for="s{{$indexSection}}c{{$i}}rb{{$j}}">
                    <input id="s{{$indexSection}}c{{$i}}rb{{$j}}" type="radio" name="contenu[{{$indexSection}}][{{$i}}]" value="{{$j}}">
                </label>
            </td>
        @endfor
        <td hidden class="col p-0">
            <label class="btn btn-block h-100 border" for="s{{$indexSection}}c{{$i}}rb{{$j}}">
                <input id="s{{$indexSection}}c{{$i}}rb{{$j}}" type="radio" name="contenu[{{$indexSection}}][{{$i}}]" checked="checked" value="-1">
            </label>
        </td>
    </tr>
@endfor
