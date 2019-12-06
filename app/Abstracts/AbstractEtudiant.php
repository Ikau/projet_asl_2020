<?php

namespace App\Abstracts;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractEtudiant extends Model
{
    abstract public function soutenances();
    abstract public function stages();
}

