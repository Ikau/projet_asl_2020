{{--
    Tag <select> affichant specifiquement les options de l'INSA

    Variables a definir depuis la vue appelante :
        'attribut'     : Le nom de l'attribut de l'input dans le form
        'intitule'     : L'intitule de l'input a afficher
        'valeur'       : la valeur de l'input le cas echeant
        'departements' : collection de App\Modeles\Departement
        'options'      : collection de App\Modeles\Option
--}}
<div>
    <label for="{{ $attribut }}">{{ $intitule }}</label>

    <select name="{{ $attribut }}" id="{{ $attribut }}">

        <optgroup label="Aucun">
            <option value="" {{ $valeur === null ? 'selected':'' }}>Aucune</option>
        </optgroup>
        {{-- Iteration sur les departements --}}
        @foreach($departements as $departement)
            {{-- Iteration sur l'option de chaque departement --}}
            <optgroup label="{{ $departement->intitule }}">
                @foreach($options as $option)
                    @if($departement->id === $option->departement_id)
                        <option value="{{ $option->id }}" {{ $valeur === $option->id ? 'selected':'' }}>{{ $option->intitule }}</option>
                    @endif
                @endforeach
            </optgroup>
        @endforeach
    </select>

    @error($attribut)
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>
