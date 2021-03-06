<?php

namespace App\Facade;

use App\Modeles\Stage;
use App\Notifications\AffectationAssignee;
use App\Utils\Constantes;

/**
 * Facade consistant a proposer un appel homogene pour afficher des donnees a propos des notifcations en BDD.
 *
 * Cette facon de fonctionner n'est clairement pas la plus optimale.
 * D'apres la documentation de Laravel, il faudrait creer un nouveau type de canal de notification.
 * A partir de ce canal de notification, il devrait etre possible d'affecter des notifications personnalisees.
 *
 * A l'etat actuel du projet, il ne restait pas assez de temps pour faire une implementation propre.
 * Cette facade pourrait donc etre temporaire et supprimee par la suite lorsque l'environnement adequat sera cree.
 *
 * Class NotificationFacade
 * @package App\Facade
 */
class NotificationFacade
{
    public static function getMessage($notification,  ... $args)
    {
        switch ($notification->type)
        {
            case AffectationAssignee::class:
                // Recuperation des informations pour le message
                $stage = Stage::find($notification->data[AffectationAssignee::VAL_DATA_ID_STAGE]);
                if(null === $stage)
                {
                    return "Une erreur inattendue est apparue... \n"
                        ."Veuillez contacter votre administrateur en lui indiquant un probleme d'affectation d'ID ".$notification->idStage;
                }

                return "Vous êtes référent(e) d'un nouveau stage de {$stage->annee_etudiant}e année {$stage->etudiant->departement->intitule} intitule '".strip_tags($stage->intitule)."'"
                    ."<br/>L'etudiant(e) associé(e) au stage est ".strip_tags($stage->etudiant->prenom)." ".strip_tags($stage->etudiant->nom).".";
            break;

            default:
                return "";
        }
    }

    public static function getTitre($notification, ... $args)
    {
        switch ($notification->type)
        {
            case AffectationAssignee::class:
                return "Nouvelle affectation";

            default:
                return "";
        }
    }

    public static function getTypeEvenement($notification, ... $args)
    {
        switch ($notification->type)
        {

            case AffectationAssignee::class:
                return Constantes::VAL_INTITULE_NOUVELLE_AFFECTATION;

            default:
                return "";
        }
    }
}
