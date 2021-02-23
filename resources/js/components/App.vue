<template>
	<div class="container">
		<router-view></router-view>
		<button class="btn btn-danger logout-btn" v-if="login" @click="logout">Logout</button>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				get login() {
					return localStorage.status == 'logged' ? true : false;
				}
			}
		},

		methods: {
			logout() {
				axios.post('/logout').then(response => {
					localStorage.setItem('status', '')
					this.$router.push('/login')
				})
				.catch((err) => {
					console.log(err)
				})
			}
		}
	}
</script>

<style>
	.logout-btn {
		position: fixed;
		bottom: 30px;
		right: 40px;
	}
</style>