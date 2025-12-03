<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, router } from '@inertiajs/vue3'
import PrimaryButton from '@/Components/PrimaryButton.vue'

const props = defineProps({
    media: { type: Object, required: true }
})

function deleteMedia() {
    if (confirm(`Sei sicuro di voler eliminare "${props.media.name}"?`)) {
        router.delete(route('admin.media.destroy', props.media.id))
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
    <Head :title="`Media: ${media.name}`" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">Dettagli Media</h2>
                <div class="flex items-center gap-2">
                    <Link :href="route('admin.media.edit', media.id)">
                        <PrimaryButton>Modifica</PrimaryButton>
                    </Link>
                    <Link :href="route('admin.media.index')" class="text-sm text-gray-600 hover:text-gray-900">
                        ← Torna alla lista
                    </Link>
                </div>
            </div>
        </template>

        <div class="p-6">
            <div class="mx-auto max-w-4xl space-y-6">
                <!-- Preview Card -->
                <div class="rounded-lg border bg-white p-6 shadow">
                    <div v-if="media.mime_type && media.mime_type.startsWith('image/')" class="flex justify-center">
                        <img :src="media.url" :alt="media.name" class="max-h-[70vh] rounded object-contain" />
                    </div>
                    <div v-else class="flex flex-col items-center justify-center py-12 text-gray-400">
                        <svg class="h-24 w-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="mt-4 text-sm text-gray-600">Anteprima non disponibile</p>
                    </div>
                </div>

                <!-- Details Card -->
                <div class="rounded-lg border bg-white p-6 shadow">
                    <h3 class="mb-4 text-lg font-semibold text-gray-900">Informazioni</h3>
                    <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nome</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ media.name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nome File</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ media.file_name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tipo MIME</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ media.mime_type || '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Dimensione</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ formatFileSize(media.size) }}</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">URL</dt>
                            <dd class="mt-1 text-sm">
                                <a :href="media.url" target="_blank" class="text-blue-600 hover:underline">
                                    {{ media.url }}
                                </a>
                            </dd>
                        </div>
                        <div v-if="media.description" class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Descrizione</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ media.description }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Creato il</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ media.created_at ? new Date(media.created_at).toLocaleString('it-IT') : '-' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Aggiornato il</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ media.updated_at ? new Date(media.updated_at).toLocaleString('it-IT') : '-' }}
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- Actions Card -->
                <div class="rounded-lg border bg-white p-6 shadow">
                    <h3 class="mb-4 text-lg font-semibold text-gray-900">Azioni</h3>
                    <div class="flex flex-wrap gap-3">
                        <a 
                            :href="media.url" 
                            download 
                            class="inline-flex items-center rounded-md bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-200"
                        >
                            Scarica
                        </a>
                        <a 
                            :href="media.url" 
                            target="_blank"
                            class="inline-flex items-center rounded-md bg-blue-100 px-4 py-2 text-sm font-medium text-blue-700 hover:bg-blue-200"
                        >
                            Apri in nuova scheda
                        </a>
                        <button 
                            @click="deleteMedia"
                            class="inline-flex items-center rounded-md bg-red-100 px-4 py-2 text-sm font-medium text-red-700 hover:bg-red-200"
                        >
                            Elimina
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
