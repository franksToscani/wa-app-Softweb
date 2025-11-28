




<template>
  <Card>
    <h2 class="mb-4">Crea Nuovo Post</h2>

    <form @submit.prevent="submit" class="space-y-4">
      <!-- Title -->
      <div>
        <label class="block mb-1 font-medium">Titolo *</label>
        <InputText name="title" v-model="form.title" placeholder="Titolo del post" />
        <small v-if="form.errors.title" class="p-error">{{ form.errors.title }}</small>
      </div>

      <!-- Slug -->
      <div>
        <label class="block mb-1 font-medium">Slug</label>
        <InputText name="slug" v-model="form.slug" @input="onSlugEdit" placeholder="slug-del-post" />
        <small v-if="form.errors.slug" class="p-error">{{ form.errors.slug }}</small>
      </div>

      <!-- Category -->
      <div>
        <label class="block mb-1 font-medium">Categoria *</label>
        <Dropdown
          name="category_id"
          :options="categoriesOptions"
          optionLabel="name"
          optionValue="id"
          v-model="form.category_id"
          placeholder="Seleziona categoria"
        />
        <small v-if="form.errors.category_id" class="p-error">{{ form.errors.category_id }}</small>
      </div>

      <!-- Tags (comma separated) -->
      <div>
        <label class="block mb-1 font-medium">Tags</label>
        <InputTextarea name="tags" v-model="tagsInput" rows="2" placeholder="tag1, tag2, tag3" />
        <small v-if="form.errors.tags" class="p-error">{{ form.errors.tags }}</small>
      </div>

      <!-- Content (Quill/Editor) -->
      <div>
        <label class="block mb-1 font-medium">Contenuto *</label>
        <Editor name="content" v-model="form.content" :style="{ minHeight: '220px' }" />
        <small v-if="form.errors.content" class="p-error">{{ form.errors.content }}</small>
      </div>

      <!-- Cover image upload -->
      <div>
        <label class="block mb-1 font-medium">Immagine di Copertina</label>
        <FileUpload
          name="cover_image"
          chooseLabel="Carica immagine"
          customUpload
          :auto="false"
          :maxFileSize="5 * 1024 * 1024"
          accept="image/*"
          @select="onFileSelect"
        />
        <div v-if="previewUrl" class="mt-2">
          <img :src="previewUrl" alt="preview" style="max-width:240px; max-height:160px; border-radius:6px;" />
        </div>
        <small v-if="form.errors.cover_image" class="p-error">{{ form.errors.cover_image }}</small>
      </div>

      <!-- Published -->
      <div class="flex items-center gap-3">
        <input id="published" name="published" type="checkbox" v-model="form.published" />
        <label for="published">Pubblicato</label>
      </div>

      <!-- Actions -->
      <div class="flex gap-3 mt-4">
        <button type="submit" class="p-button p-component p-button-primary" :disabled="form.processing">
          Crea Post
        </button>
        <button type="button" class="p-button p-component" @click="cancel" :disabled="form.processing">
          Annulla
        </button>
      </div>
    </form>
  </Card>
</template>

<script setup>
import { ref, computed, watch } from 'vue';
import { useForm, usePage } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';

// PrimeVue components (local import — rende il componente disponibile nel template con <script setup>)
import Card from 'primevue/card';
import InputText from 'primevue/inputtext';
import InputTextarea from 'primevue/textarea';
import Dropdown from 'primevue/dropdown';
import FileUpload from 'primevue/fileupload';
import Editor from 'primevue/editor';

// server props
const page = usePage();
const props = page.props.value || {};
const categories = props.categories ?? [];

// slugify helper
function slugify(value = '') {
  return value
    .toString()
    .toLowerCase()
    .trim()
    .replace(/\s+/g, '-')
    .replace(/[^\w\-]+/g, '')
    .replace(/\-\-+/g, '-')
    .replace(/^-+/, '')
    .replace(/-+$/, '');
}

// form
const form = useForm({
  title: '',
  slug: '',
  content: '',
  category_id: categories.length ? categories[0].id : null,
  tags: null,
  cover_image: null,
  published: false,
});

const previewUrl = ref(null);
const slugManuallyEdited = ref(false);
const tagsInput = ref('');

// computed options
const categoriesOptions = computed(() => categories);

// auto slug
watch(
  () => form.title,
  (val) => {
    if (!slugManuallyEdited.value) form.slug = slugify(val);
  }
);

function onSlugEdit() {
  slugManuallyEdited.value = true;
}

watch(tagsInput, (val) => {
  const arr = val
    .split(',')
    .map((t) => t.trim())
    .filter(Boolean);
  form.tags = arr;
});

function onFileSelect(e) {
  const file = e.files?.[0];
  if (!file) return;
  form.cover_image = file;
  const reader = new FileReader();
  reader.onload = (ev) => (previewUrl.value = ev.target.result);
  reader.readAsDataURL(file);
}

function submit() {
  form.post(route('admin.posts.store'), {
    forceFormData: true,
    onFinish: () => {},
    onSuccess: () => {},
    onError: (errors) => {
      const first = Object.keys(errors || {})[0];
      if (first) {
        const el = document.querySelector(`[name="${first}"]`);
        if (el) el.focus();
      }
    },
  });
}

function cancel() {
  Inertia.visit(route('admin.posts.index'));
}
</script>

<style scoped>
.p-error {
  color: #dc2626;
  font-size: 0.875rem;
}
</style>