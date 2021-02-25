import VueRouter from 'vue-router'
import Vue from 'vue'

// global
import Login from '../views/Login.vue'
import Register from '../views/Register.vue'
import Home from '../views/Home.vue'
import NotFound from '../views/NotFound.vue'

// masyarakat
import Pengaduan from '../views/masyarakat/Pengaduan.vue'
import PengaduanCreate from '../views/masyarakat/PengaduanCreate.vue'
import PengaduanDetail from '../views/masyarakat/PengaduanDetail.vue'
import PengaduanUpdate from '../views/masyarakat/PengaduanUpdate.vue'

// admin - petugas
import PengaduanIndex from '../views/admin/PengaduanIndex.vue'
import DetailPengaduan from '../views/admin/DetailPengaduan.vue'


Vue.use(VueRouter)

const router = new VueRouter({
	mode: 'history',
	activeLinkClass: 'active',
	routes: [
	{path: '/login/', component: Login, meta: {loginPage: true}},
	{path: '/register/', component: Register, meta: {loginPage: true}},
	{path: '/home/', component: Home, meta: {requiresAuth: true}},
	{path: '/masyarakat/pengaduan/', component: Pengaduan, meta: {requiresAuth: true}},
	{path: '/masyarakat/pengaduan/create', component: PengaduanCreate, meta: {requiresAuth: true}},
	{path: '/masyarakat/pengaduan/:slug', name: 'PengaduanDetail', component: PengaduanDetail, meta: {requiresAuth: true}},
	{path: '/masyarakat/pengaduan/:slug/edit', name: 'PengaduanUpdate', component: PengaduanUpdate, meta: {requiresAuth: true}},
	{path: '/admin/pengaduan/', component: PengaduanIndex, meta: {requiresAuth: true}},
	{path: '/admin/pengaduan/:slug/', name: 'DetailPengaduan', component: DetailPengaduan, meta: {requiresAuth: true}},

	{path: '*', component: NotFound },
	],
}) 

router.beforeEach((to, from, next) => {
	if (to.matched.some(record => record.meta.requiresAuth)) {
		// this route requires auth, check if logged in
		// if not, redirect to login page.
		if (localStorage.status !== 'logged') {
			next({
				path: '/login',
				query: { redirect: '/home/' }
			})
		} else {
			next()
		}
	} else {
		next() // make sure to always call next()!
	}

	if (to.matched.some(record => record.meta.loginPage)) {
		// this route requires auth, check if logged in
		// if not, redirect to login page.
		if (localStorage.status === 'logged') {
			next({
				path: '/home',
			})
		} else {
			next()
		}
	} else {
		next() // make sure to always call next()!
	}
})

export default router
