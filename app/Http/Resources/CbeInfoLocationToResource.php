<?php

namespace App\Http\Resources;

use App\CbeInfoLocationTo;

use Illuminate\Http\Resources\Json\JsonResource;

class CbeInfoLocationToResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return parent::toArray($request);

        return [
        // 'id' => $this->id,
        'name' => $this->name,
        // 'test' => 'This is just a test',
        // 'created_at' => $this->created_at,
        // 'updated_at' => $this->updated_at,
        ];
    }
}
