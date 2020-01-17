<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

use App\Interfaces\Utilisateur;

use App\Modeles\Contact;
use App\Modeles\Enseignant;
use App\Modeles\Privilege;
use App\Modeles\Role;

/**
 * La classe User presente est la classe 'User' livre par defaut par le framework Laravel 
 * 
 * Le choix a ete fait d'utiliser ce modele Eloquent parce que beaucoup de modules reutilise cette classe
 * Pour eviter de se prendre la tete en enregistrant une nouvelle classe, on utilise donc ce modele par defaut
 * 
 * Bien sur, le fait d'utiliser cette classe risque de faire apparaitre des problemes en cas de mise a niveau de Laravel
 * C'est pour cette raison que l'on utilisera beaucoup d'interfaces pour lister les fonctions personnalisees a implementer
 */
class User extends Authenticatable implements Utilisateur, MustVerifyEmail
{
    use Notifiable;

    /* ====================================================================
     *                   STRUCTURE DE LA TABLE DU MODELE
     * ====================================================================
     */

    /**
     * @var string Nom de la table associee au model 'User'.
     */
    const NOM_TABLE = 'users';

    //On indique a Laravel le nom de la table dans la BDD
    protected $table = User::NOM_TABLE;

    /*
     * Nom des colonnes dans la base de donnees
     */
    const COL_EMAIL            = 'email';
    const COL_EMAIL_VERIFIE_LE = 'email_verified_at'; // Nommage Laravel
    const COL_HASH_PASSWORD    = 'password';
    const COL_REMEMBER_TOKEN   = 'remember_token';    // Nommage Laravel

    /*
     * Nom des colonnes polymorphique 
     */
    const COL_POLY_MODELE      = 'identite';      // Nommage Laravel
    const COL_POLY_MODELE_ID   = 'identite_id';   // Nommage Laravel
    const COL_POLY_MODELE_TYPE = 'identite_type'; // Nommage Laravel

    /*
     * Nom de la table de jointure pour une relation Mane-to-Many 
     * Convention de nommage Laravel utilisee : ordre_alphabethique_class
     */
    const NOM_TABLE_PIVOT_PRIVILEGE_USER = 'privilege_user';
    const NOM_TABLE_PIVOT_ROLE_USER      = 'role_user';

    /*
     * Nom de la colonne dans la table de jointure
     * Convention de nommage Laravel utilise : class_id
     */
    const COL_PIVOT = 'user_id';

    /**
     * Indique a Laravel de ne pas creer ni de gerer les tables 'created_at' et 'updated_at'.
     * 
     * @var bool Gestion des timestamps
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        User::COL_EMAIL,
        User::COL_HASH_PASSWORD,
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        User::COL_REMEMBER_TOKEN,
        User::COL_HASH_PASSWORD
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        User::COL_EMAIL_VERIFIE_LE => 'datetime',
    ];

    /**
     * Indique l'adresse a laquelle renvoyer un utilisateur validant son email
     * 
     * @var string
     */
    protected $redirectTo = '/home';

    /* ====================================================================
     *                         INTERFACE 'UTILISATEUR'
     * ====================================================================
     */

    /**
     * Cree un compte user associe au modele Contact entre en argument
     * 
     * @param int    $id         L'ID du contact auquel lier ce compte
     * @param string $motDePasse Le mot de passe du compte user
     * 
     * @return Null|User Le compte user cree ou existant sinon null en cas d'erreur
     */
    public static function fromContact(int $id, string $motDePasse) : User
    {
        // Verification arg
        $contact = Contact::find($id);
        if(null === $contact
        || null === $motDePasse
        || ''   === trim($motDePasse))
        {
            return null;
        }

        // Verification unicite du lien
        $user = User::where([
            [User::COL_POLY_MODELE_TYPE, '=', Contact::class],
            [User::COL_POLY_MODELE_ID, '=', $id]
        ])->first();
        if( ! null === $user)
        {
            return $user;
        }

        // Creation du compte user
        $user = new User;
        $user->fill([
            User::COL_EMAIL         => $contact[Contact::COL_EMAIL],
            User::COL_HASH_PASSWORD => Hash::make($motDePasse)
        ]);
        $user->identite()->associate($contact);
        $user->save();

        return $user;
    }

    /**
     * Cree un compte user associe au modele Enseignant entre en argument
     *
     * @param  int $id L'ID de l'enseignant auquel lier ce compte
     *
     * @return Null|User Le compte user cree ou existant sinon null en cas d'erreur
     */
    public static function fromEnseignant(int $id, string $motDePasse) : User
    {
        // Verification args
        $enseignant = Enseignant::find($id);
        if(null === $enseignant
        || null === $motDePasse
        || ''   === trim($motDePasse))
        {
            return null;
        }

        // Verification unicite du lien
        $user = User::where([
            [User::COL_POLY_MODELE_TYPE, '=', Enseignant::class],
            [User::COL_POLY_MODELE_ID, '=', $id]
        ])->first();
        if( ! null === $user)
        {
            return $user;
        }

        // Creation de l'utilisateur
        $user = new User;
        $user->fill([
            User::COL_EMAIL         => $enseignant[Enseignant::COL_EMAIL],
            User::COL_HASH_PASSWORD => Hash::make($motDePasse)
        ]);
        $user->identite()->associate($enseignant);
        $user->save();

        return $user;
    }

    /**
     * Renvoie le type de l'utilisateur.
     *
     * @return App\UserType Renvoie une reference vers l'objet UserType auquel est rattache l'utilisateur
     */
    public function type()
    {
        return $this->belongsTo('App\UserType', User::COL_TYPE_ID);
    }

    /**
     * Renvoie les privileges de l'utilisateur.
     * 
     * @return array[App\Modeles\Privileges] Array de tous les privileges de l'utilisateur.
     */
    public function privileges()
    {
        // Args : modele de la relation, nom table pivot, nom colonne user_id, nom colonne privilege_id
        return $this->belongsToMany('App\Modeles\Privilege', User::NOM_TABLE_PIVOT_PRIVILEGE_USER,
                                    User::COL_PIVOT, Privilege::COL_PIVOT);
    }

    /**
     * Renvoie les roles de l'utilisateur. 
     * 
     * @return Collection[app\Modeles\Role]
     */
    public function roles()
    {
        // Args : modele de la relation, nom table pivot, nom colonne user_id, nom colonne privilege_id
        return $this->belongsToMany('App\Modeles\Role', User::NOM_TABLE_PIVOT_ROLE_USER,
                                    User::COL_PIVOT, Role::COL_PIVOT);
    }

    /**
     * Renvoie le modele associe au compte utilisateur.abnf
     * 
     * C'est une relation One-to-One polymorphique qui peut renvoyer :
     *  - un enseignant
     *  - un contact
     * Peut etre etendu a un etudiant si besoin
     * [DOC] : https://laravel.com/docs/6.x/eloquent-relationships#one-to-one-polymorphic-relations
     *
     * @return App\Modeles\Contact|App\Modeles\Enseignant
     */
    public function identite()
    {
        return $this->morphTo();
    }
}
