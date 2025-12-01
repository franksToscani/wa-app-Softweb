<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import Editor from '@tinymce/tinymce-vue';


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
                        <label class="font-semibold">Contenuto del Post*</label>
                        <!-- Utilizzo del mio componente TinyMCE Vue -->
                            <Editor
                            api-key="9lqj6ji9zuqgqdhoc3vjc7bz391f9a3gubuktzkw6b82u1go"
                            :init="{
                                toolbar_mode: 'sliding',
                                plugins: [
                                // Core editing features
                                'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
                                // Your account includes a free trial of TinyMCE premium features
                                // Try the most popular premium features until Dec 15, 2025:
                                'checklist', 'mediaembed', 'casechange', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'advtemplate', 'ai', 'uploadcare', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown','importword', 'exportword', 'exportpdf'
                                ],
                                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography uploadcare | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
                                tinycomments_mode: 'embedded',
                                tinycomments_author: 'Author name',
                                mergetags_list: [
                                { value: 'First.Name', title: 'First Name' },
                                { value: 'Email', title: 'Email' },
                                ],
                                ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
                                uploadcare_public_key: '37c19513a38f5cc80cac',
                            }"
                            initial-value="Welcome to TinyMCE!"
                            />           
                        <div v-if="form.errors.content" class="text-red-600 text-sm">{{ form.errors.content }}</div>
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
