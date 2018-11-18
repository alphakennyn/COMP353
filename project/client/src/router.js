import Vue from 'vue'
import Router from 'vue-router'
import UserPage from './views/UserPage.vue'
import LoginPage from './views/LoginPage.vue'

Vue.use(Router)

const Auth = {
  loggedIn: false,
  login: () => { this.loggedIn = true },
  logout: () => { this.loggedIn = false }
};

const router = new Router({
  // mode: 'history',
  routes: [
    {
      path: '/',
      name: 'home',
      component: LoginPage
    },
    {
      path: '/user/:id',
      name: 'user',
      component: UserPage,
      props: true,
    },
    {
      path: '/login',
      name: 'login',
      component: LoginPage,
    }
  ]
})

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth) && !Auth.loggedIn) {
    next({ path: '/', query: { redirect: to.fullPath } });
  } else {
    next();
  }
});

export default router;