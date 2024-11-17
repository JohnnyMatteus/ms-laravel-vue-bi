import { createApp } from "vue";
import App from "./App.vue";
import router from "./routes/index.js";
import { createPinia } from "pinia";
import "./../css/app.css"; // Tailwind CSS
import Chart from "chart.js/auto";

const app = createApp(App);
app.config.globalProperties.$Chart = Chart;
app.use(createPinia());
app.use(router);
app.mount("#app");
