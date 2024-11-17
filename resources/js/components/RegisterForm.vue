<template>
    <form @submit.prevent="submitForm" class="space-y-4">
        <div>
            <label for="name" class="block text-sm font-medium">Name</label>
            <input
                id="name"
                v-model="name"
                type="text"
                class="mt-1 block w-full border rounded p-2"
                :class="{ 'border-red-500': errors.name }"
            />
            <p v-if="errors.name" class="text-red-500 text-sm mt-1">{{ errors.name }}</p>
        </div>
        <div>
            <label for="email" class="block text-sm font-medium">Email</label>
            <input
                id="email"
                v-model="email"
                type="email"
                class="mt-1 block w-full border rounded p-2"
                :class="{ 'border-red-500': errors.email }"
            />
            <p v-if="errors.email" class="text-red-500 text-sm mt-1">{{ errors.email }}</p>
        </div>
        <div>
            <label for="password" class="block text-sm font-medium">Password</label>
            <input
                id="password"
                v-model="password"
                type="password"
                class="mt-1 block w-full border rounded p-2"
                :class="{ 'border-red-500': errors.password }"
            />
            <p v-if="errors.password" class="text-red-500 text-sm mt-1">{{ errors.password }}</p>
        </div>
        <div v-if="generalError" class="text-red-500 text-sm mb-2">{{ generalError }}</div>
        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded">
            Register
        </button>
        <div v-if="successMessage" class="text-green-500 text-sm mt-2">{{ successMessage }}</div>
    </form>
</template>

<script>
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";

export default {
    name: "RegisterForm",
    setup() {
        const name = ref("");
        const email = ref("");
        const password = ref("");
        const errors = ref({});
        const generalError = ref("");
        const successMessage = ref("");
        const router = useRouter();

        const validateFields = () => {
            errors.value = {};
            let isValid = true;

            if (!name.value.trim()) {
                errors.value.name = "Name is required.";
                isValid = false;
            }

            if (!email.value.trim()) {
                errors.value.email = "Email is required.";
                isValid = false;
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
                errors.value.email = "Invalid email address.";
                isValid = false;
            }

            if (!password.value.trim()) {
                errors.value.password = "Password is required.";
                isValid = false;
            } else if (password.value.length < 8) {
                errors.value.password = "Password must be at least 8 characters.";
                isValid = false;
            }

            return isValid;
        };

        const submitForm = async () => {
            generalError.value = "";
            successMessage.value = "";

            if (!validateFields()) {
                return;
            }

            try {
                const response = await fetch("/api/register", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({
                        name: name.value,
                        email: email.value,
                        password: password.value,
                    }),
                });

                if (!response.ok) {
                    const errorResponse = await response.json();
                    if (errorResponse.errors) {
                        errors.value = errorResponse.errors;
                    } else {
                        generalError.value = errorResponse.message || "Registration failed.";
                    }
                    return;
                }

                const data = await response.json();
                localStorage.setItem("authToken", data.token); // Armazena o token no localStorage
                successMessage.value = "Registration successful! Redirecting to login...";
                setTimeout(() => {
                    router.push("/login"); // Redireciona para login após sucesso
                }, 3000);

                // Reset form fields
                name.value = "";
                email.value = "";
                password.value = "";
            } catch (error) {
                generalError.value = "An error occurred. Please try again later.";
                console.error("Error submitting form:", error);
            }
        };

        const checkToken = () => {
            const token = localStorage.getItem("token");
            if (token) {
                router.push("/dashboard"); // Redireciona para o dashboard se houver token
            }
        };

        onMounted(checkToken); // Verifica o token ao montar o componente

        return {
            name,
            email,
            password,
            errors,
            generalError,
            successMessage,
            submitForm,
        };
    },
};
</script>
