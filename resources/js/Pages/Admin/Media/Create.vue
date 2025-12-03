<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import InputLabel from '@/Components/InputLabel.vue'
import TextInput from '@/Components/TextInput.vue'
import InputError from '@/Components/InputError.vue'

const fileInput = ref(null)
const filePreview = ref(null)

const form = useForm({
    file: null,
    name: '',
    description: '',
})

function handleFileChange(event) {
    const file = event.target.files[0]
    if (file) {
        form.file = file
        if (!form.name) {
            form.name = file.name
        }
        
        // Create preview for images
        if (file.type.startsWith('image/')) {
            const reader = new FileReader()
            reader.onload = (e) => {
                filePreview.value = e.target.result
            }
            reader.readAsDataURL(file)
        } else {
            filePreview.value = null
        }
    }
}

function submit() {
    form.post(route('admin.media.store'), {
        preserveScroll: true,
    })
}
</script>

<template>
    <Head title="Carica Media" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">Carica Nuovo Media</h2>
                <Link :href="route('admin.media.index')" class="text-sm text-gray-600 hover:text-gray-900">
                    ← Torna alla lista
                </Link>
            </div>
        </template>

        <div class="p-6">
            <div class="mx-auto max-w-3xl rounded-lg border bg-white p-6 shadow">
                <form @submit.prevent="submit" class="space-y-6">
                    <!-- File Upload -->
                    <div>
                        <InputLabel for="file" value="File *" />
                        <div class="mt-2">
                            <input
                                ref="fileInput"
                                id="file"
                                type="file"
                                class="block w-full rounded border border-gray-300 px-3 py-2 text-sm file:mr-4 file:rounded file:border-0 file:bg-gray-100 file:px-4 file:py-2 file:text-sm file:font-semibold hover:file:bg-gray-200"
                                @change="handleFileChange"
                                required
                            />
                        </div>
                        <InputError :message="form.errors.file" class="mt-2" />
                        
                        <!-- Image Preview -->
                        <div v-if="filePreview" class="mt-4">
                            <img :src="filePreview" alt="Anteprima" class="max-h-64 rounded border" />
                        </div>
                    </div>

                    <!-- Name -->
                    <div>
                        <InputLabel for="name" value="Nome" />
                        <TextInput
                            id="name"
                            v-model="form.name"
                            type="text"
                            class="mt-1 block w-full"
                            placeholder="Nome del file"
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
                            placeholder="Descrizione opzionale del file"
                        ></textarea>
                        <InputError :message="form.errors.description" class="mt-2" />
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-between border-t pt-4">
                        <Link :href="route('admin.media.index')" class="text-sm text-gray-600 hover:text-gray-900">
                            Annulla
                        </Link>
                        <PrimaryButton :disabled="form.processing" type="submit">
                            {{ form.processing ? 'Caricamento...' : 'Carica Media' }}
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
