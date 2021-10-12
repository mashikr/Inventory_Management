import Login from './components/Login.vue';
import Home from './components/Home.vue';

import addEmployee from './components/Employee/addEmployee.vue';
import allEmployee from './components/Employee/allEmployee.vue';
import editEmployee from './components/Employee/editEmployee.vue';

export const routes = [
    { path: '/', component: Login, name: '/' },
    { path: '/home', component: Home, name: 'home' },
    { path: '/employee/add', component: addEmployee, name: 'addEmployee' },
    { path: '/employee/all', component: allEmployee, name: 'allEmployee' },
    { path: '/employee/edit/:id', component: editEmployee, name: 'editEmployee' },
]