{{-- 
    Tag <select> affichant specifiquement les departements de l'INSA

    Variables a definir depuis la vue appelante :
        'attribut'     : Le nom de l'attribut de l'input dans le form
        'intitule'     : L'intitule de l'input a afficher
        'valeur'       : la valeur de l'input le cas echeant
        'departements' : collection de App\Modeles\Departement
--}}
<label for="{{ $attribut }}">{{ $intitule }}</label>
<select name="{{ $attribut }}" id="{{ $attribut }}" value="{{ $valeur }}" >
    {{-- Liste les departements existants --}}
    @include('includes.foreach.departements', [
        'departements' => $departements
    ])
</select>
@error($attribut)
<div class="alert alert-danger">{{ $message }}</div>
@enderror