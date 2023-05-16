import {createApp} from "vue";
import "./bootstrap"
import App from './App.vue'
import router from "./router";
import ElementPlus from 'element-plus'
import 'element-plus/theme-chalk/index.css'
import "normalize.css/normalize.css";
import { createPinia } from 'pinia'
import locale from 'element-plus/es'
const pinia = createPinia();
const app = createApp(App);
app.use(pinia);
app.use(ElementPlus,{locale});
app.use(router)
    .mount('#app');
