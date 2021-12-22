import Vue from 'vue'
import Router from 'vue-router'
import firstPage from './components/pages/myFirstVuePage'
import secondPage from './components/pages/mySecondVuePage'
import hooks from './components/pages/basic/hooks'
import methods from './components/pages/basic/methods'

import home from './components/pages/home'
import usecom from './vuex/usecom'
import login from './admin/pages/login'
import role from './admin/pages/role'

import positions from './admin/pages/positions'
import departements from './admin/pages/departements'
import users from './admin/pages/users'
import employees from './admin/pages/employees'

Vue.use(Router)

const routes = [
    // vuex
    {
        path: '/testvuex',
        component: usecom
    }, 

    // Projects routes...
    {
        path: '/',
        component: home
    }, 
    {
        path: '/positions',
        component: positions
    }, 
    {
        path: '/departements',
        component: departements
    }, 
    {
        path: '/users',
        component: users
    }, 
    {
        path: '/employees',
        component: employees
    }, 
    {
        path: '/login',
        component: login
    }, 
    {
        path: '/role',
        component: role
    }, 



    // basic tutorial routes...
    {
        path: '/my-new-vue-route',
        component: firstPage
    }, 
    {
        path: '/my-second-vue-route',
        component: secondPage
    }, 

    // vue hooks
    {
        path: '/hooks',
        component: hooks
    }, 

    // vue methods
    {
        path: '/methods',
        component: methods
    }, 
]

export default new Router ({
    mode: 'history', 
    routes
})