// src/main.js
import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import './assets/style.min.css';

import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faHome, faPhone, faEnvelope } from '@fortawesome/free-solid-svg-icons';
library.add(faHome, faPhone, faEnvelope);


const app = createApp(App);

app.component('font-awesome-icon', FontAwesomeIcon);

app.use(router);
app.mount('#app');
