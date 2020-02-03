<?php

namespace App\Abstracts\Modeles\Fiches;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractQuestion extends Model
{
    /**
     * Renvoie la fiche liee a la question et ses choix via une relation Many-to-One
     * @return
     */
    abstract public function section();
}
