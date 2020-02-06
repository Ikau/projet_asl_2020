{{--
    Tag <input type="date"> pour les formulaires
    /!\ Non supporte par Safari ou IE < 11

    Variables a definir depuis la vue appelante :
        'attribut' : Le nom de l'attribut de l'input dans le form
        'intitule' : L'intitule de l'input a afficher
        'valeur'   : la valeur de l'input permettant de savoir si la checkbox est cochee ou non
--}}
<label for="{{ $attribut }}">{{ $intitule }}</label>
<input id="{{ $attribut }}" name="{{ $attribut }}" type="date" value="{{ $valeur }}">
@error($attribut)
<div class="alert alert-danger">{{ $message }}</div>
@enderror
