<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ShopifyService;
use App\Models\Order;

class ShopifyController extends Controller
{
    protected $shopifyService;

    public function __construct(ShopifyService $shopifyService)
    {
        $this->shopifyService = $shopifyService;
    }

    // Fetch orders from Shopify and persist them
    public function fetchAndSaveOrders()
    {
        try {
            $orders = $this->shopifyService->fetchOrders(now()->subYear()->toIso8601String());

            foreach ($orders as $order) {
                Order::updateOrCreate(
                    ['shopify_order_id' => $order['id']],
                    [
                        'customer_email' => $order['email'] ?? 'N/A', // 'N/A' when empty
                        'total_amount' => $order['total_price'],
                        'order_date' => $order['created_at'],
                    ]
                );
            }

            return response()->json(['message' => 'Orders fetched and saved successfully!']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Return all orders as JSON (consumed by the Vue frontend)
    public function getOrdersList()
    {
        $orders = Order::select('customer_email', 'total_amount', 'shopify_order_id', 'order_date')->get();
        return response()->json($orders);
    }

    // Legacy Blade listing (superseded by the Vue frontend)
    public function listOrders()
    {
        $orders = Order::all();
        return view('orders.list', compact('orders'));
    }
    public function showOrdersPage()
    {
        return view('orders.orders'); // renders orders.blade.php
    }

}
