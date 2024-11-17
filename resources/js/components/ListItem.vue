<template>
    <li class="p-4 bg-white shadow rounded">
        <h3 class="font-bold">{{ item.name }}</h3>
        <p>{{ item.description }}</p>
    </li>
</template>

<script>
export default {
    name: "ListItem",
    props: {
        item: { type: Object, required: true },
    },
};
</script>
