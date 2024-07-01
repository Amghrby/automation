<?php

namespace Amghrby\Automation\Models;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    protected $fillable = ['workflow_id', 'type', 'params'];

    public function workflow()
    {
        return $this->belongsTo(Workflow::class);
    }
}
