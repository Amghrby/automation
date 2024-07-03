<?php

namespace Amghrby\Automation\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ActionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'params' => $this->params, // Convert JSON string to PHP array
            // Add more attributes as needed
        ];
    }
}