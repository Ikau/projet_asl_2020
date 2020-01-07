{{-- 
    Tag <input type="checkbox"> pour les formulaires

    Variables a definir depuis la vue appelante :
        'attribut' : Le nom de l'attribut de l'input dans le form
        'intitule' : L'intitule de l'input a afficher
        'valeur'   : la valeur de l'input permettant de savoir si la checkbox est cochee ou non
--}}
<label for="{{ $attribut }}">{{ $intitule }}</label>
<input id="{{ $attribut }}" name="{{ $attribut }}" type="checkbox" {{ $valeur === 'on' ? 'checked':'' }}>
@error($attribut)
<div class="alert alert-danger">{{ $message }}</div>
@enderror