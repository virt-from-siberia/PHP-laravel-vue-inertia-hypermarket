<template>
    <section class="p-4 w-full border-b border-gray-100">
        <header>
            Market Admin
        </header>
    </section>
    <section class="flex">
        <aside class="w-1/4 min-h-screen">
            <nav>
                <ul>
                    <li>
                        <a href="#">Home</a>
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
</template>


<script setup>
// AdminLayout component
</script>



<style scoped></style>
