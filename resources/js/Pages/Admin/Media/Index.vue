<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, router } from '@inertiajs/vue3'
import { ref, computed, watch } from 'vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'

const props = defineProps({
    media: { type: Object, default: () => ({ data: [] }) }
})

const showDialog = ref(false)
const selectedMedia = ref(null)

const items = computed(() => props.media?.data ?? [])
const totalMedia = computed(() => props.media?.meta?.total ?? items.value.length)
const paginationLinks = computed(() => props.media?.links ?? [])

const searchTerm = ref('')
const mimeFilter = ref('')
const sortBy = ref('created_at')
const sortOrder = ref('desc')
let searchTimer = null

function openPreview(item) {
    selectedMedia.value = item
    showDialog.value = true
}

function closeDialog() {
    showDialog.value = false
    selectedMedia.value = null
}

function deleteMedia(media) {
    if (confirm(`Sei sicuro di voler eliminare "${media.name}"?`)) {
        router.delete(route('admin.media.destroy', media.id))
    }
}

function buildParams(pageUrl = null) {
    const params = {
        'filter[name]': searchTerm.value || undefined,
        'filter[file_name]': searchTerm.value || undefined,
        'filter[mime_type]': mimeFilter.value || undefined,
        sort: sortOrder.value === 'desc' ? `-${sortBy.value}` : sortBy.value,
    }

    // If navigating via pagination link, preserve that URL; otherwise use route helper
    return { params, pageUrl }
}

function applyFilters(pageUrl = null) {
    const { params } = buildParams(pageUrl)
    router.get(pageUrl || route('admin.media.index'), params, {
        preserveScroll: true,
        preserveState: true,
        replace: true,
    })
}

function debouncedApply() {
    if (searchTimer) clearTimeout(searchTimer)
    searchTimer = setTimeout(() => applyFilters(), 350)
}

function changePage(link) {
    if (!link.url) return
    applyFilters(link.url)
}

watch([searchTerm, mimeFilter], debouncedApply)
watch([sortBy, sortOrder], () => applyFilters())

function formatFileSize(bytes) {
    if (!bytes) return '-'
    if (bytes < 1024) return bytes + ' B'
    if (bytes < 1048576) return Math.round(bytes / 1024) + ' KB'
    return Math.round(bytes / 1048576 * 10) / 10 + ' MB'
}
</script>

<template>
    <Head title="Gestione Media" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">Gestione Media</h2>
                <Link :href="route('admin.media.create')">
                    <PrimaryButton>Carica Media</PrimaryButton>
                </Link>


                <Link :href="route('dashboard')" class="mt-4 inline-block">
                    <button class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg shadow transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Torna in Dashbord
                    </button>
                </Link>
            </div>
            
        </template>

        <div class="p-6">
            <div class="mb-4 flex items-center justify-between">
                <div class="text-sm text-gray-600">
                    Totale: <strong>{{ totalMedia }}</strong> file
                </div>
            </div>

            <!-- Filters -->
            <div class="mb-4 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div class="flex-1 flex flex-col md:flex-row md:items-center gap-2">
                    <div class="relative w-full md:max-w-sm">
                        <input
                            v-model="searchTerm"
                            type="text"
                            placeholder="Cerca per nome o file"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 pl-9 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        />
                        <svg class="absolute left-2.5 top-2.5 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>

                    <select
                        v-model="mimeFilter"
                        class="w-full md:w-48 rounded-lg border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                        <option value="">Tutti i tipi</option>
                        <option value="image/jpeg">image/jpeg</option>
                        <option value="image/png">image/png</option>
                        <option value="image/webp">image/webp</option>
                        <option value="application/pdf">application/pdf</option>
                    </select>
                </div>

                <div class="flex items-center gap-2">
                    <select
                        v-model="sortBy"
                        class="rounded-lg border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                        <option value="created_at">Data</option>
                        <option value="name">Nome</option>
                        <option value="file_name">File</option>
                        <option value="size">Dimensione</option>
                    </select>
                    <button
                        @click="sortOrder = sortOrder === 'asc' ? 'desc' : 'asc'"
                        class="inline-flex items-center gap-1 rounded-lg border border-gray-300 px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                        type="button"
                    >
                        <span>{{ sortOrder === 'asc' ? 'Asc' : 'Desc' }}</span>
                        <svg v-if="sortOrder === 'asc'" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                        </svg>
                        <svg v-else class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                </div>
            </div>

            <div v-if="!items.length" class="rounded-lg border bg-white p-12 text-center">
                <p class="text-gray-500">Nessun file caricato.</p>
                <Link :href="route('admin.media.create')" class="mt-4 inline-block">
                    <PrimaryButton>Carica il primo file</PrimaryButton>
                </Link>
            </div>

            <div v-else class="overflow-hidden rounded-lg border bg-white">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Anteprima</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Nome</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Tipo</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Dimensione</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Data</th>
                            <th class="px-4 py-3 text-right text-xs font-medium uppercase text-gray-500">Azioni</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        <tr v-for="item in items" :key="item.id" class="hover:bg-gray-50">
                            <td class="px-4 py-3">
                                <div v-if="item.mime_type && item.mime_type.startsWith('image/')" class="h-12 w-12">
                                    <img 
                                        :src="item.url" 
                                        :alt="item.name" 
                                        class="h-full w-full rounded object-cover"
                                        @click="openPreview(item)"
                                    />
                                </div>
                                <div v-else class="flex h-12 w-12 items-center justify-center rounded bg-gray-100 text-gray-400">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-sm font-medium text-gray-900">{{ item.name }}</div>
                                <div class="text-xs text-gray-500">{{ item.file_name }}</div>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">
                                {{ item.mime_type || '-' }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">
                                {{ formatFileSize(item.size) }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500">
                                {{ item.created_at ? new Date(item.created_at).toLocaleDateString('it-IT') : '-' }}
                            </td>
                            <td class="px-4 py-3 text-right text-sm">
                                <div class="inline-flex gap-3">
                                    <button 
                                        class="text-blue-600 hover:text-blue-800 hover:underline"
                                        @click="openPreview(item)"
                                    >
                                        Visualizza
                                    </button>
                                    <Link 
                                        :href="route('admin.media.edit', item.id)"
                                        class="text-indigo-600 hover:text-indigo-800 hover:underline"
                                    >
                                        Modifica
                                    </Link>
                                    <button 
                                        class="text-red-600 hover:text-red-800 hover:underline"
                                        @click="deleteMedia(item)"
                                    >
                                        Elimina
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div v-if="paginationLinks.length" class="flex flex-wrap items-center gap-2 px-4 py-3 bg-gray-50 border-t">
                    <Link
                        v-for="(link, idx) in paginationLinks"
                        :key="idx"
                        :href="link.url || '#'"
                        preserve-scroll
                        :class="[
                            'px-3 py-1.5 text-sm rounded border transition-colors',
                            link.url ? 'hover:bg-gray-100' : 'opacity-50 cursor-not-allowed',
                            link.active ? 'bg-blue-600 text-white border-blue-600' : 'border-gray-300 text-gray-700'
                        ]"
                        :aria-disabled="!link.url"
                        v-html="link.label"
                    />
                </div>
            </div>
        </div>

        <!-- Preview Dialog -->
        <div 
            v-if="showDialog && selectedMedia" 
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4"
            @click="closeDialog"
        >
            <div 
                class="relative w-full max-w-4xl rounded-lg bg-white shadow-xl"
                @click.stop
            >
                <div class="flex items-center justify-between border-b px-6 py-4">
                    <h3 class="text-lg font-semibold text-gray-900">{{ selectedMedia.name }}</h3>
                    <button 
                        class="text-gray-400 hover:text-gray-600"
                        @click="closeDialog"
                    >
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <div class="p-6">
                    <div v-if="selectedMedia.mime_type && selectedMedia.mime_type.startsWith('image/')" class="mb-4 flex justify-center">
                        <img 
                            :src="selectedMedia.url" 
                            :alt="selectedMedia.name" 
                            class="max-h-[60vh] rounded object-contain"
                        />
                    </div>
                    
                    <div class="space-y-2 text-sm">
                        <div><strong>Nome file:</strong> {{ selectedMedia.file_name }}</div>
                        <div><strong>Tipo:</strong> {{ selectedMedia.mime_type }}</div>
                        <div><strong>Dimensione:</strong> {{ formatFileSize(selectedMedia.size) }}</div>
                        <div><strong>URL:</strong> <a :href="selectedMedia.url" target="_blank" class="text-blue-600 hover:underline">{{ selectedMedia.url }}</a></div>
                        <div v-if="selectedMedia.description"><strong>Descrizione:</strong> {{ selectedMedia.description }}</div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
