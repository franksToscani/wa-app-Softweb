<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'

const props = defineProps({
    posts: { type: Array, default: () => [] },
    products: { type: Array, default: () => [] },
})
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Dashboard</h2>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="grid gap-6 lg:grid-cols-2">
                    <!-- Recent posts -->
                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold">Ultimi post</h3>
                            <div class="mt-4 space-y-4">
                                <template v-if="props.posts.length">
                                    <div v-for="post in props.posts" :key="post.id" class="border rounded-md p-3">
                                        <div class="flex items-start justify-between">
                                            <div>
                                                <h4 class="font-semibold text-neutral-900">{{ post.title }}</h4>
                                                <p class="text-sm text-neutral-600 mt-1">{{ post.excerpt || '' }}</p>
                                            </div>
                                            <div class="text-sm text-neutral-500">{{ new Date(post.created_at).toLocaleDateString() }}</div>
                                        </div>
                                    </div>
                                </template>
                                <template v-else>
                                    <div class="text-sm text-neutral-500">Nessun post trovato.</div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- Recent products -->
                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold">Prodotti recenti</h3>
                            <div class="mt-4 space-y-4">
                                <template v-if="props.products.length">
                                    <div v-for="product in props.products" :key="product.id" class="border rounded-md p-3">
                                        <div class="flex items-start justify-between">
                                            <div>
                                                <h4 class="font-semibold text-neutral-900">{{ product.name }}</h4>
                                                <p class="text-sm text-neutral-600 mt-1">Prezzo: {{ product.price ?? '—' }}</p>
                                            </div>
                                            <div class="text-sm text-neutral-500">{{ new Date(product.created_at).toLocaleDateString() }}</div>
                                        </div>
                                    </div>
                                </template>
                                <template v-else>
                                    <div class="text-sm text-neutral-500">Nessun prodotto trovato.</div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
