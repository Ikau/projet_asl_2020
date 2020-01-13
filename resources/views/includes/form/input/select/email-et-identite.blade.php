{{-- 
    Tag <select> affichant specifiquement la liste des emails et l'identite des tables Enseignant et Contact (insa)

    Variables a definir depuis la vue appelante :
        'attribut'      : Le nom de l'attribut de l'input dans le form
        'enseignants'   : Collection de App\Modeles\Enseignants
        'contacts_insa' : Collection de App\Modeles\Contact appartenant a l'INSA
        'type'          : int Valeur du type correspondant aux contacts INSA
        'intitule'      : L'intitule de l'input a afficher
        'valeur'        : La valeur de l'input le cas echeant
--}}
<label for="{{ $attribut }}">{{ $intitule }}</label>
<select name="{{ $attribut }}" id="{{ $attribut }}">
    @include('includes.foreach.email', [
        'enseignants'   => $enseignants,
        'contacts_insa' => $contacts_insa,
        'type'          => $type,
        'valeur'        => $valeur
    ])
</select>
@error($attribut)
<div class="alert alert-danger">{{ $message }}</div>
@enderror