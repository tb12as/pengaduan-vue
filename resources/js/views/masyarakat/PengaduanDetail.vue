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
								<label for="">Isi Laporan</label>
								<textarea class="form-control" rows="5" disabled v-model="pengaduan.isi_laporan"></textarea>
							</div>


							<div v-if="pengaduan.foto" class="my-3">
								<img class="w-75" :src="pengaduan.foto" alt="">
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-6" v-if="pengaduan.tanggapan && !render">
					<div class="card">
						<div class="card-header">
							<h5>Tanggapan</h5>
						</div>
						<div class="card-body">
							<div class="my-3">
								<label>Tanggapan</label>
								<textarea  rows="5" disabled="" class="form-control">{{ pengaduan.tanggapan.isi_tanggapan }} </textarea>
							</div>

							<p class="my-1">
								Ditanggapi oleh {{ pengaduan.tanggapan.user.name }} pada {{ pengaduan.tanggapan.created_at }}
							</p>
						</div>
					</div>
				</div>


				<div class="col-md-6" v-if="!pengaduan.tanggapan && !render">
					<p class="alert alert-warning">Belum ada tanggapan</p>
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
				pengaduan: {},
				render: true,
				not_found: false,
			}
		},

		mounted() {
			this.loadPengaduan()

		},

		methods: {
			async loadPengaduan() {
				await axios.get('/api/masyarakat/pengaduan/'+this.$route.params.slug)
				.then((res) => {
					this.pengaduan = res.data.data
					this.render = false

				})
				.catch((err) => {
					console.log(err)
					if (err.response.status == 404) {
						this.not_found = true
					}
				})
			},

		}
	}
</script>
