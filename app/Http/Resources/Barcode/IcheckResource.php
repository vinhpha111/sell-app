<?php

namespace App\Http\Resources\Barcode;

use Illuminate\Http\Resources\Json\JsonResource;

class IcheckResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $img = null;
        $medias = $this['media'];
        foreach ($medias as $media) {
            if ($media['type'] === 'image') {
                $img = $media['content'];
                break;
            }
        }
        return [
            'name' => $this['name'],
            'img' => $img
        ];
    }
}
