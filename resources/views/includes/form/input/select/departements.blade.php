{{--
    Tag <select> affichant specifiquement les departements de l'INSA

    Variables a definir depuis la vue appelante :
        'attribut'     : Le nom de l'attribut de l'input dans le form
        'intitule'     : L'intitule de l'input a afficher
        'valeur'       : la valeur de l'input le cas echeant
        'departements' : collection de App\Modeles\Departement
--}}
<div>
    <label for="{{ $attribut }}">{{ $intitule }}</label>
    <select name="{{ $attribut }}" id="{{ $attribut }}">
        <option value="" {{ $valeur === null ? 'selected':'' }} >Aucun</option>
        @foreach($departements as $departement)
            <option value="{{ $departement->id }}" {{ $valeur === $departement->id ? 'selected':'' }}>{{ $departement->intitule }}</option>
        @endforeach
    </select>
    @error($attribut)
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>
