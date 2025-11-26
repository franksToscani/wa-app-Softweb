<!--


import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
    posts: { type: Array, default: () => [] },
    products: { type: Array, default: () => [] },
})

const showDialog = ref(false)
const selectedPost = ref(null)

function openPost(post) {
    selectedPost.value = post
    showDialog.value = true
}

function closeDialog() {
    showDialog.value = false
    selectedPost.value = null
}
</script>

<template>


    <Head title="Crea Prodotto" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Crea Prodotto</h2>
        </template>
    </AuthenticatedLayout>

    <form action=""></form>
</template>

<div id="create-product-page" class="container">

     HEADER 
    <header class="page-header">
        <h1>Crea Nuovo Prodotto</h1>
        <p>Inserisci tutte le informazioni necessarie per aggiungere un nuovo prodotto al catalogo.</p>
    </header>

    <form @submit.prevent="submitProduct" class="product-form">

         SEZIONE BASE INFO 
        <section class="section-block">
            <h2>Informazioni di Base</h2>

            <div class="form-row">
                <label for="name">Nome Prodotto *</label>
                <input type="text" id="name" v-model="form.name" required>
            </div>

            <div class="form-row">
                <label for="slug">Slug (URL)</label>
                <input type="text" id="slug" v-model="form.slug">
            </div>

            <div class="form-row">
                <label for="brand">Marca</label>
                <input type="text" id="brand" v-model="form.brand">
            </div>

            <div class="form-row">
                <label for="category">Categoria *</label>
                <select id="category" v-model="form.category_id" required>
                    <option disabled value="">Seleziona categoria...</option>
                    <option v-for="cat in categories" :key="cat.id" :value="cat.id">
                        {{ cat.name }}
                    </option>
                </select>
            </div>

            <div class="form-row">
                <label for="short_description">Descrizione Breve</label>
                <textarea id="short_description" v-model="form.short_description"></textarea>
            </div>

            <div class="form-row">
                <label for="description">Descrizione Completa *</label>
                <textarea id="description" rows="6" v-model="form.description" required></textarea>
            </div>
        </section>

        SEZIONE PREZZI 
        <section class="section-block">
            <h2>Prezzi</h2>

            <div class="form-row">
                <label for="price">Prezzo (€) *</label>
                <input type="number" id="price" v-model="form.price" step="0.01" required>
            </div>

            <div class="form-row">
                <label for="discount_price">Prezzo Scontato (€)</label>
                <input type="number" id="discount_price" v-model="form.discount_price" step="0.01">
            </div>
        </section>

        SEZIONE INVENTARIO 
        <section class="section-block">
            <h2>Inventario</h2>

            <div class="form-row">
                <label for="sku">SKU *</label>
                <input type="text" id="sku" v-model="form.sku" required>
            </div>

            <div class="form-row">
                <label for="stock">Quantità Magazzino *</label>
                <input type="number" id="stock" v-model="form.stock" required>
            </div>

            <div class="form-row">
                <label for="status">Stato *</label>
                <select id="status" v-model="form.status" required>
                    <option value="draft">Bozza</option>
                    <option value="published">Pubblicato</option>
                    <option value="hidden">Nascosto</option>
                </select>
            </div>
        </section>

         SEZIONE ATTRIBUTI & VARIANTI 
        <section class="section-block">
            <h2>Varianti</h2>

            <div class="variants-area">
                <div class="variant-row" v-for="(variant, index) in form.variants" :key="index">
                    <input type="text" v-model="variant.name" placeholder="Es: Colore">
                    <input type="text" v-model="variant.value" placeholder="Es: Rosso">
                    <button type="button" @click="removeVariant(index)">Rimuovi</button>
                </div>

                <button type="button" class="btn-add" @click="addVariant">+ Aggiungi Variante</button>
            </div>
        </section>

         SEZIONE IMMAGINI 
        <section class="section-block">
            <h2>Immagini Prodotto</h2>

            <div class="form-row">
                <label for="images">Carica Immagini (multiple)</label>
                <input type="file" id="images" multiple @change="handleImages">
            </div>

            <div class="image-preview-list">
                <div class="preview" v-for="(img, i) in previewImages" :key="i">
                    <img :src="img" alt="preview">
                </div>
            </div>
        </section>

         SEZIONE SEO 
        <section class="section-block">
            <h2>SEO</h2>

            <div class="form-row">
                <label for="meta_title">Meta Title</label>
                <input type="text" id="meta_title" v-model="form.meta_title">
            </div>

            <div class="form-row">
                <label for="meta_description">Meta Description</label>
                <textarea id="meta_description" v-model="form.meta_description"></textarea>
            </div>
        </section>

         BOTTONI 
        <div class="form-actions">
            <button type="submit" class="btn-submit">Crea Prodotto</button>
            <button type="button" class="btn-cancel" @click="cancel">Annulla</button>
        </div>

    </form>
</div>>

-->
