<?php

namespace Amghrby\Automation\Models;

use Illuminate\Database\Eloquent\Model;

class Trigger extends Model
{
    protected $fillable = ['workflow_id', 'type', 'params'];

    public function workflow()
    {
        return $this->belongsTo(Workflow::class);
    }

    public function conditions()
    {
        return $this->hasMany(Condition::class);
    }
}
