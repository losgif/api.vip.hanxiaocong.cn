<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SchoolApplicationCollection extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'school_id' => $this->school_id,
            'application_id' => $this->application_id,
            'name' => $this->name,
            'type' => $this->type,
            'description' => $this->description,
            'logo' => $this->logo,
            'config' => $this->config,
            'keyword' => SchoolApplicationKeywordCollection::collection($this->keyword),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
