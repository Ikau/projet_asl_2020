{{-- 
    Liste les differentes options de l'INSA dans un tag <select>

    Variables recues de la vue appelante :
        'departements' : collection de App\Modeles\Departement
--}}
@foreach($departements as $departement)
    <option value="{{ $departement->id }}">{{ $departement->intitule }}</option>
@endforeach