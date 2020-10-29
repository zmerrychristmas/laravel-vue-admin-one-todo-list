import Vue from 'vue'
import Router from 'vue-router'
import Home from './views/Home.vue'
import store from './store.js';

Vue.use(Router)
function requireAuth (to, from, next) {
  function proceed () {
    if(to.meta.permission == 'admin') {
      if (store.state.isAdmin) {
        next()
      } else {
        next('')
      }
    } else {
      next()
    }
  }
  proceed()
}

/*
  Makes a new VueRouter that we will use to run all of the routes
  for the app.
*/
export default new Router({
  base: process.env.BASE_URL,
  routes: [
    {
      path: '',
      name: 'home',
      component: Home
    },
    {
      path: '/tasks/index',
      name: 'tasks.index',
      component: () => import('./views/Tasks/TasksIndex.vue'),
    },
    {
      path: '/tasks/new',
      name: 'tasks.new',
      component: () => import('./views/Tasks/TasksForm.vue'),
      beforeEnter: requireAuth,
      meta: {
        permission: 'admin'
      }
    },
    {
      path: '/tasks/:id',
      name: 'tasks.edit',
      component: () => import('./views/Tasks/TasksForm.vue'),
      beforeEnter: requireAuth,
      meta: {
        permission: 'admin'
      },
      props: true
    }
  ],
  scrollBehavior (to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition
    } else {
      return { x: 0, y: 0 }
    }
  },
})
