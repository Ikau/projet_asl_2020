<?php

namespace App\Traits;

use App\Utils\Constantes;

trait NotationFiches
{

    /**
     * @variable array contenu : Variable privee representant le contenu de la fiche
     *
     * Rappel de la structure :
     * $fiche->contenu === array([indexSection = > [indexChoix1, ..., indexChoixN])
     *
     * Renvoie l'etat de la fiche
     * @return int
     */
    public function getStatut() : int
    {
        // Verification basique
        $notation = $this->contenu;
        if(null === $notation || [] === $notation)
        {
            return self::VAL_STATUT_NOUVELLE;
        }

        // Verification du statut
        $enCours  = false;
        $complete = true;
        foreach($notation as $indexSection => $criteres)
        {
            foreach($criteres as $indexChoix)
            {
                // Si un choix est bien present
                if(Constantes::INDEX_CHOIX_VIDE !== $indexChoix)
                {
                    $enCours = true;
                }

                // Si un choix n'a pas ete initialise
                if(Constantes::INDEX_CHOIX_VIDE === $indexChoix)
                {
                    $complete = false;
                }

                // On casse sort tout de suite si la fiche est en cours
                if( $enCours && ! $complete)
                {
                    return self::VAL_STATUT_EN_COURS;
                }
            }
        }

        if($complete)
        {
            return self::VAL_STATUT_COMPLETE;
        }
        return self::VAL_STATUT_NOUVELLE;
    }

    /**
     * @variable array contenu : Variable privee representant le contenu de la fiche
     *
     * @return float La note finale de la fiche
     */
    public function getNote() : float
    {
        // Verification basique
        $note = 0.0;
        $notation = $this->contenu;
        if(null === $notation || [] === $notation)
        {
            return $note;
        }

        // Calcul de la note
        $sections = $this->modele->sections;
        foreach($notation as $indexSection => $criteres)
        {
            $section = $sections->get($indexSection);
            $note    += $section->getNoteSection($criteres);
        }

        return $note;
    }
}
