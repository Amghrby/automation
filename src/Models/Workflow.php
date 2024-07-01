<?php

namespace Amghrby\Automation\Models;

use Illuminate\Database\Eloquent\Model;

class Workflow extends Model
{
    protected $fillable = ['name', 'description'];

    public function triggers()
    {
        return $this->hasMany(Trigger::class);
    }

    public function actions()
    {
        return $this->hasMany(Action::class);
    }
}