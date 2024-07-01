<?php

namespace Amghrby\Automation\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;
use Amghrby\Automation\Observers\GenericObserver;

class ObserverServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Event::listen('eloquent.*: *', function ($eventName, array $data) {
            $model = $data[0];
            if ($model instanceof Model) {
                $observer = app(GenericObserver::class);
                $event = explode(': ', $eventName)[0];

                switch ($event) {
                    case 'eloquent.retrieved':
                        $observer->retrieved($model);
                        break;
                    case 'eloquent.creating':
                        $observer->creating($model);
                        break;
                    case 'eloquent.created':
                        $observer->created($model);
                        break;
                    case 'eloquent.updating':
                        $observer->updating($model);
                        break;
                    case 'eloquent.updated':
                        $observer->updated($model);
                        break;
                    case 'eloquent.saving':
                        $observer->saving($model);
                        break;
                    case 'eloquent.saved':
                        $observer->saved($model);
                        break;
                    case 'eloquent.deleting':
                        $observer->deleting($model);
                        break;
                    case 'eloquent.deleted':
                        $observer->deleted($model);
                        break;
                    case 'eloquent.restoring':
                        $observer->restoring($model);
                        break;
                    case 'eloquent.restored':
                        $observer->restored($model);
                        break;
                    default:
                        break;
                }
            }
        });
    }
}