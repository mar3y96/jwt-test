<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductCrudTest extends TestCase
{
    use RefreshDatabase, withFaker;

    public function setUp(): void
    {
        parent::setUp();
        $user = User::factory(1)->create()->first();
        $this->actingAs($user, 'api');
    }

    public function testCreateProduct()
    {
        $productData = [
            'name' => 'Product 1',
            'description' => 'This is a product 1',
            'price' => 20.33,
            'quantity' => 3,
            'user_id' => auth()->id()
        ];

        $response = $this->postJson('/api/products', $productData);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Product created successfully',
                'data' => [
                    'name' => 'Product 1',
                    'description' => 'This is a product 1',
                    'price' => 20.33,
                    'quantity' => 3,
                ]
            ]);
    }

    public function testGetProduct()
    {
        $product = Product::factory()->create();

        $response = $this->getJson('/api/products/' . $product->id);
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'product data',
            ]);
    }

    public function testUpdateProduct()
    {
        $product = Product::factory(1)->create(['user_id' => auth()->id()])->first();
        $updatedData = [
            'name' => 'Updated Product',
            'description' => 'This is an updated product',
            'price' => 19.99,
            'quantity' => 3
        ];
        $response = $this->putJson('/api/products/' . $product->id, $updatedData);
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Product updated successfully',
                'data' => [
                    'name' => 'Updated Product',
                    'description' => 'This is an updated product',
                    'price' => 19.99,
                    'quantity' => 3,
                ]
            ]);
    }

    public function testDeleteProduct()
    {
        $product = Product::factory(1)->create(['user_id' => auth()->id()])->first();

        $response = $this->deleteJson('/api/products/' . $product->id);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

}
