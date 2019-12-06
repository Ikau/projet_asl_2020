<?php


namespace App\Abstracts;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractContact extends Model
{
    abstract public function fiches_entreprise();
    abstract public function soutenances_mds();
    abstract public function stages_mds();
}
