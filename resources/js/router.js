import Vue from 'vue'
import Router from 'vue-router'
import firstPage from './components/pages/myFirstVuePage'
import secondPage from './components/pages/mySecondVuePage'
import hooks from './components/pages/basic/hooks'
import methods from './components/pages/basic/methods'

import home from './components/pages/home'
import tags from './admin/pages/tags'
import categories from './admin/pages/categories'
import usecom from './vuex/usecom'

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
        path: '/tags',
        component: tags
    }, 
    {
        path: '/categories',
        component: categories
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