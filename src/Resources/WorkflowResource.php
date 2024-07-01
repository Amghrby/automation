<?php

namespace Amghrby\Automation\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WorkflowResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'description' => $this->description,
            'triggers' => TriggerResource::collection($this->triggers),
            'actions' => ActionResource::collection($this->actions),
        ];
    }
}