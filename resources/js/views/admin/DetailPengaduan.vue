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
					<div class="card my-2" v-if="!render && !pengaduan.tanggapan && pengaduan.status == 'proses'">
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

					<div class="card my-2" v-if="!render && !pengaduan.tanggapan && pengaduan.status == '0'">
						<div class="card-header">
							<h5>Pengaduan belum melalui proses validasi. </h5>
						</div>
						<div class="card-body">
							<p class="alert alert-warning">Pastikan laporan sudah valid sebelum ditanggapi</p>
							<button class="m-1 btn btn-info btn-sm" @click.prevent="isValid(pengaduan.id)">Valid</button>
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

							<a v-if="level == 'admin'" class="btn btn-outline-primary btn-sm" :href="'/laporan/pdf/download/'+pengaduan.slug" @click.prevent="downloadPdf(form.pengaduan_id)">Cetak Laporan</a>


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
				level: '',
			}
		},

		mounted() {
			this.loadPengaduan()
			this.getUserRole()
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

			downloadPdf(id) {
				window.open('/api/admin/cetak/'+id, '_blank')
			},

			async getUserRole() {
				await axios.get('/api/user/role/').then((response) => {
					// console.log()
					this.level = response.data[0]
				})
				.catch((err) => {
					console.log(err)
				})
			},

			isValid(pengaduan_id) {
				this.$swal.fire({
					title: 'Apakah ini Valid?',
					text: "Pastikan laporan ini valid sebelum ditanggapi!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Ya',
					cancelButtonText: 'Tidak',
				}).then((result) => {
					if (result.isConfirmed) {
						// post to axios
						axios.post('/api/admin/valid/'+pengaduan_id)
						.then(res => {
							if (this.searchMode) {
								this.sendSearch()
							} else {
								this.loadPengaduan()
							}
							this.notif('Pengaduan dipindahkan ke bagian proses', 'success')
						})
						.catch(err => console.log(err))
					}
				})
			},

		}
	}
</script>
