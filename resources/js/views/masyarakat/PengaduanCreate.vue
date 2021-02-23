<template>
	<div class="container">
		<h1>Buat Pengaduan</h1>

		
		<div class="row">
			<div class="col-lg-6">
				<div class="card">
					<div class="card-body">
						<div class="errorValidation">
							<p class="alert alert-danger font-weight-bold" v-for="(error, index) in errorValidation" :key="index">{{ error }}</p>
						</div>

						<form @submit.prevent="savePengaduan" enctype="multipart/form-data">
							<div class="form-group">
								<label>NIK</label>
								<input type="text" disabled v-model="user.nik" class="form-control disabled">
							</div>

							<div class="form-group">
								<label for="laporan">Isi Laporan</label>
								<textarea id="laporan" v-model="form.isi_laporan" rows="5" class="form-control"></textarea>
							</div>

							<div class="form-group">
								<label for="foto">Gambar</label>
								<input id="foto" type="file" ref="foto" class="form-control" @change="handleFoto" accept="image/*">
							</div>

							<div class="form-group">
								<button type="submit" class="btn btn-primary btn-sm">Kirim Laporan</button>
							</div>
						</form>

						<router-link to="/masyarakat/pengaduan" class="btn btn-secondary btn-sm">Back</router-link>
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
				user: {},
				form: {
					isi_laporan: '',
					foto: '',
				},
				errors: []
			}
		},

		mounted() {
			this.loadUser()
		},

		computed: {
			errorValidation() {
				return Object.values(this.errors).flat()
			}
		},

		methods: {
			loadUser() {
				axios.get('/api/user').then(response => {
					// console.log(response.data)
					this.user = response.data
				})
				.catch((err) => {
					console.log(err)
				})
			},

			async savePengaduan() {
				let formData = new FormData;
				formData.append('isi_laporan', this.form.isi_laporan);
				formData.append('foto', this.form.foto);

				await axios.post('/api/masyarakat/pengaduan/', formData).then((res) => {
					this.$router.push('/masyarakat/pengaduan/')
					// console.log(res)
				})
				.catch((err) => {
					console.log(err)
					if (err.response.status == 422) {
						this.errors = err.response.data.errors;
					}
				})
			},

			handleFoto() {
				if (this.$refs.foto.files[0]) {
					this.form.foto =  this.$refs.foto.files[0];
				}
			}

		}
	}
</script>