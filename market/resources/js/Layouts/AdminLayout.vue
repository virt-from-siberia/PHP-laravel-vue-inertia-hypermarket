<template>
    <div class="flex flex-col min-h-screen">
        <section class="p-4 w-full border-b border-gray-100">
            <header>
                Market Admin
            </header>
        </section>
        <section class="flex flex-1">
            <aside class="w-1/4 bg-gray-700">
                <nav class="text-white">
                    <ul>
                        <li>
                            <Link :href="route('admin.dashboard')"
                                class="block p-4 border-b border-gray-600 hover:bg-gray-800">
                            Панель управления</Link>
                        </li>
                        <li>
                            <Link :href="route('admin.categories.index')"
                                class="block p-4 border-b border-gray-600 hover:bg-gray-800">
                            Категории</Link>
                        </li>
                        <li>
                            <Link :href="route('admin.products.index')"
                                class="block p-4 border-b border-gray-600 hover:bg-gray-800"> Продукты</Link>
                        </li>
                        <li>
                            <Link :href="route('admin.params.index')"
                                class="block p-4 border-b border-gray-600 hover:bg-gray-800"> Параметры</Link>
                        </li>
                        <li>
                            <Link :href="route('admin.product-parents.index')"
                                class="block p-4 border-b border-gray-600 hover:bg-gray-800"> Родительские продукты
                            </Link>
                        </li>
                    </ul>
                </nav>
            </aside>
            <article class="w-3/4 bg-gray-50">
                <slot />
            </article>
        </section>
        <section>
            <footer>footer</footer>
        </section>
    </div>
</template>


<script setup>
import { Link } from '@inertiajs/vue3';
</script>



<style scoped></style>
