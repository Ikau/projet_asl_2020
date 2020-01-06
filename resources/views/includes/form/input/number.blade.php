{{-- 
    Tag <input type="number"> pour les formulaires

    Variables a definir depuis la vue appelante :
        'attribut' : Le nom de l'attribut de l'input dans le form
        'intitule' : L'intitule de l'input a afficher
        'valeur'   : La valeur de l'input le cas echeant
        'min'      : La valeur min de l'input le cas echeant
        'max'      : La valeur max de l'input le cas echeant
--}}
<label for="{{ $attribut }}">{{ $intitule }}</label>
<input id="{{ $attribut }}" name="{{ $attribut }}" type="number" value="{{ $valeur }}" min="{{ $min ?? 0 }}" {{ $max ? "max=\"$max\"":'' }}>
@error($attribut)
<div class="alert alert-danger">{{ $message }}</div>
@enderror