import { createApp } from 'vue'
import App from './App.vue'

import 'primevue/resources/themes/bootstrap4-light-blue/theme.css'
import 'primevue/resources/primevue.min.css'                 // core css
import 'primeicons/primeicons.css'

import PrimeVue from 'primevue/config';

const app = createApp(App)

app.mount('#app')

app.use(PrimeVue);
