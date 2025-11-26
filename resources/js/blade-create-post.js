import { createApp } from 'vue'
import PrimeVue from 'primevue/config'
import InputText from 'primevue/inputtext'
import Dropdown from 'primevue/dropdown'
import Chips from 'primevue/chips'
import Editor from 'primevue/editor'
import FileUpload from 'primevue/fileupload'
import InputSwitch from 'primevue/inputswitch'
import Button from 'primevue/button'

// The SFC we already have in the project
import CreatePost from './Pages/admin/posts/Create.vue'

const mountEl = document.getElementById('create-post-app')
if (mountEl) {
  const app = createApp(CreatePost, JSON.parse(mountEl.dataset.props || '{}'))
  app.use(PrimeVue)
  app.component('InputText', InputText)
  app.component('Dropdown', Dropdown)
  app.component('Chips', Chips)
  app.component('Editor', Editor)
  app.component('FileUpload', FileUpload)
  app.component('InputSwitch', InputSwitch)
  app.component('PButton', Button)
  app.mount(mountEl)
}
