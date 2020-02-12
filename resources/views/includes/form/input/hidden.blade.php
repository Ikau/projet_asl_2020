{{--
    Tag <input> utilisée avec le type 'hidden'

    Variables a definir depuis la vue appelante :
        'attribut' : Le nom de l'attribut de l'input dans le form
        'valeur'   : la valeur de l'input le cas echeant
--}}
<input type="hidden" name="{{ $attribut }}" value="{{ $valeur }}">
@error($attribut)
<div class="alert alert-danger">{{ $message }}</div>
@enderror
