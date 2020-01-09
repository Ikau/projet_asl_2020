<?php

namespace App\Abstracts;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractUserType extends Model
{
    abstract public function users();
}
