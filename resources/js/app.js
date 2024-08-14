import './bootstrap.bundle';
import '../css/bootstrap.css';
import '../css/app.css';
import {createApp} from "vue/dist/vue.esm-bundler"
import MainComponent from "@/components/MainComponent.vue";
import router from "@/router.js";
import {store} from "@/store.js";
const app = createApp(MainComponent);
app.use(router);
app.use(store);
app.mount('#app');
