<?php

namespace App\Abstracts;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractStage extends Model
{
    abstract public function entreprise();
    abstract public function etudiant();
    //abstract public function fiche_entreprise();
    //abstract public function fiche_rapport();
    //abstract public function fiche_soutenance();
    //abstract public function fiche_synthese();
    //abstract public function maitre_de_stage();
    abstract public function referent();
}

