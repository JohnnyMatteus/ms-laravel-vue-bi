<template>
    <AuthLayout>
        <LoginForm />
    </AuthLayout>
</template>

<script>
import AuthLayout from "../layouts/AuthLayout.vue";
import LoginForm from "../components/LoginForm.vue";

export default {
    name: "LoginView",
    components: {AuthLayout, LoginForm},
};
</script>
