import { createRouter, createWebHistory } from 'vue-router';

import LoginPage from '../components/LoginPage.vue';
import RegisterPage from '../components/RegisterPage.vue';
import AboutPage from '../components/AboutPage.vue';
import HomePage from '../components/HomePage.vue';

import ProductPage from '../components/ProductPage.vue';
import ProductEditPage from '../components/ProductEditPage.vue';
import ProductCreatePage from '../components/ProductCreatePage.vue';

import UserDashboard from '../components/UserDashboard.vue'; // layout utama (dengan navbar)
import Dashboard from '../components/Dashboard.vue';         // isi dashboard utama (list user)
import UserUpdatePage from '../components/UserUpdatePage.vue'; // edit user
import UserCreatePage from '../components/UserCreatePage.vue'; // tambah user

const routes = [
  { path: '/', redirect: '/home' },
  { path: '/home', component: HomePage },
  { path: '/product/:id', component: ProductPage },
  { path: '/product/edit/:id', component: ProductEditPage },
  { path: '/product/create', component: ProductCreatePage },

  { path: '/login', component: LoginPage },       // tanpa navbar
  { path: '/register', component: RegisterPage }, // tanpa navbar
  { path: '/about', component: AboutPage },       // tanpa navbar atau sesuai kebutuhan

  // Nested Dashboard Routes dengan layout UserDashboard
  {
    path: '/dashboard',
    component: UserDashboard, // layout dengan navbar
    children: [
      {
        path: '',
        component: Dashboard, // default child route (user list)
      },
      {
        path: 'update/:id',
        component: UserUpdatePage, // edit user
      },
      {
        path: 'create',
        component: UserCreatePage, // tambah user
      },
    ],
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
