<?php


namespace App\Http\Services;

use App\Models\Product;
use Illuminate\Http\Exceptions\HttpResponseException;


class ProductService
{
    public Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function index()
    {
        $products = $this->product->where('user_id', auth()->id())->paginate(10);
        return $products;
    }

    public function store($data)
    {
        $product = $this->product->create($data);
        return $product;
    }

    public function update($product, $data)
    {
        $product->update($data);
        $product->refresh();
        return $product;
    }

    public function delete($product)
    {
        if ($product->user_id != auth()->id())
            throw new HttpResponseException(response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401));
        $product->delete();
    }
}
