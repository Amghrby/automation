<?php

namespace Amghrby\Automation\Observers;

use Amghrby\Automation\WorkflowExecutor;
use Illuminate\Database\Eloquent\Model;
use Amghrby\Automation\Models\Workflow;
use Illuminate\Support\Facades\Log;

class GenericObserver
{

    public function handle(Model $model, string $event): void
    {
        Log::info("Observer" . get_class($model) . " " . $event);
        $workflows = Workflow::whereHas('triggers', function ($query) use ($model, $event) {
            $query->where('type', 'event')
                ->where('params->event_name', $event)
                ->where('params->model', get_class($model));
        })->get();
        Log::info('Event' . $event . 'triggered ' . count($workflows) . ' workflows');
        $executor = new WorkflowExecutor();

        foreach ($workflows as $workflow) {
            Log::info('Executing workflow '. $workflow->name);
            $executor->execute($workflow, $model);
            Log::info('Workflow executed');
        }
    }

    public function retrieved(Model $model): void
    {
        $this->handle($model, 'retrieved');
    }

    public function creating(Model $model): void
    {
        $this->handle($model, 'creating');
    }

    public function created(Model $model): void
    {
        $this->handle($model, 'created');
    }

    public function saving(Model $model): void
    {
        $this->handle($model, 'saving');
    }

    public function saved(Model $model): void
    {
        $this->handle($model, 'saved');
    }

    public function updating(Model $model): void
    {
        $this->handle($model, 'updating');
    }

    public function updated(Model $model): void
    {
        $this->handle($model, 'updated');
    }

    public function deleting(Model $model): void
    {
        $this->handle($model, 'deleting');
    }

    public function deleted(Model $model): void
    {
        $this->handle($model, 'deleted');
    }

    public function restoring(Model $model): void
    {
        $this->handle($model, 'restoring');
    }

    public function restored(Model $model): void
    {
        $this->handle($model, 'restored');
    }

}