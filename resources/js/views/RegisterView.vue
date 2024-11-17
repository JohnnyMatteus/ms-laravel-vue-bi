<template>
    <AuthLayout>
        <RegisterForm />
    </AuthLayout>
</template>

<script>
import AuthLayout from "../layouts/AuthLayout.vue";
import RegisterForm from "../components/RegisterForm.vue";

export default {
    name: "RegisterView",
    components: {AuthLayout, RegisterForm},
};
</script>
