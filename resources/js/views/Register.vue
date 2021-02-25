<template>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card">					
					<div class="card-header">
						<h5>Resgister Form</h5>
					</div>
					<div class="card-body">
						<p class="alert alert-danger" v-if="errorValidation.length > 0" v-for="(value, index) in errorValidation" :key="index">{{ value }}</p>

						<form @submit.prevent="register">

							<div class="form-group">
								<label for="nik">NIK</label>
								<input type="number" min="0" v-model="form.nik" required placeholder="NIK" class="form-control">
							</div>

							<div class="form-group">
								<label for="name">Name</label>
								<input type="text" v-model="form.name" required placeholder="Name" class="form-control">
							</div>

							<div class="form-group">
								<label for="username">Username</label>
								<input type="text" v-model="form.username" required placeholder="Username" class="form-control">
							</div>


							<div class="form-group">
								<label for="email">Email</label>
								<input type="email" v-model="form.email" required placeholder="Email" class="form-control">
							</div>


							<div class="form-group">
								<label for="telp">No Telpon</label>
								<input type="number" min="0" v-model="form.telp" required placeholder="No Telpon" class="form-control">
							</div>

							<div class="form-group">
								<label for="password">Password</label>
								<input type="password" v-model="form.password" required placeholder="Password" class="form-control">
							</div>

							<div class="form-group">
								<label for="password">Password Confirmation</label>
								<input type="password" v-model="form.password_confirmation" required placeholder="Password" class="form-control">
							</div>


							<div class="form-group">
								<input type="submit" value="Resgister" class="btn btn-primary btn-sm">
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
					name: '',
					username: '',
					email: '',
					nik: '',
					telp: '',
					password: '',
					password_confirmation: '',
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
			register() {
				axios.get('/sanctum/csrf-cookie').then(response => {
					axios.post('/register', this.form).then((res) => {
						localStorage.setItem('status', 'logged')
						this.notif('Berhasil login', 'success')
						this.$router.push('/home/');
					})
					.catch((err) => {
						console.log(err);
						if (err.response.status == 422) {
							this.errors = err.response.data.errors;
						}
					})
				});
			}
		}
	}
</script>

