<?php


namespace App\Abstracts;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractDepartement extends Model
{
    abstract public function etudiants();
    abstract public function responsable();
}
