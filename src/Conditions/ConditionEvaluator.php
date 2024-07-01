<?php

namespace Amghrby\Automation\Conditions;

class ConditionEvaluator
{
    public function evaluate($conditions, $context)
    {
        foreach ($conditions as $condition) {
            if (!$this->evaluateCondition($condition, $context)) {
                return false;
            }
        }
        return true;
    }

    protected function evaluateCondition($condition, $context)
    {
        switch ($condition->operator) {
            case '=':
                return $context[$condition->field] == $condition->value;
            case '>':
                return $context[$condition->field] > $condition->value;
            case '<':
                return $context[$condition->field] < $condition->value;
            // Add more operators as needed
        }
        return false;
    }
}
