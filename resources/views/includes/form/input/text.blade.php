{{-- 
    Tag <input type="text"> pour les formulaires

    Variables a definir depuis la vue appelante :
        'attribut' : Le nom de l'attribut de l'input dans le form
        'intitule' : L'intitule de l'input a afficher
        'valeur'   : la valeur de l'input le cas echeant
--}}
<label for="{{ $attribut }}">{{ $intitule }}</label>
<input id="{{ $attribut }}" name="{{ $attribut }}" type="text" value="{{ $valeur }}">
@error($attribut)
<div class="alert alert-danger">{{ $message }}</div>
@enderror