import { createApp } from 'vue';
import OrdersApp from './components/OrdersApp.vue'; // Bileşen yolu

const app = createApp({});
app.component('orders-app', OrdersApp); // Bileşeni kaydet
app.mount('#app'); // Vue'yi #app elementine bağla
