<?php

namespace Amghrby\Automation\Http\Controllers;

use Amghrby\Automation\Models\Workflow;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class WorkflowController extends Controller
{
    public function index()
    {
        return Workflow::with(['triggers.conditions', 'actions'])->get();
    }

    public function store(Request $request)
    {
        $workflow = Workflow::create($request->only('name', 'description'));
        $this->attachTriggersAndActions($workflow, $request);
        return response()->json($workflow, 201);
    }

    public function show($id)
    {
        return Workflow::with(['triggers.conditions', 'actions'])->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $workflow = Workflow::findOrFail($id);
        $workflow->update($request->only('name', 'description'));
        $this->attachTriggersAndActions($workflow, $request);
        return response()->json($workflow);
    }

    public function destroy($id)
    {
        Workflow::destroy($id);
        return response()->json(null, 204);
    }

    protected function attachTriggersAndActions(Workflow $workflow, Request $request)
    {
        $workflow->triggers()->delete();
        $workflow->actions()->delete();

        foreach ($request->get('triggers', []) as $triggerData) {
            $trigger = $workflow->triggers()->create($triggerData);
            foreach ($triggerData['conditions'] as $conditionData) {
                $trigger->conditions()->create($conditionData);
            }
        }

        foreach ($request->get('actions', []) as $actionData) {
            $workflow->actions()->create($actionData);
        }
    }
}
