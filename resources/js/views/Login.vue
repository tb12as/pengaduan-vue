<template>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-6">
				<div class="card">					
					<div class="card-header">
						<h5>Login</h5>
					</div>
					<div class="card-body">
						<div class="errorValidation">
							<p class="alert alert-danger font-weight-bold" v-for="(error, index) in errorValidation" :key="index">{{ error }}</p>
						</div>

						<form @submit.prevent="login">
							<div class="form-group">
								<label for="username">Username</label>
								<input type="text" v-model="form.username" placeholder="Username" class="form-control">
							</div>

							<div class="form-group">
								<label for="password">Password</label>
								<input type="password" v-model="form.password" placeholder="Password" class="form-control">
							</div>


							<div class="form-group">
								<input type="submit" value="Login" class="btn btn-primary btn-sm">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				form: {
					username: '',
					password: '',
				},
				errors: [],
			}
		},

		computed: {
			errorValidation() {
				return Object.values(this.errors).flat()
			}
		},

		methods: {
			login() {
				axios.get('/sanctum/csrf-cookie').then(response => {
					axios.post('/login', this.form).then(response => {
						localStorage.setItem('status', 'logged')
						this.$router.push('/home/');
					})
					.catch((err) => {
						console.log(err)
						if (err.response.status == 422) {
							this.errors = err.response.data.errors
						}
					})
				});
			}
		}
	}
</script>