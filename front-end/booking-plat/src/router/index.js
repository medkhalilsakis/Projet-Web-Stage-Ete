import { createRouter, createWebHistory } from 'vue-router';

import AccueilPage from '../components/AccueilPage.vue';

import SignUpPage from '../components/Authentification/SignUpPage.vue';
import LoginPage from '../components/Authentification/LoginPage.vue';

import AboutPage from '../components/Pages/AboutPage.vue';
import BlogPage from '../components/Pages/BlogPage.vue';
import ContactPage from '../components/Pages/ContactPage.vue';

import NotFoundPage from '../components/Pages/NotFoundPage.vue';

import ClientDash from '../components/Dashboards/ClientDash.vue';
import AdminDash from '../components/Dashboards/AdminDash.vue';
import BlogDetail from '@/components/Pages/BlogDetail.vue';
const routes = [
  {
    path: '/',
    name: 'AccueilPage',
    component: AccueilPage
  },
  {
    path: '/signup',
    name: 'SignUpPage',
    component: SignUpPage
  },
  {
    path: '/login',
    name: 'LoginPage',
    component: LoginPage
  },
  {
    path: '/about',
    name: 'AboutPage',
    component: AboutPage
  },
  {
    path: '/blog',
    name: 'BlogPage',
    component: BlogPage
  },
  {
    path: '/blog/:id',
    name: 'BlogDetail',
    component: BlogDetail
  },
  {
    path: '/contact',
    name: 'ContactPage',
    component: ContactPage
  },

  {
    path: '/client-dashboard',
    name: 'ClientDash',
    component: ClientDash,
    meta: { hideNavbar: true, requiresAuth: true },
    beforeEnter: (to, from, next) => {
      const user = JSON.parse(localStorage.getItem('user'));
      if (user && user.IDCARD) {
        next();
      } else {
        next('/');
      }
    }
  },
  {
    path: '/admin-dashboard',
    name: 'AdminDash',
    component: AdminDash,
    meta: { hideNavbar: true, requiresAuth: true },
    beforeEnter: (to, from, next) => {
      const user = JSON.parse(localStorage.getItem('user'));
      if (user && user.IDCARD === null) {
        next();
      } else {
        next('/');
      }
    }
  },
  {
    path: '/:catchAll(.*)',
    name: 'NotFoundPage',
    component: NotFoundPage
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

router.beforeEach((to, from, next) => {
  const loggedIn = JSON.parse(localStorage.getItem('user'));

  if (to.matched.some(record => record.meta.requiresAuth) && !loggedIn) {
    next('/');
  } else {
    next();
  }
});

export default router;
