<?php

namespace Amghrby\Automation\Actions;

class DynamicUpdateActionHandler implements ActionHandlerInterface
{
    public function handle($model, $params)
    {
        if ($model instanceof \Illuminate\Database\Eloquent\Model) {
            $attributes = $params['attributes'] ?? [];
            $model->update($attributes);
        }
    }
}