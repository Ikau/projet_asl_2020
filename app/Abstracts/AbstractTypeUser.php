<?php

namespace App\Abstracts;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractTypeUser extends Model
{
    abstract public function users();
}
