<?php

namespace Amghrby\Automation\Conditions;

use Illuminate\Support\Facades\Log;

class ConditionEvaluator
{
    public function evaluate($conditions, $context)
    {
        Log::info('Evaluating condition' . $context . json_encode($conditions));
        foreach ($conditions as $condition) {
            if (!$this->evaluateCondition($condition, $context)) {
                Log::info('Condition failed', [
                    'field' => $condition->field,
                    'operator' => $condition->operator,
                    'value' => $condition->value,
                ]);
                return false;
            }
        }

        Log::info('All conditions passed');
        return true;
    }

    protected function evaluateCondition($condition, $context)
    {
        Log::info('Evaluating condition with context: ' . $context . '' . json_encode($condition));
        switch ($condition->operator) {
            case '=':
                return $context[$condition->field] == $condition->value;
            case '>':
                return $context[$condition->field] > $condition->value;
            case '<':
                return $context[$condition->field] < $condition->value;
            default:
                break;
        }
        return false;
    }
}
