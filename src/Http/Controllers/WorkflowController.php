<?php

namespace Amghrby\Automation\Http\Controllers;

use Amghrby\Automation\Models\Workflow;
use Amghrby\Automation\Resources\WorkflowResource;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class WorkflowController extends Controller
{
    public function index()
    {
        $workflows = Workflow::with(['triggers.conditions', 'actions'])->get();
        return response()->json(WorkflowResource::collection($workflows));
    }

    public function store(Request $request)
    {
        $workflow = Workflow::create($request->only('name', 'description'));
        $this->attachTriggersAndActions($workflow, $request);
        return response()->json(new WorkflowResource($workflow), 201);
    }

    public function show($id)
    {
        $workflow = Workflow::with(['triggers.conditions', 'actions'])->findOrFail($id);
        return new WorkflowResource($workflow);
    }

    public function update(Request $request, $id)
    {
        $workflow = Workflow::findOrFail($id);
        $workflow->update($request->only('name', 'description'));
        $this->attachTriggersAndActions($workflow, $request);
        return response()->json(new WorkflowResource($workflow));
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
