{{-- 
    Tag <select> affichant specifiquement les campus disponibles (actuellement Bourges et Blois)

    Variables a definir depuis la vue appelante :
        'attribut' : Le nom de l'attribut de l'input dans le form
        'intitule' : L'intitule de l'input a afficher
        'valeur'   : la valeur de l'input le cas echeant
--}}
<label for="{{ $attribut }}">{{ $intitule }}</label>
<select name="{{ $attribut }}" id="{{ $attribut }}">
    <option value="Blois" {{ $valeur === 'Blois' ? 'selected':'' }}>Blois</option>
    <option value="Bourges" {{ $valeur === 'Bourges' ? 'selected':'' }}>Bourges</option>
</select>
@error($attribut)
<div class="alert alert-danger">{{ $message }}</div>
@enderror