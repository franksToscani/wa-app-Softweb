<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link } from '@inertiajs/vue3'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import Editor from '@tinymce/tinymce-vue';



const props = defineProps({
    post: Object,
})
</script>

<template>
    <Head :title="`Post #${props.post.id}`" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-800">Dettaglio Post</h2>
                <Link :href="route('admin.posts.index')" class="text-sm text-gray-600 hover:underline">Torna alla lista</Link>
            </div>
        </template>

        <div class="max-w-4xl mx-auto mt-6 p-6 bg-white rounded shadow">
            <h3 class="text-lg font-semibold mb-2">{{ props.post.title }}</h3>
            <div class="text-sm text-gray-600 mb-4">ID: {{ props.post.id }} — Creato: {{ props.post.created_at }}</div>

            <div class="mb-4">
                <h4 class="font-semibold">Estratto</h4>
                <div class="mt-1">{{ props.post.excerpt || '-' }}</div>
            </div>

            <div class="mb-4">
                <h4 class="font-semibold">Contenuto</h4>
                <div class="mt-1 whitespace-pre-wrap">{{ props.post.content || '-' }}</div>
            </div>

            <div class="flex gap-3 mt-6">
                <Link :href="route('admin.posts.edit', props.post.id)" class="ml-4">
                    <PrimaryButton>Modifica</PrimaryButton>
                </Link>
                <Link :href="route('admin.posts.index')" class="ml-4">
                    <PrimaryButton>Indietro</PrimaryButton>
                </Link>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
