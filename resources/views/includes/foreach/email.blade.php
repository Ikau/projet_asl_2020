{{-- 
    Liste les emails avec l'identite des tables 'enseignants' et 'contacts' insa.

    Variables a definir depuis la vue appelante :
        'enseignants'   : collection de App\Modeles\Enseinant
        'contacts_insa' : collection de App\Modeles\Contact appartenant a l'INSA
        'type'          : int Valeur du type correspondant aux contacts INSA
--}}
<optgroup label="Enseignants">
    @foreach($enseignants as $e)
    <option value="{{ $e->email }}">{{ $e->nom }} {{ $e->prenom }}  ({{ $e->email }})</option>
    @endforeach
</optgroup>

<optgroup label="Personnel INSA">
    @foreach($contacts_insa as $c)
        @if($type === $c->type)
        <option value="{{ $c->email }}">{{ $c->nom }} {{ $c->prenom }}  ({{ $c->email }})</option>
        @endif
    @endforeach
</optgroup>