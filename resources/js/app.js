import './bootstrap';
import router from './Plugins/Router';
import { createApp } from 'vue';
import Home from './home.vue'
import 'bootstrap/dist/css/bootstrap.min.css';
import '@fortawesome/fontawesome-free/css/all.min.css';
import 'vue3-toastify/dist/index.css';
import VueTheMask from 'vue-the-mask';
const app = createApp(Home);

app.use(router);
app.use(VueTheMask);
app.mount("#app");
