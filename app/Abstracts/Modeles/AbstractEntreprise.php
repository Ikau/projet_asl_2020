<?php

namespace App\Abstracts\Modeles;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractEntreprise extends Model
{
    abstract public function stages();
}

