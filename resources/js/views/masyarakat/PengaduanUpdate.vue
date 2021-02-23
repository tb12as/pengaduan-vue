<template>
	<div>
		<div class="container" v-if="!not_found">
			<h1>Buat Pengaduan</h1>


			<div class="row">
				<div class="col-lg-6">
					<div class="card">
						<div class="card-body">
							<div class="errorValidation">
								<p class="alert alert-danger font-weight-bold" v-for="(error, index) in errorValidation" :key="index">{{ error }}</p>
							</div>

							<form @submit.prevent="updatePengaduan" enctype="multipart/form-data">
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

								<div class="my-3" v-if="form.foto">
									<img :src="form.foto" alt="" class="w-75">
								</div>

								<div class="form-group">
									<button type="submit" class="btn btn-warning btn-sm">Update Laporan</button>
								</div>
							</form>

							<router-link to="/masyarakat/pengaduan" class="btn btn-secondary btn-sm">Back</router-link>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div v-if="not_found">
			<NotFound></NotFound>
		</div>
	</div>
</template>

<script>
	import NotFound from '../NotFound.vue'
	export default {
		components: {
			NotFound
		},

		data() {
			return {
				user: {},
				form: {
					isi_laporan: '',
					foto: '',
				},
				file: {
					foto: '',
				},
				errors: [],
				not_found: false,
			}
		},

		mounted() {
			this.loadPengaduan()
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

			
			loadPengaduan() {
				axios.get('/api/masyarakat/pengaduan/'+this.$route.params.slug)
				.then((res) => {
					this.form = res.data.data
				})
				.catch((err) => {
					console.log(err)
					if (err.response.status == 404) {
						this.not_found = true
					}
				})
			},

			updatePengaduan() {
				let formData = new FormData()
				formData.append('isi_laporan', this.form.isi_laporan);
				formData.append('foto', this.file.foto);
				formData.append('_method', 'patch');


				axios.post('/api/masyarakat/pengaduan/'+this.$route.params.slug, formData)
				.then((res) => {
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
					this.file.foto =  this.$refs.foto.files[0];
					let reader = new FileReader();

					reader.onload = (e) => {
						this.form.foto = e.target.result
					}

					reader.readAsDataURL(this.$refs.foto.files[0])
				}
			}

		}
	}
</script>

