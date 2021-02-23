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
				this.$swal.fire({
					title: 'Logout sekarang?',
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Logout',
					cancelButtonText: 'Batal',
				}).then((result) => {
					if (result.isConfirmed) {
						axios.post('/logout').then(response => {
							localStorage.setItem('status', '')
							this.notif('Berhasil logout', 'success')
							this.$router.push('/login')
						})
						.catch((err) => {
							console.log(err)
						})
						
					}
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