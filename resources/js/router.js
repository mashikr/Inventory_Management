import Login from './components/Login.vue';
import Home from './components/Home.vue';

export const routes = [
    { path: '/', component: Login, name: '/' },
    { path: '/home', component: Home, name: 'home' },
]