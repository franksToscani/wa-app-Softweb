<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
// 
import Editor from '@tinymce/tinymce-vue';


const props = defineProps({
    categories: Array,
    postsTypes: Array,
    postsStatus: Array,
    parents: Array,
    users: Array,
    medias: Array,
})

const form = useForm({
    title: '',
    content: '',
    excerpt: '',
    template: '',
    posts_types_id: '',
    posts_status_id: '',
    category_id: '',
    parent_id: '',
    users_id: '',
    media_id: '',
    views_count: '',
    published_at: '',
    is_published: false,
    is_highlighted: false,
    comments_enabled: true,
    tags: '',
    cover_image: null,
})

function submitForm() {
    // 
    console.log("Dati inviati al backend:", form.data()); // Controlla qui!
    form.post('/posts');
    form.post(route('admin.posts.store'))
}
</script>


<template>
    <Head title="Nuovo Post" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-800">Crea Nuovo Post</h2>
                <Link :href="route('admin.posts.index')" class="text-sm text-gray-600 hover:underline">
                    Torna alla lista
                </Link>
            </div>
        </template>

        <div class="max-w-4xl mx-auto mt-6 p-6 bg-white rounded shadow">

            <form @submit.prevent="submitForm">

                <!-- Title -->
                <div class="mb-4">
                    <label class="font-semibold">Titolo *</label>
                    <input v-model="form.title" type="text" class="w-full border rounded p-2 mt-1">
                    <div v-if="form.errors.title" class="text-red-600 text-sm">{{ form.errors.title }}</div>
                </div>

                <!-- Excerpt -->
                <div class="mb-4">
                    <label class="font-semibold">Excerpt</label>
                    <textarea v-model="form.excerpt" class="w-full border rounded p-2 mt-1" rows="2"></textarea>
                    <div v-if="form.errors.excerpt" class="text-red-600 text-sm">{{ form.errors.excerpt }}</div>
                </div>

                <!-- Content -->
                <div class="mb-4">
                    <label class="font-semibold">Contenuto del Post*</label>
                    <!-- Utilizzo del mio componente TinyMCE Vue -->
                        <Editor
                        api-key="9lqj6ji9zuqgqdhoc3vjc7bz391f9a3gubuktzkw6b82u1go"
                        v-model="form.content"
                        :init="{
                            toolbar_mode: 'sliding',
                            plugins: [

                            'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
                          
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

                <!-- Template -->
                <div class="mb-4">
                    <label class="font-semibold">Template</label>
                    <input v-model="form.template" type="text" class="w-full border rounded p-2 mt-1">
                    <div v-if="form.errors.template" class="text-red-600 text-sm">{{ form.errors.template }}</div>
                </div>

                <!-- Post Type -->
                <div class="mb-4">
                    <label class="font-semibold">Tipo di Post</label>
                    <select v-model="form.posts_types_id" class="w-full border rounded p-2 mt-1">
                        <option value="">Seleziona tipo</option>
                        <option v-for="t in props.postsTypes" :key="t.id" :value="t.id">{{ t.name }}</option>
                    </select>
                    <div v-if="form.errors.posts_types_id" class="text-red-600 text-sm">{{ form.errors.posts_types_id }}</div>
                </div>

                <!-- Post Status -->
                <div class="mb-4">
                    <label class="font-semibold">Stato</label>
                    <select v-model="form.posts_status_id" class="w-full border rounded p-2 mt-1">
                        <option value="">Seleziona stato</option>
                        <option v-for="s in props.postsStatus" :key="s.id" :value="s.id">{{ s.name }}</option>
                    </select>
                    <div v-if="form.errors.posts_status_id" class="text-red-600 text-sm">{{ form.errors.posts_status_id }}</div>
                </div>

                <!-- Category -->
                <div class="mb-4">
                    <label class="font-semibold">Categoria</label>
                    <select v-model="form.category_id" class="w-full border rounded p-2 mt-1">
                        <option value="">Seleziona categoria</option>
                        <option v-for="c in props.categories" :key="c.id" :value="c.id">{{ c.name }}</option>
                    </select>
                    <div v-if="form.errors.category_id" class="text-red-600 text-sm">{{ form.errors.category_id }}</div>
                </div>

                <!-- Parent -->
                <div class="mb-4">
                    <label class="font-semibold">Post Parent</label>
                    <select v-model="form.parent_id" class="w-full border rounded p-2 mt-1">
                        <option value="">Nessuno</option>
                        <option v-for="p in props.parents" :key="p.id" :value="p.id">{{ p.title }}</option>
                    </select>
                    <div v-if="form.errors.parent_id" class="text-red-600 text-sm">{{ form.errors.parent_id }}</div>
                </div>

                <!-- User -->
                <div class="mb-4">
                    <label class="font-semibold">Autore</label>
                    <select v-model="form.users_id" class="w-full border rounded p-2 mt-1">
                        <option value="">Seleziona autore</option>
                        <option v-for="u in props.users" :key="u.id" :value="u.id">{{ u.name }}</option>
                    </select>
                    <div v-if="form.errors.users_id" class="text-red-600 text-sm">{{ form.errors.users_id }}</div>
                </div>

                <!-- MEDIA (existing uploaded media) -->
                <div class="mb-4">
                    <label class="font-semibold">Media esistente</label>
                    <select v-model="form.media_id" class="w-full border rounded p-2 mt-1">
                        <option value="">Nessuno</option>
                        <option v-for="m in props.medias" :key="m.id" :value="m.id">{{ m.file_name }}</option>
                    </select>
                    <div v-if="form.errors.media_id" class="text-red-600 text-sm">{{ form.errors.media_id }}</div>
                </div>

                <!-- Upload immagine -->
                <div class="mb-4">
                    <label class="font-semibold">Upload Nuova Copertina</label>
                    <input type="file" @change="e => form.cover_image = e.target.files[0]" class="w-full border rounded p-2 mt-1">
                    <div v-if="form.errors.cover_image" class="text-red-600 text-sm">{{ form.errors.cover_image }}</div>
                </div>

                <!-- Views count -->
                <div class="mb-4">
                    <label class="font-semibold">Views Count</label>
                    <input v-model="form.views_count" type="number" class="w-full border rounded p-2 mt-1">
                    <div v-if="form.errors.views_count" class="text-red-600 text-sm">{{ form.errors.views_count }}</div>
                </div>

                <!-- Published at -->
                <div class="mb-4">
                    <label class="font-semibold">Data Pubblicazione</label>
                    <input v-model="form.published_at" type="datetime-local" class="w-full border rounded p-2 mt-1">
                    <div v-if="form.errors.published_at" class="text-red-600 text-sm">{{ form.errors.published_at }}</div>
                </div>

                <!-- Switches -->
                <div class="mb-4 flex gap-6 items-center">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" v-model="form.is_published">
                        Pubblicato
                    </label>

                    <label class="flex items-center gap-2">
                        <input type="checkbox" v-model="form.is_highlighted">
                        Evidenziato
                    </label>

                    <label class="flex items-center gap-2">
                        <input type="checkbox" v-model="form.comments_enabled">
                        Commenti abilitati
                    </label>
                </div>

                <!-- Tags -->
                <div class="mb-4">
                    <label class="font-semibold">Tags (comma separated)</label>
                    <input v-model="form.tags" type="text" class="w-full border rounded p-2 mt-1"
                        placeholder="tag1, tag2, tag3">
                    <div v-if="form.errors.tags" class="text-red-600 text-sm">{{ form.errors.tags }}</div>
                </div>

                <!-- Submit buttons -->
                <div class="flex gap-3 mt-6">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                        Salva Post
                    </button>
                    <Link :href="route('dashboard')" class="px-4 py-2 rounded bg-gray-200">
                        Annulla
                    </Link>
                </div>

            </form>
        </div>

    </AuthenticatedLayout>
</template>
