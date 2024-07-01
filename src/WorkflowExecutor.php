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

    public function execute(Workflow $workflow): void
    {
        foreach ($workflow->triggers as $trigger) {
            $handler = $this->resolveHandler($trigger, 'triggers');
            if ($handler && $this->shouldExecuteTrigger($trigger)) {
                $handler->handle(json_decode($trigger->params, true));
                $this->executeActions($workflow->actions);
            }
        }
    }

    protected function resolveHandler($entity, $type)
    {
        $handlerClass = config("automations.{$type}.{$entity->type}");

        if (class_exists($handlerClass)) {
            return new $handlerClass();
        }

        return null;
    }

    protected function shouldExecuteTrigger($trigger): bool
    {
        $context = []; // Define context as needed
        return $this->conditionEvaluator->evaluate($trigger->conditions, $context);
    }

    protected function executeActions($actions): void
    {
        foreach ($actions as $action) {
            $handler = $this->resolveHandler($action, 'actions');
            if ($handler && $handler instanceof ActionHandlerInterface) {
                $params = $action->params;
                // Assuming $model is not available in this context
                $handler->handle(null, $params); // Pass $model if available
                Log::info('Action executed', [
                    'type' => $action->type,
                    'params' => $params,
                ]);
            }
        }
    }
}
