<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'

const props = defineProps({
    post: Object,
    categories: Array,
    postsTypes: Array,
    postsStatus: Array,
    parents: Array,
    users: Array,
    medias: Array,
})

const form = useForm({
    title: props.post.title || '',
    content: props.post.content || '',
    excerpt: props.post.excerpt || '',
    template: props.post.template || '',
    posts_types_id: props.post.posts_types_id || '',
    posts_status_id: props.post.posts_status_id || '',
    category_id: props.post.categories_id || '',
    parent_id: props.post.parent_id || '',
    users_id: props.post.users_id || '',
    media_id: props.post.media_id || '',
    views_count: props.post.views_count || '',
    published_at: props.post.published_at ? new Date(props.post.published_at).toISOString().slice(0,16) : '',
    is_published: !!props.post.is_published,
    is_highlighted: !!props.post.is_highlighted,
    comments_enabled: props.post.comments_enabled !== undefined ? !!props.post.comments_enabled : true,
    tags: props.post.tags || '',
    cover_image: null,
})

function submitForm() {
    form.put(route('admin.posts.update', props.post.id))
}
</script>

<template>
    <Head :title="`Modifica Post #${props.post.id}`" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-800">Modifica Post</h2>
                <Link :href="route('admin.posts.index')" class="text-sm text-gray-600 hover:underline">Torna alla lista</Link>
            </div>
        </template>

        <div class="max-w-4xl mx-auto mt-6 p-6 bg-white rounded shadow">
            <form @submit.prevent="submitForm">
                <!-- reuse fields similar to Create.vue -->
                <div class="mb-4">
                    <label class="font-semibold">Titolo *</label>
                    <input v-model="form.title" type="text" class="w-full border rounded p-2 mt-1">
                    <div v-if="form.errors.title" class="text-red-600 text-sm">{{ form.errors.title }}</div>
                </div>

                <!-- other fields omitted for brevity — keep same structure as Create.vue -->
                <!-- Excerpt -->
                <div class="mb-4">
                    <label class="font-semibold">Excerpt</label>
                    <textarea v-model="form.excerpt" class="w-full border rounded p-2 mt-1" rows="2"></textarea>
                </div>

                <!-- Content -->
                <div class="mb-4">
                    <label class="font-semibold">Contenuto *</label>
                    <textarea v-model="form.content" class="w-full border rounded p-2 mt-1" rows="8"></textarea>
                </div>

                <!-- Submit buttons -->
                <div class="flex gap-3 mt-6">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Aggiorna Post</button>
                    <Link :href="route('admin.posts.index')" class="px-4 py-2 rounded bg-gray-200">Annulla</Link>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
