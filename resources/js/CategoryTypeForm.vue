<script setup>
import { ref } from 'vue'
import axios from 'axios'

import Card from 'primevue/card'
import InputText from 'primevue/inputtext'
import Button from 'primevue/button'
import Toast from 'primevue/toast'
import { useToast } from 'primevue/usetoast'

const toast = useToast()
const name = ref('')
const saving = ref(false)

const save = async () => {
  if (!name.value.trim()) {
    toast.add({ severity:'warn', summary:'Attenzione', detail:'Inserisci un nome', life:2000 })
    return
  }
  saving.value = true
  try {
    // La rotta è ESATTAMENTE quella definita in web.php (POST /category-types)
    await axios.post('/category-types', { name: name.value.trim() })
    toast.add({ severity:'success', summary:'Salvato', detail:'Category type inserito', life:2000 })
    name.value = ''
  } catch (e) {
    const msg = e.response?.data?.message || e.message || 'Errore'
    toast.add({ severity:'error', summary:'Errore', detail: msg, life:3000 })
  } finally {
    saving.value = false
  }
}
</script>

<template>
  <Toast />
  <Card>
    <template #title>
      <div style="font-weight:800; letter-spacing:.3px">Nuovo Category Type</div>
    </template>
    <template #subtitle>
      <div style="opacity:.8">Inserisci solo il <b>nome</b> (max 50 caratteri)</div>
    </template>
    <template #content>
      <div class="p-fluid" style="display:grid; grid-template-columns:1fr; gap:12px;">
        <div>
          <label style="display:block; margin-bottom:6px;">Nome</label>
          <InputText v-model="name" placeholder="Esempio: blog, product, news…" maxlength="50" />
        </div>
        <div>
          <Button :loading="saving" label="Salva" icon="pi pi-check" @click="save" />
        </div>
      </div>
    </template>
  </Card>
</template>
