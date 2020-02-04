<?php

namespace App\Interfaces;

/**
 * Interface utilisee pour implementer les fonctions utiles a la manipulation des fiches.
 *
 * Elle propose a la classe qui l'implemente des methodes afin de recuperer :
 *   - la note finale d'une fiche (entreprise, rapport, soutenance, synthese)
 *   - decodage du contenu de la fiche (pour soucis de stockage, le contenu est stockee dans un format unique)
 *
 * Cette interface devrait, comme son nom l'indique, etre implementee par toutes les classes Fiche
 */
interface Fiche
{
    /**
     * @return array Renvoie le contenu de la fiche sous forme d'un array associatif
     */
    public function getContenu() : array ;

    /**
     * @return float La note finale de la fiche
     */
    public function getNote() : float;
}

