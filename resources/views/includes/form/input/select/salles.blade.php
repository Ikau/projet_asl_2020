{{-- 
    Tag <select> affichant specifiquement les salles disponibles (actuellement de Bourges)

    Variables a definir depuis la vue appelante :
        'attribut' : Le nom de l'attribut de l'input dans le form
        'intitule' : L'intitule de l'input a afficher
        'valeur'   : la valeur de l'input le cas echeant
--}}
<label for="{{ $attribut }}">{{ $intitule }}</label>
<select name="{{ $attribut }}" id="{{ $attribut }}">
    <optgroup label="Campus de Bourges">
        <option value="SA.101" {{ $valeur === 'SA.101' ? 'selected':'' }}>SA.101</option>
        <option value="SA.201" {{ $valeur === 'SA.201' ? 'selected':'' }}>SA.201</option>
        <option value="E.101" {{ $valeur === 'E.101' ? 'selected':'' }}>E.101</option>
        <option value="E.201" {{ $valeur === 'E.201' ? 'selected':'' }}>E.201</option>
    </optgroup>
</select>
@error($attribut)
<div class="alert alert-danger">{{ $message }}</div>
@enderror