{{-- 
    Tag <select> affichant specifiquement les annees de stage (actuellement 4A et 5A)

    Variables a definir depuis la vue appelante :
        'attribut' : Le nom de l'attribut de l'input dans le form
        'intitule' : L'intitule de l'input a afficher
        'valeur'   : la valeur de l'input le cas echeant
--}}
<label for="{{ $attribut }}">{{ $intitule }}</label>
<select name="{{ $attribut }}" id="{{ $attribut }}">
    <option value="4" {{ $valeur === '4' ? 'selected':'' }}>4e année</option>
    <option value="5" {{ $valeur === '5' ? 'selected':'' }}>5e année</option>
</select>
@error($attribut)
<div class="alert alert-danger">{{ $message }}</div>
@enderror