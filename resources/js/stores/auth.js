import { defineStore } from "pinia";

export const useAuthStore = defineStore("auth", {
    state: () => ({
        token: localStorage.getItem("authToken") || null,
    }),
    getters: {
        isAuthenticated: (state) => !!state.token,
    },
    actions: {
        login(token) {
            this.token = token;
            localStorage.setItem("authToken", token);
        },
        logout() {
            this.token = null;
            localStorage.removeItem("authToken");
        },
    },
});
