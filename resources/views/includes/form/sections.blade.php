{{--
    Affiche un formulaire pour une collection de sections donnees
    /!\ On suppose que les sections sont ordonnees par ordre croissant sur 'ordre'

    Variables a definir depuis le controller appelant :
        'contenu'  => array(array...)     Le contenu de la fiche de notation
        'sections' => Collection(Section) Les sections sur lesquelles iterer
--}}
@for($i=0; $i<count($sections); $i++)
    <div class="row">
        <div class="col">
            <table class="table table-hover">
                <thead>{{-- Intitule + Entetes des choix --}}
                <tr class="row">
                    <th class="col-7 border text-center">
                        <p>{{ $i + 1 }} - {{ $sections[$i]->intitule }}</p>
                        <p>
                            <span id="spanNoteS{{ $i }}">{{ $sections[$i]->getNoteSection($contenu[$i]) }}</span> / {{ $sections[$i]->getBareme() }}
                        </p>
                    </th>

                    @for($j=0; $j<count($sections[$i]->choix); $j++)
                        <th class="col border text-center bg-info">
                            <p class="font-weight-light">{{ $sections[$i]->choix[$j][1] }}{{-- Intitule --}}</p>
                            <p class="font-weight-light">
                                <span id="spanS{{$i}}C{{$j}}">{{ $sections[$i]->choix[$j][0] }}</span> point{{ $sections[$i]->choix[$j][0] >= 2 ? 's':'' }}{{-- Nombre de points --}}
                            </p>
                        </th>
                    @endfor
                </tr>
                </thead>
                <tbody id="section{{$i}}">{{-- Iteration sur tous les criteres d'une section --}}
                @include('includes.form.criteres', [
                    'contenu'      => $contenu,
                    'criteres'     => $sections[$i]->criteres,
                    'indexSection' => $i,
                    'nbChoix'      => count($sections[$i]->choix)
                ])
                </tbody>
            </table>
            <br/>
        </div>
    </div>
@endfor
