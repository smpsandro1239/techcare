import './bootstrap';

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// Importar Vue
import { createApp } from 'vue';
import App from './App.vue';  

// Crear y montar la aplicación Vue
const app = createApp(App);
app.mount('#app');  

