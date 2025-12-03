<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import InputLabel from '@/Components/InputLabel.vue'
import TextInput from '@/Components/TextInput.vue'
import InputError from '@/Components/InputError.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'

const props = defineProps({
    media: { type: Object, required: true }
})

const form = useForm({
    name: props.media.name,
    description: props.media.description || '',
})

function submit() {
    form.put(route('admin.media.update', props.media.id), {
        preserveScroll: true,
    })
}
</script>

<template>
    <Head title="Modifica Media" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">Modifica Media</h2>
                <Link :href="route('admin.media.index')" class="text-sm text-gray-600 hover:text-gray-900">
                    ← Torna alla lista
                </Link>
            </div>
        </template>

        <div class="p-6">
            <div class="mx-auto max-w-3xl rounded-lg border bg-white p-6 shadow">
                <!-- Media Preview -->
                <div class="mb-6 rounded border bg-gray-50 p-4">
                    <div v-if="media.mime_type && media.mime_type.startsWith('image/')" class="flex justify-center">
                        <img :src="media.url" :alt="media.name" class="max-h-64 rounded" />
                    </div>
                    <div v-else class="text-center text-gray-500">
                        <svg class="mx-auto h-16 w-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="mt-2 text-sm">{{ media.file_name }}</p>
                    </div>
                    <div class="mt-3 space-y-1 text-sm text-gray-600">
                        <div><strong>Tipo:</strong> {{ media.mime_type }}</div>
                        <div><strong>Dimensione:</strong> {{ media.size ? Math.round(media.size / 1024) + ' KB' : '-' }}</div>
                        <div><strong>URL:</strong> <a :href="media.url" target="_blank" class="text-blue-600 hover:underline">{{ media.url }}</a></div>
                    </div>
                </div>

                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Name -->
                    <div>
                        <InputLabel for="name" value="Nome *" />
                        <TextInput
                            id="name"
                            v-model="form.name"
                            type="text"
                            class="mt-1 block w-full"
                            required
                        />
                        <InputError :message="form.errors.name" class="mt-2" />
                    </div>

                    <!-- Description -->
                    <div>
                        <InputLabel for="description" value="Descrizione" />
                        <textarea
                            id="description"
                            v-model="form.description"
                            rows="4"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        ></textarea>
                        <InputError :message="form.errors.description" class="mt-2" />
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-between border-t pt-4">
                        <Link :href="route('admin.media.index')" class="text-sm text-gray-600 hover:text-gray-900">
                            Annulla
                        </Link>
                        <PrimaryButton :disabled="form.processing" type="submit">
                            {{ form.processing ? 'Salvataggio...' : 'Salva Modifiche' }}
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
