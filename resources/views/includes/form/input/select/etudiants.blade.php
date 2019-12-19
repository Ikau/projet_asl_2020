{{-- 
    Tag <select> affichant specifiquement une liste des etudiants

    Variables a definir depuis la vue appelante :
        'attribut'  : Le nom de l'attribut de l'input dans le form
        'etudiants' : Collection de App\Modeles\Etudiant
        'intitule'  : L'intitule de l'input a afficher
        'valeur'    : La valeur de l'input le cas echeant
--}}
<label for="{{ $attribut }}">{{ $intitule }}</label>
<select name="{{ $attribut }}" id="{{ $attribut }}">
    @foreach($etudiants as $e)
    <option value="{{ $e->id }}" {{ $valeur === $e->id ? 'selected':'' }}>{{ $e->nom }} {{ $e->prenom }}</option>
    @endforeach
</select>
@error($attribut)
<div class="alert alert-danger">{{ $message }}</div>
@enderror