import Vue from 'vue'
import VueRouter from 'vue-router'
import recherche from './routes/recherche'
Vue.use(VueRouter)

const routes = [

  ...recherche,
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
