<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DataTableRS extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $datatable = $this;
        return [
            "draw" => $datatable['draw'],
            "iTotalRecords" => $datatable['total'],
            "iTotalDisplayRecords" => $datatable['total'],
            "aaData" => $datatable['data']
        ];
    }
}
