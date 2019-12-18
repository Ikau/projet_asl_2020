{{-- 
    Tag <select> affichant specifiquement les options de l'INSA

    Variables a definir depuis la vue appelante :
        'attribut'     : Le nom de l'attribut de l'input dans le form
        'intitule'     : L'intitule de l'input a afficher
        'valeur'       : la valeur de l'input le cas echeant
        'departements' : collection de App\Modeles\Departement
        'options'      : collection de App\Modeles\Option
--}}
    <label for="{{ $attribut }}">{{ $intitule }}</label>
<select name="{{ $attribut }}" id="{{ $attribut }}" value="{{ $valeur }}" >
    {{-- Liste les options de departement existants --}}
    @include('includes.foreach.options', [
        'departements' => $departements,
        'options'      => $options
    ])
</select>
@error($attribut)
<div class="alert alert-danger">{{ $message }}</div>
@enderror