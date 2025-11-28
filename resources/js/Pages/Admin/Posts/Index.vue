<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, router } from '@inertiajs/vue3'

const props = defineProps({
    posts: { type: Array, default: () => [] },
})

import { ref } from 'vue'

const showConfirm = ref(false)
const deletingId = ref(null)
const dependentCounts = ref({ products: 0 })
const processing = ref(false)

async function deletePost(id) {
    // Fetch dependent counts and show confirmation modal
    deletingId.value = id
    showConfirm.value = true
    dependentCounts.value = { products: 0 }

    try {
        const res = await fetch(route('admin.posts.dependents', id), { credentials: 'same-origin' })
        if (res.ok) {
            dependentCounts.value = await res.json()
        }
    } catch (e) {
        // ignore, show modal with zero counts
        dependentCounts.value = { products: 0 }
    }
}

function cancelConfirm() {
    showConfirm.value = false
    deletingId.value = null
}

function confirmDelete() {
    if (!deletingId.value) return
    processing.value = true
    // send delete with force flag
    router.delete(route('admin.posts.destroy', deletingId.value), { data: { force: true } })
}
</script>

<template>
    <Head title="Posts" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-800">Gestione Post</h2>

                <Link :href="route('admin.posts.create')">
                    <button class="bg-blue-600 text-white px-4 py-2 rounded">
                        + Nuovo Post
                    </button>
                </Link>
            </div>
        </template>

        <div class="p-6">
            <div v-if="!posts || posts.length === 0" class="text-center text-gray-500 text-sm">
                Nessun post disponibile.
            </div>

            <div v-else class="overflow-hidden rounded-lg border bg-white">
                <table class="min-w-full divide-y">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">ID</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Titolo</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Estratto</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Creato il</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500">Azioni</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">
                        <tr v-for="post in posts" :key="post.id" class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm">{{ post.id }}</td>
                            <td class="px-4 py-3 text-sm font-semibold">{{ post.title }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">
                                {{ post.excerpt ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500">
                                {{ post.created_at ? new Date(post.created_at).toLocaleString() : '-' }}
                            </td>

                            <td class="px-4 py-3 text-sm text-right">
                                <div class="inline-flex items-center gap-3">

                                    <!-- Modifica -->
                                    <Link
                                        :href="route('admin.posts.edit', post.id)"
                                        class="text-blue-600 hover:underline"
                                    >
                                        Modifica
                                    </Link>

                                    <!-- Visualizza (può puntare al dettaglio front-end o admin) -->
                                    <Link
                                        :href="route('admin.posts.show', post.id)"
                                        class="text-gray-700 hover:underline"
                                    >
                                        Visualizza
                                    </Link>

                                    <!-- Elimina -->
                                    <button
                                        @click="deletePost(post.id)"
                                        class="text-red-600 hover:underline"
                                    >
                                        Elimina
                                    </button>

                                </div>
                            </td>
                        </tr>
                    </tbody>

                </table>
            </div>
        </div>
    </AuthenticatedLayout>
    <!-- Confirmation Modal -->
    <div v-if="showConfirm" class="fixed inset-0 z-50 flex items-center justify-center">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="relative bg-white rounded-lg shadow-lg max-w-lg w-full p-6 z-10">
            <h3 class="text-lg font-semibold mb-2">Conferma eliminazione</h3>
            <p class="text-sm text-gray-700 mb-4">
                Questo post ha <strong>{{ dependentCounts.products }}</strong> prodotti dipendenti.
                Se procedi, questi record saranno rimossi (ON DELETE CASCADE).
            </p>
            <div class="flex justify-end gap-3">
                <button @click="cancelConfirm" class="px-4 py-2 rounded border">Annulla</button>
                <button @click="confirmDelete" :disabled="processing" class="px-4 py-2 rounded bg-red-600 text-white">
                    <span v-if="!processing">Elimina definitivamente</span>
                    <span v-else>Eliminazione...</span>
                </button>
            </div>
        </div>
    </div>
</template>
