import { createApp } from "vue";
import App from "./App.vue";
import router from "./routes/index.js";
import "./index.css"; // Tailwind CSS

createApp(App).use(router).mount("#app");
