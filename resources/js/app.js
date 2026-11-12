import { createApp } from 'vue';
import OrdersApp from './components/OrdersApp.vue';

const app = createApp({});
app.component('orders-app', OrdersApp);
app.mount('#app');
