<?php

namespace App\Abstracts\Modeles;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractOption extends Model
{
    abstract public function departement();
    abstract public function etudiants();
    abstract public function responsable();
}
