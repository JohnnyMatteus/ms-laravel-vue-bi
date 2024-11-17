<template>
    <div class="min-h-screen flex flex-col justify-center items-center bg-gray-100">
        <header class="bg-blue-500 text-white w-full py-4 text-center">
            <h1 class="text-xl font-bold">My App</h1>
        </header>
        <main class="flex-grow w-full max-w-md p-6 bg-white shadow-lg rounded-lg">
            <slot />
        </main>
    </div>
</template>

<script>
export default {
    name: "AuthLayout",
};
</script>
