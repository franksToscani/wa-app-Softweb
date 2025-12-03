<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link } from '@inertiajs/vue3'
import { ref } from 'vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'


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
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">Dashboard</h2>
                <div class="flex items-center gap-2">
                    <Link :href="route('admin.posts.create')" class="ml-4">
                        <PrimaryButton>New Post</PrimaryButton>
                    </Link>
                </div>

                <div class="flex items-center gap-2">
                    <Link :href="route('admin.media.index')" class="ml-4">
                        <PrimaryButton>Gestione Media</PrimaryButton>
                    </Link>
                </div>
            </div>
        </template>

        <div class="p-6">
            <div v-if="!posts || posts.length === 0" class="text-center text-sm text-gray-500">
                Nessun post trovato. Crea il primo post premendo "New Post".
            </div>

            <div v-else class="overflow-hidden rounded-lg border">
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
                    <tbody class="divide-y bg-white">
                        <tr v-for="post in posts" :key="post.id">
                            <td class="px-4 py-3 text-sm text-gray-700">{{ post.id }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ post.title }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ post.excerpt || '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ post.created_at ? new Date(post.created_at).toLocaleString() : '-' }}</td>
                            <td class="px-4 py-3 text-sm text-right">
                                <div class="inline-flex items-center gap-2">
                                    <Link :href="route('admin.posts.index')" class="text-sm text-primary-600 hover:underline">Modifica</Link>
                                    <Link :href="route('admin.posts.index')" class="text-sm text-neutral-600 hover:underline">Visualizza</Link>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </AuthenticatedLayout>
    </template>
