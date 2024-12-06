<template>
    <div class="container mt-5">
        <h1 class="text-center mb-4 text-primary">Shopify Orders</h1>
        <div class="text-center mb-4">
            <button class="btn btn-success btn-lg" @click="fetchOrders">
                Fetch Orders
            </button>
        </div>
        <table v-if="orders.length > 0" class="table table-hover text-center">
            <thead class="table-dark">
                <tr>
                    <th>Customer Email</th>
                    <th>Total Amount</th>
                    <th>Order ID</th>
                    <th>Order Date</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="order in orders" :key="order.shopify_order_id">
                    <td>{{ order.customer_email }}</td>
                    <td>${{ order.total_amount }}</td>
                    <td>{{ order.shopify_order_id }}</td>
                    <td>{{ order.order_date }}</td>
                </tr>
            </tbody>
        </table>
        <div v-else class="alert alert-warning text-center">
            No orders found.
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            orders: [],
            loading: false,
        };
    },
    methods: {
        fetchOrders() {
            this.loading = true;
            axios
                .get("/fetch-orders")
                .then(() => axios.get("/orders-list"))
                .then((response) => {
                    this.orders = response.data;
                })
                .catch((error) => {
                    console.error(error);
                    alert("Failed to fetch orders. Please try again.");
                })
                .finally(() => {
                    this.loading = false;
                });
        },
    },
};
</script>

<style scoped>
h1 {
    color: #2c3e50;
}
</style>
