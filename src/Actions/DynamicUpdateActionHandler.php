<?php

namespace Amghrby\Automation\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class DynamicUpdateActionHandler implements ActionHandlerInterface
{
    public function handle($model, $params)
    {
        Log::info("Dynamic Update" . json_encode($model) . json_encode($params));
        if ($model instanceof Model) {
            Log::info("Dynamic Update model is instance of Model");
            $params = json_decode($params, true);
            $attributes = $params['attributes'] ?? [];
            Log::info("Dynamic Update attributes ". json_encode($attributes));
            $model->update($attributes);
            Log::info("Dynamic Update updated model ". json_encode($model));
        }
    }
}
