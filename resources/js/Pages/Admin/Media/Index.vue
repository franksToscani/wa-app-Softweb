<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, router } from '@inertiajs/vue3'
import { ref } from 'vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'

const props = defineProps({
    media: { type: Array, default: () => [] }
})

const showDialog = ref(false)
const selectedMedia = ref(null)

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
                    Totale: <strong>{{ media.length }}</strong> file
                </div>
            </div>

            <div v-if="!media || media.length === 0" class="rounded-lg border bg-white p-12 text-center">
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
                        <tr v-for="item in media" :key="item.id" class="hover:bg-gray-50">
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
