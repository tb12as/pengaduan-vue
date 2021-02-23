<template>
	<div>
		<div class="container" v-if="!not_found">
			<h1>Detail Pengaduan</h1>

			<div class="row">
				<div class="col-md-6">
					<div class="card my-2" v-if="!render">
						<div class="card-header">
							<h5>Detail Laporan</h5>
						</div>
						<div class="card-body">
							<div class="form-group my-3">
								<label for="">Nama Masyarakat</label>
								<input type="text" v-model="pengaduan.user.name" class="form-control" disabled="">
							</div>

							<div class="form-group my-3">
								<label for="">NIK</label>
								<input type="text" v-model="pengaduan.user.nik" class="form-control" disabled="">
							</div>

							<div class="form-group my-3">
								<label for="">Telpon</label>
								<input type="text" v-model="pengaduan.user.telp" class="form-control" disabled="">
							</div>


							<div class="form-group my-3">
								<label for="">Nama Masyarakat</label>
								<textarea class="form-control" rows="5" disabled v-model="pengaduan.isi_laporan"></textarea>
							</div>


							<div v-if="pengaduan.foto" class="my-3">
								<img class="w-75" :src="pengaduan.foto" alt="">
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="card my-2" v-if="!render && pengaduan.tanggapan == null">
						<div class="card-header">
							<h5>Berikan Tanggapan</h5>
						</div>
						<div class="card-body">
							<p class="alert alert-danger">Laporan ini belum ditanggapi</p>

							<form @submit.prevent="tanggapi">
								<div class="form-group my-3">
									<label for="tanggapan">Tanggapan</label>
									<textarea class="form-control" v-model="form.isi_tanggapan" rows="5"></textarea>
								</div>

								<div class="form-group my-2">
									<button type="submit" class="btn btn-primary btn-sm">Simpan Tanggapan</button>
								</div>
							</form>

						</div>
					</div>

					<div class="card my-2" v-if="pengaduan.tanggapan !== null">
						<div class="card-header">
							<h5>Tanngapan</h5>
						</div>
						<div class="card-body">
							<div v-if="!updateTanggapan && !render">
								<p class="alert alert-primary">Laporan ini sudah ditanggapi</p>
								<div class="form-group my-3">
									<label for="tanggapan">Tanggapan</label>
									<textarea class="form-control" disabled v-model="pengaduan.tanggapan.isi_tanggapan" rows="5"></textarea>
								</div>

								<div class="my-3">
									<button class="btn btn-warning btn-sm" @click.prevent="updateModeToggle">Ubah Tanggapan</button>
								</div>

							</div>
							<div v-if="updateTanggapan && !render">
								<form @submit.prevent="tanggapi">
									<div class="form-group my-3">
										<label for="tanggapan">Tanggapan</label>
										<label for="tanggapan">Tanggapan</label>
										<textarea class="form-control" v-model="form.isi_tanggapan" rows="5" >
										</textarea>
									</div>

									<div class="my-3">
										<button type="submit" class="btn btn-warning btn-sm">Ubah Tanggapan</button>
									</div>
								</form>

								<div class="my-3">
									<button class="btn btn-secondary btn-sm" @click.prevent="updateModeToggle">Batal</button>
								</div>

							</div>

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
	import NotFound from '../NotFound.vue';

	export default {
		components: {
			NotFound
		},

		data() {
			return {
				pengaduan: {},
				render: true,
				updateTanggapan: false,
				form: {
					pengaduan_id: '',
					isi_tanggapan: '',
				},
				not_found: false,
			}
		},

		mounted() {
			this.loadPengaduan()

		},

		methods: {
			async loadPengaduan() {
				await axios.get('/api/admin/pengaduan/'+this.$route.params.slug)
				.then((res) => {
					this.pengaduan = res.data
					this.form.pengaduan_id = res.data.id
					if (res.data.tanggapan) {
						this.form.isi_tanggapan = res.data.tanggapan.isi_tanggapan 
					}
					this.render = false

				})
				.catch((err) => {
					if (err.response.status == 404) {
						this.not_found = true
					}
				})
			},

			tanggapi() {
				axios.post('/api/admin/tanggapan', this.form)
				.then(res => {
					this.loadPengaduan()
					this.notif(this.updateTanggapan ? 'Tanggapan diubah' : 'Tanggapan dikirimkan', 'success')

					if (this.updateTanggapan) {
						this.updateModeToggle()
					}
					// console.log(res)
				})
				.catch((err) => {
					console.log(err)
				})
			},

			updateModeToggle() {
				if (this.updateTanggapan) {
					this.updateTanggapan = false;
				} else {
					this.updateTanggapan = true;
				}
			},
		}
	}
</script>
