<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InformationCollection extends JsonResource
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
            'id' => $request->id,
            'school_application_id' => $request->school_application_id,
            'extra' => json_decode($request->extra, true),
            'is_active' => $request->is_active,
            'created_at' => $request->created_at,
            'updated_at' => $request->updated_at,
        ];
    }
}
