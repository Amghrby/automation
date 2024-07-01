<?php

namespace Amghrby\Automation\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TriggerResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'params' => json_decode($this->params, true), // Convert JSON string to PHP array
            // Add more attributes as needed
        ];
    }
}