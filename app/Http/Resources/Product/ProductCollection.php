<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request)
    {
        return  $this->collection->transform(function ($data) {
            return  [
                "id" => $data->id,
                "name" => $data->name,
                "quantity" => $data->quantity,
                "price" => $data->price,
                "user_id" => $data->user_id,
                'pagination' => $this->getPaginationMeta()
            ];
        });
    }

    private function getPaginationMeta()
    {
        return [
            'total' => $this->total(),
            'count' => $this->count(),
            'per_page' => $this->perPage(),
            'current_page' => $this->currentPage(),
            'total_pages' => $this->lastPage()
        ];
    }
}
