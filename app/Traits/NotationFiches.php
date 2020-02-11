<?php

namespace App\Traits;

trait NotationFiches
{

    /**
     * @variable array contenu : Variable privee representant le contenu de la fiche
     *
     * Renvoie l'etat de la fiche
     * @return int
     */
    public function getStatut() : int
    {
        $enCours  = false;
        $complete = true;

        // Verification basique
        $notation = $this->contenu;
        if(null === $notation || [] === $notation)
        {
            return self::VAL_STATUT_NOUVELLE;
        }

        // Verification du statut
        $sections = $this->modele->sections;
        foreach($notation as $indexSection => $criteres)
        {
            foreach($criteres as $indexChoix)
            {
                if(-1 !== $indexChoix)
                {
                    $enCours = true;
                }
                if(-1 === $indexChoix)
                {
                    $complete = false;
                }
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
            foreach($criteres as $indexChoix)
            {
                if(-1 !== $indexChoix)
                {
                    $note += $section->getPoints($indexChoix);
                }
            }
        }

        return $note;
    }
}
