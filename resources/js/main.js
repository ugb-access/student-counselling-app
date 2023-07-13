/* eslint-disable import/order */
import "@/@iconify/icons-bundle";
import App from "@/App.vue";
import vuetify from "@/plugins/vuetify";
import { loadFonts } from "@/plugins/webfontloader";
import router from "@/router";
import "@core-scss/template/index.scss";
import "@layouts/styles/index.scss";
import "vue3-toastify/dist/index.css";
import "@styles/styles.scss";
import { createPinia } from "pinia";
import { createApp } from "vue";
import Toast from "vue3-toastify";

loadFonts();
// Create vue app
const app = createApp(App);

// Use plugins
app.use(vuetify);
app.use(createPinia());
app.use(router);
app.use(Toast, {
    timeout: 5000,
    closeOnClick: true,
});

// Mount vue app
app.mount("#app");
