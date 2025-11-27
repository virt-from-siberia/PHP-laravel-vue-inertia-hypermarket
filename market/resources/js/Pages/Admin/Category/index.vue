<template>
    <AdminLayout>
        <div>
            <h1>Categories</h1>
            <div v-if="categories.length > 0">
                <ul>
                    <li v-for="category in categories" :key="category.id">
                        {{ category.title }}
                    </li>
                </ul>
            </div>
            <div v-else>
                <p>No categories found</p>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';

defineProps({
    categories: {
        type: Array,
        default: () => [],
    },
});
</script>

<style scoped></style>
