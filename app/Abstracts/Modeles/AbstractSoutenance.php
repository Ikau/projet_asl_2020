<?php

namespace App\Abstracts\Modeles;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractSoutenance extends Model
{
    abstract public function candide();
    abstract public function contact_entreprise();
    abstract public function etudiant();
    abstract public function fiche();
    abstract public function referent();
    abstract public function stage();
}

