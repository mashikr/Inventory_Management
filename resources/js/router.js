import Login from './components/Login.vue';
import Home from './components/Home.vue';

import addEmployee from './components/Employee/addEmployee.vue';
import allEmployee from './components/Employee/allEmployee.vue';
import editEmployee from './components/Employee/editEmployee.vue';

import addSupplier from './components/Supplier/add.vue';
import allSupplier from './components/Supplier/index.vue';
import editSupplier from './components/Supplier/edit.vue';

import addCategory from './components/Category/add.vue';
import allCategory from './components/Category/index.vue';
import editCategory from './components/Category/edit.vue';

import addProduct from './components/Product/add.vue';
import allProduct from './components/Product/index.vue';
import editProduct from './components/Product/edit.vue';

export const routes = [
    { path: '/', component: Login, name: '/' },
    { path: '/home', component: Home, name: 'home' },

    { path: '/employee/add', component: addEmployee, name: 'addEmployee' },
    { path: '/employee/all', component: allEmployee, name: 'allEmployee' },
    { path: '/employee/edit/:id', component: editEmployee, name: 'editEmployee' },

    { path: '/supplier/add', component: addSupplier, name: 'addSupplier' },
    { path: '/supplier/all', component: allSupplier, name: 'allSupplier' },
    { path: '/supplier/edit/:id', component: editSupplier, name: 'editSupplier' },
    
    { path: '/category/add', component: addCategory, name: 'addCategory' },
    { path: '/category/all', component: allCategory, name: 'allCategory' },
    { path: '/category/edit/:id', component: editCategory, name: 'editCategory' },

    { path: '/product/add', component: addProduct, name: 'addProduct' },
    { path: '/product/all', component: allProduct, name: 'allProduct' },
    { path: '/product/edit/:id', component: editProduct, name: 'editProduct' },
]