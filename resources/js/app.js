
require('./bootstrap');

import Vue from 'vue';
import router from './router';

import VueToasted from 'vue-toasted';

import VueSweetalert2 from 'vue-sweetalert2';

// If you don't need the styles, do not connect
import 'sweetalert2/dist/sweetalert2.min.css';

Vue.use(VueSweetalert2); // https://www.npmjs.com/package/vue-sweetalert2
Vue.use(VueToasted); // https://github.com/shakee93/vue-toasted


Vue.mixin({
	methods: {
		notif(pesan, type) {
			this.$toasted.show(pesan, {
				keepOnHover: true,
				duration: 2000,
				type: type || 'info',
			})
		}
	}
})
Vue.component('App', require('./components/App.vue').default);

const app = new Vue({
	el: '#app',
	router: router
});
