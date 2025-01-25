<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $category = $this->category;
        $product_detail = $this->product_detail;
        $product_stock = $this->stock;
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code_item' => $this->code_item,
            'description' => $this->description,
            'category' => $category,
            'detail_product' => $product_detail,
            'stock' => $product_stock,
            'crated_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
