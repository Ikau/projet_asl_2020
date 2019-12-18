{{-- 
    Liste les differentes options de l'INSA dans un tage <select>

    Variables recues de la vue appelante :
        'departements' : collection de App\Modeles\Departement
        'options'      : collection de App\Modeles\Option
--}}

@foreach($departements as $departement)
<optgroup label="{{ $departement->intitule }}">
    @foreach($options as $option)
        @if($departement->id === $option->departement_id)
        <option value="{{ $option->id }}">{{ $option->intitule }}</option>
        @endif
    @endforeach
</optgroup>
@endforeach