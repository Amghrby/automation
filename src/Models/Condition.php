<?php

namespace Amghrby\Automation\Models;

use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
    protected $fillable = ['trigger_id', 'field', 'operator', 'value'];

    public function trigger()
    {
        return $this->belongsTo(Trigger::class);
    }
}
