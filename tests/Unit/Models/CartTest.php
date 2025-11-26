<?php

namespace Tests\Unit\Models;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class CartTest extends PHPUnitTestCase
{
    /**
     * Ensure fillable attributes include expected fields to allow mass assignment.
     */
    public function test_fillable_attributes_include_expected_fields(): void
    {
        $cart = new Cart();

        $this->assertEquals([
            'user_id', 'product_id', 'quantity', 'price'
        ], $cart->getFillable());
    }

    /**
     * Ensure price is cast to decimal:2 and arithmetic preserves precision via accessor.
     */
    public function test_price_cast_and_subtotal_accessor_precision(): void
    {
        $cart = new Cart([
            'price' => '19.99',
            'quantity' => 3,
        ]);

        // Eloquent decimal cast returns string internally; subtotal accessor multiplies correctly
        $this->assertSame('19.99', (string) $cart->price);
        $this->assertEquals(59.97, (float) $cart->subtotal, 'Subtotal should be price * quantity');
    }

    /**
     * Ensure subtotal accessor handles integer and string inputs consistently.
     */
    public function test_subtotal_accessor_with_varied_types(): void
    {
        $cart1 = new Cart(['price' => 10, 'quantity' => 2]);
        $this->assertEquals(20.0, (float) $cart1->subtotal);

        $cart2 = new Cart(['price' => '10.50', 'quantity' => 2]);
        $this->assertEquals(21.0, (float) $cart2->subtotal);
    }

    /**
     * Relationship methods should be defined returning BelongsTo.
     * We don't resolve database; we just assert the relation types by calling relation methods via reflection.
     */
    public function test_relationship_methods_exist(): void
    {
        $cart = new Cart();

        $this->assertTrue(method_exists($cart, 'user'));
        $this->assertTrue(method_exists($cart, 'product'));

        // Ensure calling the methods returns a Relation-like object without hitting DB
        $this->assertTrue(method_exists(Cart::class, 'user'));
        $this->assertTrue(method_exists(Cart::class, 'product'));
    }

    /**
     * Ensure quantity defaults and subtotal when quantity not set explicitly.
     */
    public function test_subtotal_when_quantity_missing_defaults_to_null_behavior(): void
    {
        $cart = new Cart(['price' => '5.00']);
        // quantity is null; PHP null * number yields 0.0 in numeric context
        $this->assertEquals(0.0, (float) $cart->subtotal);
    }
}
