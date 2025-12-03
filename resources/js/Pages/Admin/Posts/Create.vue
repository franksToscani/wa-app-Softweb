<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'
import Editor from '@tinymce/tinymce-vue'

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

const imagePreview = ref(null)

function submitForm() {
    form.post(route('admin.posts.store'))
}

function onFileSelect(event) {
    const file = event.target.files[0]
    if (!file) return
    
    form.cover_image = file
    const reader = new FileReader()
    reader.onload = (e) => {
        imagePreview.value = e.target.result
    }
    reader.readAsDataURL(file)
}
</script>

<template>
    <Head title="Nuovo Post" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                        Crea Nuovo Post
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        Crea un nuovo Posts per il sito
                    </p>
                </div>
                <Link :href="route('admin.posts.index')">
                    <button class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg shadow transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Torna alla lista
                    </button>
                </Link>
            </div>
        </template>

        <div class="py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <form @submit.prevent="submitForm">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Main Content Column (2/3) -->
                        <div class="lg:col-span-2 space-y-6">
                            <!-- Title & Excerpt Card -->
                            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Contenuto Principale
                                </h3>
                                <div class="space-y-4">
                                    <!-- Title -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                            Titolo *
                                        </label>
                                        <input 
                                            v-model="form.title" 
                                            type="text"
                                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            :class="{ 'border-red-500': form.errors.title }"
                                            placeholder="Inserisci il titolo del post"
                                        />
                                        <small v-if="form.errors.title" class="text-red-600 block mt-1">
                                            {{ form.errors.title }}
                                        </small>
                                    </div>

                                    <!-- Excerpt -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                            Excert
                                        </label>
                                        <textarea 
                                            v-model="form.excerpt" 
                                            rows="3" 
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="Breve descrizione del post"
                                        ></textarea>
                                        <small class="text-gray-500">Descrizione breve mostrata nelle anteprime</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Rich Text Editor Card -->
                            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                                    </svg>
                                    Contenuto Completo *
                                </h3>
                                <Editor
                                    v-model="form.content"
                                    api-key="9lqj6ji9zuqgqdhoc3vjc7bz391f9a3gubuktzkw6b82u1go"
                                    :init="{
                                        height: 500,
                                        menubar: true,
                                        toolbar_mode: 'sliding',
                                        plugins: [
                                            'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 
                                            'link', 'lists', 'media', 'searchreplace', 'table', 
                                            'visualblocks', 'wordcount', 'checklist', 'mediaembed',
                                            'casechange', 'formatpainter', 'pageembed', 'permanentpen',
                                            'powerpaste', 'advtable', 'advcode', 'tinymcespellchecker'
                                        ],
                                        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link media table | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
                                    }"
                                />
                                <small v-if="form.errors.content" class="text-red-600 block mt-2">
                                    {{ form.errors.content }}
                                </small>
                            </div>

                            <!-- Cover Image Card -->
                            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Immagine di Copertina
                                </h3>
                                <input 
                                    type="file"
                                    accept="image/*"
                                    @change="onFileSelect"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                />
                                <div v-if="imagePreview" class="mt-4">
                                    <img :src="imagePreview" alt="Preview" class="rounded-lg shadow-md max-h-64 object-cover" />
                                </div>
                                <small class="text-gray-500 block mt-2">
                                    Dimensione massima: 5MB. Formati supportati: JPG, PNG, GIF
                                </small>
                            </div>
                        </div>

                        <!-- Sidebar Column (1/3) -->
                        <div class="space-y-6">
                            <!-- Publish Settings Card -->
                            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                    </svg>
                                    Pubblicazione
                                </h3>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                            Data Pubblicazione
                                        </label>
                                        <input 
                                            v-model="form.published_at" 
                                            type="datetime-local"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        />
                                    </div>

                                    <hr class="border-gray-200 dark:border-gray-700" />

                                    <!-- Checkboxes -->
                                    <div class="space-y-3">
                                        <div class="flex items-center gap-3">
                                            <input 
                                                v-model="form.is_highlighted" 
                                                type="checkbox"
                                                id="highlighted"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500"
                                            />
                                            <label for="highlighted" class="text-sm cursor-pointer text-gray-700 dark:text-gray-300">
                                                 Post in Evidenza
                                            </label>
                                        </div>

                                        <div class="flex items-center gap-3">
                                            <input 
                                                v-model="form.comments_enabled" 
                                                type="checkbox"
                                                id="comments"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500"
                                            />
                                            <label for="comments" class="text-sm cursor-pointer text-gray-700 dark:text-gray-300">
                                                 Abilita Commenti
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Categories & Types Card -->
                            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                    Classificazione
                                </h3>
                                <div class="space-y-4">
                                    <!-- Category -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                            Categoria
                                        </label>
                                        <select 
                                            v-model="form.category_id" 
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        >
                                            <option value="">Seleziona categoria</option>
                                            <option v-for="cat in categories" :key="cat.id" :value="cat.id">
                                                {{ cat.name }}
                                            </option>
                                        </select>
                                    </div>

                                    <!-- Post Type -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                            Tipo Post
                                        </label>
                                        <select 
                                            v-model="form.posts_types_id" 
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        >
                                            <option value="">Seleziona tipo</option>
                                            <option v-for="type in postsTypes" :key="type.id" :value="type.id">
                                                {{ type.name }}
                                            </option>
                                        </select>
                                    </div>

                                    <!-- Status -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                            Stato
                                        </label>
                                        <select 
                                            v-model="form.posts_status_id" 
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        >
                                            <option value="">Seleziona stato</option>
                                            <option v-for="status in postsStatus" :key="status.id" :value="status.id">
                                                {{ status.name }}
                                            </option>
                                        </select>
                                    </div>

                                    <!-- Tags -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                            Tags
                                        </label>
                                        <input 
                                            v-model="form.tags" 
                                            type="text"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="tag1, tag2, tag3"
                                        />
                                        <small class="text-gray-500 block mt-1">Separati da virgola</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Settings Card -->
                            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    Impostazioni Avanzate
                                </h3>
                                <div class="space-y-4">
                                    <!-- Parent -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                            Post Genitore
                                        </label>
                                        <select 
                                            v-model="form.parent_id" 
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        >
                                            <option value="">Nessuno</option>
                                            <option v-for="parent in parents" :key="parent.id" :value="parent.id">
                                                {{ parent.title }}
                                            </option>
                                        </select>
                                    </div>

                                    <!-- Template -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                            Template
                                        </label>
                                        <input 
                                            v-model="form.template" 
                                            type="text"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="default"
                                        />
                                    </div>

                                    <!-- Views Count -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                            Visualizzazioni
                                        </label>
                                        <input 
                                            v-model="form.views_count" 
                                            type="number"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100"
                                            disabled
                                        />
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                                <div class="space-y-3">
                                    <button 
                                        type="submit" 
                                        :disabled="form.processing"
                                        class="w-full inline-flex items-center justify-center px-4 py-3 bg-green-600 hover:bg-green-700 disabled:bg-green-400 text-white font-semibold rounded-lg shadow transition-colors"
                                    >
                                        <svg v-if="!form.processing" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        {{ form.processing ? 'Creazione...' : 'Crea Post' }}
                                    </button>

                                    <Link :href="route('admin.posts.index')">
                                        <button type="button" class="w-full inline-flex items-center justify-center px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg transition-colors">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                            Annulla
                                        </button>
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
