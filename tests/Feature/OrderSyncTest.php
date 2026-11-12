<?php

use App\Models\Order;
use Illuminate\Support\Facades\Http;

const SHOPIFY_ORDERS_URL = 'https://test-store.myshopify.com/admin/api/2023-04/orders.json*';

function shopifyPayload(): array
{
    return [
        'orders' => [
            [
                'id' => 5001,
                'email' => 'jane@example.com',
                'total_price' => '149.90',
                'created_at' => '2024-11-20T10:15:00+00:00',
            ],
            [
                'id' => 5002,
                'email' => '', // Shopify returns an empty email for POS/guest orders
                'total_price' => '35.00',
                'created_at' => '2024-11-21T14:30:00+00:00',
            ],
        ],
    ];
}

it('lists saved orders as json', function () {
    Order::create([
        'customer_email' => 'listed@example.com',
        'total_amount' => '12.34',
        'shopify_order_id' => '9001',
        'order_date' => '2024-10-01 09:00:00',
    ]);

    $this->getJson('/orders-list')
        ->assertOk()
        ->assertJsonCount(1)
        ->assertJsonFragment([
            'customer_email' => 'listed@example.com',
            'shopify_order_id' => '9001',
        ]);
});

it('fetches orders from shopify and persists the mapped fields', function () {
    Http::fake([SHOPIFY_ORDERS_URL => Http::response(shopifyPayload())]);

    $this->getJson('/fetch-orders')
        ->assertOk()
        ->assertJson(['message' => 'Orders fetched and saved successfully!']);

    expect(Order::count())->toBe(2);

    $order = Order::where('shopify_order_id', '5001')->firstOrFail();
    expect($order->customer_email)->toBe('jane@example.com')
        ->and((float) $order->total_amount)->toBe(149.90);

    // Empty customer email falls back to the N/A placeholder
    expect(Order::where('shopify_order_id', '5002')->firstOrFail()->customer_email)->toBe('N/A');

    // The request carried the access token header to the configured store
    Http::assertSent(fn ($request) => $request->hasHeader('X-Shopify-Access-Token', 'test-token'));
});

it('does not duplicate orders when fetching twice', function () {
    Http::fake([SHOPIFY_ORDERS_URL => Http::response(shopifyPayload())]);

    $this->getJson('/fetch-orders')->assertOk();
    $this->getJson('/fetch-orders')->assertOk();

    expect(Order::count())->toBe(2);
});

it('updates an existing order instead of inserting a second row', function () {
    Http::fake([
        SHOPIFY_ORDERS_URL => Http::sequence()
            ->push(shopifyPayload())
            ->push([
                'orders' => [
                    [
                        'id' => 5001,
                        'email' => 'jane@example.com',
                        'total_price' => '199.90', // order was edited in Shopify
                        'created_at' => '2024-11-20T10:15:00+00:00',
                    ],
                ],
            ]),
    ]);

    $this->getJson('/fetch-orders')->assertOk();
    $this->getJson('/fetch-orders')->assertOk();

    expect(Order::where('shopify_order_id', '5001')->count())->toBe(1)
        ->and((float) Order::where('shopify_order_id', '5001')->firstOrFail()->total_amount)->toBe(199.90);
});

it('returns a 500 json error when the shopify api rejects the request', function () {
    Http::fake([SHOPIFY_ORDERS_URL => Http::response(['errors' => 'Invalid API key'], 401)]);

    $this->getJson('/fetch-orders')
        ->assertStatus(500)
        ->assertJsonStructure(['error']);

    expect(Order::count())->toBe(0);
});
