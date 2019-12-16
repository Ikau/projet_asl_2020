<?php

namespace App\Abstracts;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractEnseignant extends Model
{
    abstract public function responsable_option();
    abstract public function responsable_repartement();
    abstract public function soutenances_candide();
    abstract public function soutenances_referent();
    abstract public function stages();
}

