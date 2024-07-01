<?php

namespace Amghrby\Automation\Actions;

class DynamicNotifyActionHandler implements ActionHandlerInterface
{
    public function handle($model, $params)
    {
        if (method_exists($model, 'notify')) {
            $notificationClass = $params['notification'];
            $model->notify(new $notificationClass($params['data']));
        }
    }
}