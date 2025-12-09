<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, router } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'

const props = defineProps({
    posts: { type: Object, default: () => ({ data: [] }) },
})

const showConfirm = ref(false)
const deletingId = ref(null)
const deletingTitle = ref('')
const dependentCounts = ref({ products: 0 })
const processing = ref(false)
const searchQuery = ref('')
const sortBy = ref('created_at')
const sortOrder = ref('desc')

const items = computed(() => props.posts?.data ?? [])
const totalPosts = computed(() => props.posts?.meta?.total ?? items.value.length)
const paginationLinks = computed(() => props.posts?.links ?? [])

const filteredPosts = computed(() => {
    let filtered = [...items.value]
    
    if (searchQuery.value) {
        const query = searchQuery.value.toLowerCase()
        filtered = filtered.filter(post => 
            post.title?.toLowerCase().includes(query) ||
            post.excerpt?.toLowerCase().includes(query)
        )
    }
    
    filtered.sort((a, b) => {
        const aVal = a[sortBy.value]
        const bVal = b[sortBy.value]
        
        if (sortOrder.value === 'asc') {
            return aVal > bVal ? 1 : -1
        } else {
            return aVal < bVal ? 1 : -1
        }
    })
    
    return filtered
})

// Computed properties for stats
const publishedPosts = computed(() => items.value.filter(p => p.published_at))
const draftPosts = computed(() => items.value.filter(p => !p.published_at))

async function deletePost(id, title) {
    deletingId.value = id
    deletingTitle.value = title
    showConfirm.value = true
    dependentCounts.value = { products: 0 }

    try {
        const res = await fetch(route('admin.posts.dependents', id), { credentials: 'same-origin' })
        if (res.ok) {
            dependentCounts.value = await res.json()
        }
    } catch (e) {
        dependentCounts.value = { products: 0 }
    }
}

function cancelConfirm() {
    showConfirm.value = false
    deletingId.value = null
    deletingTitle.value = ''
}

function confirmDelete() {
    if (!deletingId.value) return
    processing.value = true
    router.delete(route('admin.posts.destroy', deletingId.value), { 
        data: { force: true },
        onFinish: () => {
            processing.value = false
            showConfirm.value = false
        }
    })
}

// Utility functions for formatting and truncating
function formatDate(date) {
    if (!date) return 'Mai'
    return new Date(date).toLocaleDateString('it-IT', { 
        day: '2-digit', 
        month: 'short', 
        year: 'numeric' 
    })
}

function truncate(text, length = 100) {
    if (!text) return ''
    return text.length > length ? text.substring(0, length) + '...' : text
}
</script>

<template>
    <Head title="Gestione Posts" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                        Gestione Posts
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        Gestisci i tuoi posts e contenuti
                    </p>
                </div>
                <Link :href="route('admin.posts.create')">
                    <PrimaryButton>New Post</PrimaryButton>
                </Link>
            </div>
        </template>

        <div class="py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition-transform duration-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium opacity-90">Totale Posts</p>
                                <p class="text-4xl font-bold mt-2">{{ totalPosts }}</p>
                            </div>
                            <div class="bg-white/20 backdrop-blur-sm rounded-full p-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition-transform duration-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium opacity-90">Pubblicati</p>
                                <p class="text-4xl font-bold mt-2">{{ publishedPosts.length }}</p>
                            </div>
                            <div class="bg-white/20 backdrop-blur-sm rounded-full p-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition-transform duration-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium opacity-90">Bozze</p>
                                <p class="text-4xl font-bold mt-2">{{ draftPosts.length }}</p>
                            </div>
                            <div class="bg-white/20 backdrop-blur-sm rounded-full p-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search and Filter Bar -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-4 mb-6">
                    <div class="flex flex-col sm:flex-row gap-4">
                        <div class="flex-1">
                            <div class="relative">
                                <input 
                                    v-model="searchQuery" 
                                    type="text" 
                                    placeholder="Cerca per titolo o excert..."
                                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                />
                                <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <select v-model="sortBy" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="created_at">Data Creazione</option>
                                <option value="title">Titolo</option>
                                <option value="id">ID</option>
                            </select>
                            <button 
                                @click="sortOrder = sortOrder === 'asc' ? 'desc' : 'asc'"
                                class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors"
                            >
                                <svg v-if="sortOrder === 'desc'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                                <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Posts Grid -->
                <div v-if="filteredPosts.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div 
                        v-for="post in filteredPosts" 
                        :key="post.id"
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden group"
                    >
                        <!-- Card Header -->
                        <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 p-4 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-200 text-gray-800">
                                            #{{ post.id }}
                                        </span>
                                        <span 
                                            v-if="post.published_at"
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800"
                                        >
                                            ✓ Pubblicato
                                        </span>
                                        <span 
                                            v-else
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800"
                                        >
                                             Bozza
                                        </span>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 line-clamp-2 group-hover:text-blue-600 transition-colors">
                                        {{ post.title }}
                                    </h3>
                                </div>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-4">
                            <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-3 mb-4">
                                {{ post.excerpt || 'Nessun estratto disponibile' }}
                            </p>

                            <!-- Metadata -->
                            <div class="flex items-center gap-4 text-xs text-gray-500 mb-4">
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span>{{ formatDate(post.created_at) }}</span>
                                </div>
                                <div v-if="post.views_count" class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <span>{{ post.views_count }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer / Actions -->
                        <div class="bg-gray-50 dark:bg-gray-900 px-4 py-3 border-t border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between gap-2">
                                <Link :href="route('admin.posts.show', post.id)">
                                    <button class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Visualizza
                                    </button>
                                </Link>
                                
                                <div class="flex items-center gap-2">
                                    <Link :href="route('admin.posts.edit', post.id)">
                                        <button class="p-2 text-yellow-600 hover:bg-yellow-50 rounded-lg transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </button>
                                    </Link>
                                    
                                    <button 
                                        @click="deletePost(post.id, post.title)"
                                        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div v-if="paginationLinks.length" class="mt-10 flex flex-wrap items-center gap-2 justify-center">
                    <Link
                        v-for="(link, idx) in paginationLinks"
                        :key="idx"
                        :href="link.url || '#'"
                        preserve-scroll
                        :class="[
                            'px-3 py-1.5 text-sm rounded border transition-colors',
                            link.url ? 'hover:bg-gray-100 dark:hover:bg-gray-800' : 'opacity-50 cursor-not-allowed',
                            link.active ? 'bg-blue-600 text-white border-blue-600' : 'border-gray-300 text-gray-700 dark:text-gray-200'
                        ]"
                        :aria-disabled="!link.url"
                        v-html="link.label"
                    />
                </div>

                <!-- Empty State -->
                <div v-else class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-12 text-center">
                    <svg class="mx-auto w-24 h-24 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">
                        {{ searchQuery ? 'Nessun post trovato' : 'Nessun post disponibile' }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        {{ searchQuery ? 'Prova con un\'altra ricerca' : 'Inizia creando il tuo primo post' }}
                    </p>
                    <Link v-if="!searchQuery" :href="route('admin.posts.create')">
                        <button class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-lg transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Crea il primo post
                        </button>
                    </Link>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

    <!-- Confirmation Modal -->
    <Transition
        enter-active-class="transition ease-out duration-200"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="transition ease-in duration-150"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
    >
        <div v-if="showConfirm" class="fixed inset-0 z-50 overflow-y-auto" @click.self="cancelConfirm">
            <div class="flex min-h-screen items-center justify-center p-4">
                <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="cancelConfirm"></div>
                
                <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full p-6 transform transition-all">
                    <!-- Header -->
                    <div class="flex items-start gap-4 mb-4">
                        <div class="flex-shrink-0 w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-1">
                                Conferma Eliminazione
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Questa azione non può essere annullata
                            </p>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="mb-6">
                        <p class="text-gray-700 dark:text-gray-300 mb-3">
                            Sei sicuro di voler eliminare il post <strong class="font-semibold">"{{ truncate(deletingTitle, 50) }}"</strong>?
                        </p>
                        
                        <div v-if="dependentCounts.products > 0" class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-3">
                            <div class="flex gap-2">
                                <svg class="w-5 h-5 text-yellow-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-sm text-yellow-800 dark:text-yellow-200">
                                    Questo post ha <strong>{{ dependentCounts.products }}</strong> prodotti dipendenti che verranno rimossi automaticamente.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-3">
                        <button 
                            @click="cancelConfirm"
                            class="flex-1 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-900 dark:text-gray-100 font-medium rounded-lg transition-colors"
                        >
                            Annulla
                        </button>
                        <button 
                            @click="confirmDelete"
                            :disabled="processing"
                            class="flex-1 px-4 py-2.5 bg-red-600 hover:bg-red-700 disabled:bg-red-400 text-white font-medium rounded-lg transition-colors disabled:cursor-not-allowed"
                        >
                            {{ processing ? 'Eliminazione...' : 'Elimina' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </Transition>
</template>
