<script>
import InputText from 'primevue/inputtext';
import Dropdown from 'primevue/dropdown';
import Chips from 'primevue/chips';
import Editor from 'primevue/editor';
import FileUpload from 'primevue/fileupload';
import InputSwitch from 'primevue/inputswitch';
import Button from 'primevue/button';

export default {
    components: {
        InputText,
        Dropdown,
        Chips,
        Editor,
        FileUpload,
        InputSwitch,
        Button
    },

    data() {
        return {
            categories: [],

            form: {
                title: "",
                slug: "",
                category_id: "",
                tags: [],
                content: "",
                is_published: false,
                cover_image: null
            },

            imagePreview: null
        };
    },

    methods: {
        handleImage(event) {
            const file = event.files[0];
            this.form.cover_image = file;

            const reader = new FileReader();
            reader.onload = e => this.imagePreview = e.target.result;
            reader.readAsDataURL(file);
        },

        submitPost() {
            console.log("POST INVIATO:", this.form);
            // Esempio con axios:
            /*
            const data = new FormData();
            Object.keys(this.form).forEach(key => {
                data.append(key, this.form[key]);
            });

            axios.post('/api/posts', data);
            */
        },

        cancel() {
            this.$router.push("/admin/posts");
        }
    },

    mounted() {
        // Carica categorie (simulazione)
        // axios.get("/api/categories").then(res => this.categories = res.data);
        this.categories = [
            { id: 1, name: "Tecnologia" },
            { id: 2, name: "Lifestyle" },
            { id: 3, name: "News" }
        ];
    }
};
</script>


<template>
<div class="container create-post-page">

    <h1 class="page-title">Crea Nuovo Post</h1>

    <form @submit.prevent="submitPost" class="form-card">

        <!-- TITOLO -->
        <div class="form-group">
            <label>Titolo *</label>
            <InputText v-model="form.title" class="w-full" placeholder="Titolo del post" />
        </div>

        <!-- SLUG -->
        <div class="form-group">
            <label>Slug</label>
            <InputText v-model="form.slug" class="w-full" placeholder="slug-del-post" />
        </div>

        <!-- CATEGORIA -->
        <div class="form-group">
            <label>Categoria *</label>
            <Dropdown 
                v-model="form.category_id"
                :options="categories"
                optionLabel="name"
                optionValue="id"
                placeholder="Seleziona categoria"
                class="w-full"
            />
        </div>

        <!-- TAGS -->
        <div class="form-group">
            <label>Tags</label>
            <Chips v-model="form.tags" class="w-full" separator="," />
        </div>

        <!-- CONTENUTO -->
        <div class="form-group">
            <label>Contenuto *</label>
            <Editor 
                v-model="form.content"
                editorStyle="height: 350px"
            />
        </div>

        <!-- COVER IMAGE -->
        <div class="form-group">
            <label>Immagine di Copertina</label>
            <FileUpload 
                mode="basic"
                accept="image/*"
                customUpload
                @select="handleImage"
                chooseLabel="Carica immagine"
                class="p-button-primary"
            />
        </div>

        <div v-if="imagePreview" class="image-preview">
            <img :src="imagePreview" alt="Preview">
        </div>

        <!-- PUBBLICAZIONE -->
        <div class="form-group">
            <label>Pubblicato</label>
            <InputSwitch v-model="form.is_published" />
        </div>

        <!-- BOTTONI -->
        <div class="buttons">
            <Button label="Crea Post" icon="pi pi-check" class="p-button-success" />
            <Button label="Annulla" icon="pi pi-times" class="p-button-secondary" @click="cancel" />
        </div>

    </form>
</div>
</template>