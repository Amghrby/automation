<?php

namespace Amghrby\Automation;

use Amghrby\Automation\Models\Workflow;
use Amghrby\Automation\Triggers\TriggerHandlerInterface;
use Amghrby\Automation\Actions\ActionHandlerInterface;
use Amghrby\Automation\Conditions\ConditionEvaluator;
use Illuminate\Support\Facades\Log;

class WorkflowExecutor
{
    protected ConditionEvaluator $conditionEvaluator;

    public function __construct()
    {
        $this->conditionEvaluator = new ConditionEvaluator();
    }

    public function execute(Workflow $workflow, $model): void
    {
        Log::info('Executing workflow '. $workflow->name. ' with model ' . json_encode($model));
        foreach ($workflow->triggers as $trigger) {
            $handler = $this->resolveHandler($trigger, 'triggers');
            Log::info('Trigger '. $trigger. ' handler '. json_encode($handler));
            if ($handler && $this->shouldExecuteTrigger($trigger)) {
                Log::info('Trigger '. $trigger.'should execute');
                $handler->handle(json_decode($trigger->params, true));
                Log::info('Trigger executed');
                $this->executeActions($workflow->actions);
                Log::info('Actions executed');
            }
        }
    }

    protected function resolveHandler($entity, $type)
    {
        $handlerClass = config("automations.{$type}.{$entity->type}");
        Log::info('Resolving handler for '. $type. ': '. $entity->type.'with class '. $handlerClass);
        if (class_exists($handlerClass)) {
            Log::info('Handler '. $handlerClass.'exists');
            return new $handlerClass();
        }

        Log::info('Handler '. $handlerClass.'not found');
        return null;
    }

    protected function shouldExecuteTrigger($trigger): bool
    {
        $context = []; // Define context as needed
        return $this->conditionEvaluator->evaluate($trigger->conditions, $context);
    }

    protected function executeActions($actions, $model): void
    {
        Log::info('Executing actions' . json_encode($actions). ' with model ' . json_encode($model));
        foreach ($actions as $action) {
            $handler = $this->resolveHandler($action, 'actions');
            Log::info('Action ' . $action . ' handler ' . json_encode($handler));
            if ($handler instanceof ActionHandlerInterface) {
                Log::info('Handler ' . json_encode($handler) . ' is instance of ActionHandlerInterface');
                $params = $action->params;
                // Assuming $model is not available in this context
                $handler->handle($model, $params); // Pass $model if available
                Log::info('Action executed', [
                    'type' => $action->type,
                    'params' => $params,
                ]);
            }
        }
    }
}
