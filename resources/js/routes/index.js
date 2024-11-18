import { createRouter, createWebHistory } from "vue-router";
import LoginView from "../views/LoginView.vue";
import RegisterView from "../views/RegisterView.vue";
import DashboardView from "../views/DashboardView.vue";
import NotFoundView from "../views/NotFoundView.vue";
import UserRequestsView from "../views/UserRequestsView.vue"

const routes = [
    {
        path: "/login",
        name: "login",
        component: LoginView,
        meta: { requiresAuth: false },
    },
    {
        path: "/register",
        name: "register",
        component: RegisterView,
        meta: { requiresAuth: false },
    },
    {
        path: "/dashboard",
        name: "dashboard",
        component: DashboardView,
        meta: { requiresAuth: true },
    },
    {
        path: "/dashboard/details/:chartType",
        name: "details",
        component: () => import("../views/DetailsView.vue"),
        props: true,
        meta: { requiresAuth: true },
    },
    {
        path: "/user-requests",
        name: "user-requests",
        component: UserRequestsView,
        meta: { requiresAuth: true },
    },
    {
        path: "/",
        redirect: "/login", // Redirecionar para login por padrão
    },
    {
        path: "/:pathMatch(.*)*",
        name: "NotFound",
        component: NotFoundView,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

// Global Navigation Guard
router.beforeEach((to, from, next) => {
    const token = localStorage.getItem("authToken"); // Obtém o token do localStorage
    const requiresAuth = to.meta.requiresAuth;

    if (requiresAuth && !token) {
        // Redirecionar para login se a rota requer autenticação e o token está ausente
        next({ name: "login" });
    } else if (!requiresAuth && token && (to.name === "login" || to.name === "register")) {
        // Redirecionar para dashboard se o usuário já está autenticado
        next({ name: "dashboard" });
    } else {
        next(); // Prosseguir normalmente
    }
});

export default router;
