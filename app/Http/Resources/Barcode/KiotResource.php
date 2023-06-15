<?php

namespace App\Http\Resources\Barcode;

use Illuminate\Http\Resources\Json\JsonResource;

class KiotResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'name' => $this['content'],
            'img' => $this['img']
        ];
    }
}
