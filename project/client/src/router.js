import Vue from 'vue'
import Router from 'vue-router'
import UserPage from './views/UserPage.vue'
import LoginPage from './views/LoginPage.vue'

Vue.use(Router)

const router = new Router({
  routes: [
    {
      path: '/',
      name: 'home',
      redirect: {
        name: 'login'
      }
    },
    {
<<<<<<< HEAD
      path: '/admin',
      name: 'admin',
      // route level code-splitting
      // this generates a separate chunk (about.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import(/* webpackChunkName: "admin" */ './views/Admin.vue')
=======
      path: '/user/:id',
      name: 'user',
      component: UserPage,
      props: true,
>>>>>>> 718a2aa8682ac3889526c2181430764c8118f102
    },
    {
      path: '/login',
      name: 'login',
      component: LoginPage,
    }
  ]
})

export default router;