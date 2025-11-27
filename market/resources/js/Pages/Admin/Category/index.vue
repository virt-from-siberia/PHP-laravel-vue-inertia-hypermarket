<template>
    <AdminLayout>
        <div class="p-6">
            <h1 class="text-2xl font-bold mb-4">Категории</h1>
            <div v-if="categories && categories.length > 0">
                <ul class="space-y-2">
                    <li v-for="category in categories" :key="category.id" class="p-3 bg-white rounded shadow">
                        {{ category.title }}
                    </li>
                </ul>
            </div>
            <div v-else>
                <p class="text-gray-500">Категории не найдены</p>
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
