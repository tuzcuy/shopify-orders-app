<div class="container mt-5">
    <h1 class="mb-4">Orders List</h1>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Customer Email</th>
                <th>Total Amount</th>
                <th>Order ID</th>
                <th>Order Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
                <tr>
                    <td>{{ $order->customer_email }}</td>
                    <td>${{ number_format($order->total_amount, 2) }}</td>
                    <td>{{ $order->shopify_order_id }}</td>
                    <td>{{ \Carbon\Carbon::parse($order->order_date)->format('M d, Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No orders found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
