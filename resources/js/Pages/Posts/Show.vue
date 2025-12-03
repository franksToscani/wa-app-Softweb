<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
    post: Object,
    isAdmin: { type: Boolean, default: false },
})

const showFullContent = ref(false)

const formatDate = (date) => {
    if (!date) return '-'
    return new Date(date).toLocaleDateString('it-IT', { 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    })
}

const getTags = () => {
    if (!props.post.tags) return []
    return props.post.tags.split(',').map(t => t.trim()).filter(Boolean)
}
</script>

<template>
    <Head :title="`Post: ${props.post.title}`" />

    <AuthenticatedLayout :isAdmin="isAdmin">
        <template #header v-if="isAdmin">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                         Dettaglio Post
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        Visualizza i dettagli completi del post
                    </p>
                </div>
                <div class="flex gap-3">
                    <Link v-if="isAdmin" :href="route('admin.posts.edit', props.post.id)">
                        <button class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-lg shadow transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Modifica
                        </button>
                    </Link>
                    <Link v-if="isAdmin" :href="route('admin.posts.index')">
                                            <Link :href="route('welcome')">
                                                <button class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg shadow transition-colors">
                                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                                    </svg>
                                                    Torna alla home
                                                </button>
                                            </Link>
                        <button class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg shadow transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Torna alla lista
                        </button>
                    </Link>
                </div>
            </div>
        </template>

        <div class="py-8">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header Card -->
                <div class="bg-gradient-to-br from-blue-500 via-purple-500 to-purple-600 rounded-2xl shadow-2xl p-8 mb-6 text-white">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white/20 backdrop-blur-sm">
                                #{{ props.post.id }}
                            </span>
                            <span 
                                v-if="props.post.published_at"
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-500/80"
                            >
                                Pubblicato
                            </span>
                            <span 
                                v-else
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-500/80"
                            >
                                Bozza
                            </span>
                        </div>
                    </div>
                    
                    <h1 class="text-4xl font-bold mb-4">
                        {{ props.post.title }}
                    </h1>
                    
                    <div class="flex flex-wrap items-center gap-4 text-sm opacity-90">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>Creato: {{ formatDate(props.post.created_at) }}</span>
                        </div>
                        <div v-if="props.post.updated_at && props.post.updated_at !== props.post.created_at" class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Aggiornato: {{ formatDate(props.post.updated_at) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden mb-6">
                    <!-- Metadata Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8 border-b border-gray-200 dark:border-gray-700">
                        <div>
                            <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Informazioni Base
                            </h3>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                    <span class="text-gray-600 font-medium">Tipo</span>
                                    <span class="text-gray-900 font-semibold">{{ props.post.posts_types_id || '-' }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                    <span class="text-gray-600 font-medium">Stato</span>
                                    <span class="text-gray-900 font-semibold">{{ props.post.posts_status_id || '-' }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                    <span class="text-gray-600 font-medium">Categoria</span>
                                    <span class="text-gray-900 font-semibold">{{ props.post.categories_id || '-' }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-gray-600 font-medium">Template</span>
                                    <span class="text-gray-900 font-semibold">{{ props.post.template || 'Default' }}</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Configurazione
                            </h3>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                    <span class="text-gray-600 font-medium">In Evidenza</span>
                                    <span :class="props.post.is_highlighted ? 'text-yellow-600' : 'text-gray-400'">
                                        {{ props.post.is_highlighted ? '⭐ Sì' : 'No' }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                    <span class="text-gray-600 font-medium">Commenti</span>
                                    <span :class="props.post.comments_enabled ? 'text-blue-600' : 'text-gray-400'">
                                        {{ props.post.comments_enabled ? ' Abilitati' : 'Disabilitati' }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                    <span class="text-gray-600 font-medium">Visualizzazioni</span>
                                    <span class="text-gray-900 font-semibold">{{ props.post.views_count || '0' }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-gray-600 font-medium">Pubblicato il</span>
                                    <span class="text-gray-900 font-semibold">
                                        {{ props.post.published_at ? formatDate(props.post.published_at) : 'Non pubblicato' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Excerpt -->
                    <div v-if="props.post.excerpt" class="p-8 bg-gray-50 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Estratto
                        </h3>
                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                            {{ props.post.excerpt }}
                        </p>
                    </div>

                    <!-- Content -->
                    <div class="p-8">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                                </svg>
                                Contenuto Completo
                            </h3>
                            <button 
                                v-if="props.post.content && props.post.content.length > 500"
                                @click="showFullContent = !showFullContent"
                                class="text-sm text-blue-600 hover:text-blue-700 font-medium"
                            >
                                {{ showFullContent ? 'Mostra meno' : 'Mostra tutto' }}
                            </button>
                        </div>
                        <div 
                            v-if="props.post.content" 
                            class="prose prose-sm max-w-none text-gray-700 dark:text-gray-300 leading-relaxed"
                            :class="{ 'line-clamp-10': !showFullContent && props.post.content.length > 500 }"
                            v-html="props.post.content"
                        ></div>
                        <p v-else class="text-gray-500 italic">Nessun contenuto disponibile</p>
                    </div>

                    <!-- Tags -->
                    <div v-if="getTags().length > 0" class="p-8 bg-gray-50 dark:bg-gray-900">
                        <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            Tags
                        </h3>
                        <div class="flex flex-wrap gap-2">
                            <span 
                                v-for="(tag, index) in getTags()" 
                                :key="index"
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800"
                            >
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                                {{ tag }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Additional Info Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 text-center">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <p class="text-sm text-gray-600 mb-1">Media ID</p>
                        <p class="text-2xl font-bold text-gray-900">{{ props.post.media_id || '-' }}</p>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 text-center">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                            </svg>
                        </div>
                        <p class="text-sm text-gray-600 mb-1">Parent ID</p>
                        <p class="text-2xl font-bold text-gray-900">{{ props.post.parent_id || '-' }}</p>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 text-center">
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </div>
                        <p class="text-sm text-gray-600 mb-1">Visualizzazioni</p>
                        <p class="text-2xl font-bold text-gray-900">{{ props.post.views_count || '0' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.prose {
    color: #374151;
}
.prose h1, .prose h2, .prose h3 {
    color: #111827;
    font-weight: 600;
}
.line-clamp-10 {
    display: -webkit-box;
    -webkit-line-clamp: 10;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
