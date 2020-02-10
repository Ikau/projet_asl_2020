{{--
    Affiche le contenu de toutes les sections.
    /!\ On suppose que les sections sont ordonnees par ordre croissant sur 'ordre'

    Variables a definir depuis le controller appelant :
        'contenu'    => array(indexSection => [indexChoix]) Le contenu de
        'sections'   => Collection(Section)                 Les sections sur lesquelles iterer
--}}
@foreach($contenu as $indexSection => $arrayIndex)
<div class="row">
    <div class="col">
        <table class="container">
            <thead>{{-- Intitule + Entetes des choix --}}
                <tr class="row">
                    <th class="col-7 text-center border-bottom border-right">
                        <p>{{ $indexSection }} - {{ $sections[$indexSection]->intitule }}</p>
                    </th>

                    @foreach($sections[$indexSection]->choix as $choix)
                    <th class="col border text-center">
                        <p class="font-weight-light">{{ $choix[1] }}{{-- Intitule --}}</p>
                        <p class="font-weight-light">{{ $choix[0] }} point{{ $choix[0] >= 2 ? 's':'' }}{{-- Nombre de points --}}</p>
                    </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>{{-- Iteration sur tous les criteres d'une section --}}
                @include('includes.criteres', [
                    'criteres' => $sections[$indexSection]->criteres,
                    'donnees'  => $arrayIndex,
                    'nbChoix'  => count($sections[$indexSection]->choix)
                ])
            </tbody>
        </table>
        <br/>
    </div>
</div>
@endforeach
