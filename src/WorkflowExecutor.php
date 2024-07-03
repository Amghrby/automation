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
        foreach ($workflow->triggers as $trigger) {
            $handler = $this->resolveHandler($trigger, 'triggers');
            if ($handler && $this->shouldExecuteTrigger($trigger)) {
                Log::info('Trigger '. $trigger.'should execute');
                $handler->handle($trigger->params);
                Log::info('Trigger executed');
                $this->executeActions($workflow->actions, $model);
                Log::info('Actions executed');
            }
        }
    }

    protected function resolveHandler($entity, $type)
    {
        $handlerClass = config("workflows.{$type}.{$entity->type}");
        Log::info('Resolving handler for '. $type. ': '. $entity->type.' with class '. $handlerClass);
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
        foreach ($actions as $action) {
            $handler = $this->resolveHandler($action, 'actions');
            Log::info('Action ' . $action . ' handler ' . json_encode($handler));
            if ($handler instanceof ActionHandlerInterface) {
                Log::info('Handler ' . json_encode($handler) . ' is instance of ActionHandlerInterface');
                $handler->handle($model, $action->params); // Pass $model if available
                Log::info('Action executed', [
                    'type' => $action->type,
                    'params' => $action->params,
                ]);
            }
        }
    }
}
