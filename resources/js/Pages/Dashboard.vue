<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
    posts: { type: Array, default: () => [] },
    products: { type: Array, default: () => [] },
})

const showDialog = ref(false)
const selectedPost = ref(null)

function openPost(post) {
    selectedPost.value = post
    showDialog.value = true
}

function closeDialog() {
    showDialog.value = false
    selectedPost.value = null
}
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
                                    <div v-for="post in props.posts" :key="post.id">
                                        <Card :title="post.title" class="mb-3">
                                            <p class="text-sm text-neutral-600 mt-1">{{ post.excerpt || '' }}</p>
                                            <template #footer>
                                                <div class="flex items-center justify-between">
                                                    <small class="text-sm text-neutral-500">{{ new Date(post.created_at).toLocaleDateString() }}</small>
                                                    <PButton icon="pi pi-eye" class="p-button-text" label="Apri" @click="openPost(post)" />
                                                </div>
                                            </template>
                                        </Card>
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
                                    <div v-for="product in props.products" :key="product.id">
                                        <Card :title="product.name" class="mb-3">
                                            <p class="text-sm text-neutral-600 mt-1">Prezzo: {{ product.price ?? '—' }}</p>
                                            <template #footer>
                                                <div class="flex items-center justify-between">
                                                    <small class="text-sm text-neutral-500">{{ new Date(product.created_at).toLocaleDateString() }}</small>
                                                    <PButton icon="pi pi-shopping-cart" class="p-button-text" label="Apri" />
                                                </div>
                                            </template>
                                        </Card>
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
        <!-- Post preview dialog -->
        <Dialog v-model:visible="showDialog" :header="selectedPost ? selectedPost.title : ''" :modal="true" :style="{ width: '50vw' }">
            <div v-if="selectedPost">
                <p class="text-sm text-neutral-700" v-html="selectedPost.content"></p>
            </div>
            <template #footer>
                <div class="text-right">
                    <PButton label="Chiudi" class="p-button-text" @click="closeDialog" />
                </div>
            </template>
        </Dialog>
    </AuthenticatedLayout>
</template>
