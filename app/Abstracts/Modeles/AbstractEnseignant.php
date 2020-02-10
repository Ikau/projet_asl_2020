<?php

namespace App\Abstracts\Modeles;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractEnseignant extends Model
{
    abstract public function responsable_option();
    abstract public function responsable_departement();
    abstract public function soutenances_candide();
    abstract public function soutenances_referent();
    abstract public function stages();
}

