<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ShopifyService
{
    protected $apiKey;
    protected $accessToken;
    protected $store;

    public function __construct()
    {
        $this->apiKey = env('SHOPIFY_API_KEY');
        $this->accessToken = env('SHOPIFY_ACCESS_TOKEN');
        $this->store = env('SHOPIFY_STORE');
    }

    public function fetchOrders($sinceDate = null)
    {
        $url = "https://{$this->store}/admin/api/2023-04/orders.json";
        $headers = [
            'X-Shopify-Access-Token' => $this->accessToken,
        ];

        $params = [
            'status' => 'any',
            'limit' => 250,
        ];

        if ($sinceDate) {
            $params['created_at_min'] = $sinceDate;
        }

        $response = Http::withHeaders($headers)->get($url, $params);

        if ($response->successful()) {
            $orders = $response->json('orders');

            // E-posta bilgisi olmayan müşteriler için varsayılan değer ekle
            return array_map(function ($order) {
                return [
                    'id' => $order['id'] ?? null,
                    'email' => !empty($order['email']) ? $order['email'] : 'N/A', // Boşsa 'N/A' yaz
                    'total_price' => $order['total_price'] ?? '0.00',
                    'created_at' => $order['created_at'] ?? null,
                ];
            }, $orders);
        }

        throw new \Exception('Failed to fetch orders: ' . $response->body());
    }
}
