import Vue from 'vue'
import Router from 'vue-router'
import UserPage from './views/UserPage.vue'
import EmployeePage from './views/EmployeePage.vue'
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
      path: '/user/:id',
      name: 'user',
      component: UserPage,
      props: true,
    },
    {
      path: '/employee/:id',
      name: 'employee',
      component: EmployeePage,
      props: true,
    },
    {
      path: '/login',
      name: 'login',
      component: LoginPage,
    }
  ]
})

export default router;