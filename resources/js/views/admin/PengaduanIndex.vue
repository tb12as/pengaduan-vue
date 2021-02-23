<template>
	<div class="container">
		<h2>Pengaduan</h2>
		<div class="row">
			<div class="col-lg-3 col-md-6 col-sm-6">
				<div class="card m-2 my-4 bg-danger text-light">
					<div class="card-header">
						Belum di Validasi
					</div>
					<div class="card-body d-flex justify-content-start align-items-center">
						<h1 class="display-4 mr-2">{{ pengaduanWhereStatus('0').length }}</h1>
						<p>Pengaduan Baru</p>
					</div>
				</div>
			</div>

			<div class="col-lg-3 col-md-6 col-sm-6">
				<div class="card m-2 my-4 bg-warning">
					<div class="card-header">
						Pengaduan dalam Proses
					</div>
					<div class="card-body d-flex justify-content-start align-items-center">
						<h1 class="display-4 mr-2">{{ pengaduanWhereStatus('proses').length }}</h1>
						<p>Yang harus di proses</p>
					</div>
				</div>
			</div>

			<div class="col-lg-3 col-md-6 col-sm-6">
				<div class="card m-2 my-4 bg-success text-light">
					<div class="card-header">
						Pengaduan selesai
					</div>
					<div class="card-body d-flex justify-content-start align-items-center">
						<h1 class="display-4 mr-2">{{ pengaduanWhereStatus('selesai').length }}</h1>
						<p>Sudah selesai</p>
					</div>
				</div>
			</div>

			<div class="col-lg-3 col-md-6 col-sm-6">
				<div class="card m-2 my-4 bg-primary text-light">
					<div class="card-header">
						Total Pengaduan
					</div>
					<div class="card-body d-flex justify-content-start align-items-center">
						<h1 class="display-4 mr-2">{{ pengaduan.length }}</h1>
						<p>Pengaduan</p>
					</div>
				</div>
			</div>

		</div>

		<h4 class="m-2">Pengaduan Baru</h4>
		<hr>
		<div class="row">
			<div class="col-lg-4 col-md-6 col-sm-6 m-2" v-for="(val, index) in pengaduanWhereStatus('0')" :key="index">
				<div class="card">
					<div class="card-header">
						<h5>Appaan</h5>
					</div>
					<div class="card-body">
						<table class="table-borderless">
							<tr>
								<td>Nama Pelapor</td>
								<td>:</td>
								<td>{{ val.user.name }}</td>
							</tr>
							<tr>
								<td>Status</td>
								<td>:</td>
								<td>{{ val.status }}</td>
							</tr>
						</table>
					</div>
					<div class="card-footer">
						<!-- <button class="m-1 btn btn-danger btn-sm" @click="deleteLaporan(val.id)">Hapus</button> -->
						<button class="m-1 btn btn-info btn-sm" @click.prevent="isValid(val.id)">Valid</button>
						<router-link :to="{name: 'DetailPengaduan', params: {slug: val.slug}}" class="m-1 btn btn-success btn-sm">Detail</router-link>
					</div>
				</div>
			</div>
			<div v-if="pengaduanWhereStatus('0').length < 1" class="col-md-12 col-sm-11">
				<p class="alert alert-primary">Belum ada laporan baru</p>
			</div>
		</div>



		<h4 class="m-2">Pengaduan dalam Proses</h4>
		<hr>
		<div class="row">
			<div class="col-md-4 m-2" v-for="(val, index) in pengaduanWhereStatus('proses')" :key="index">
				<div class="card">
					<div class="card-header">
						<h5>Appaan</h5>
					</div>
					<div class="card-body">
						<table class="table-borderless">
							<tr>
								<td>Nama Pelapor</td>
								<td>:</td>
								<td>{{ val.user.name }}</td>
							</tr>
							<tr>
								<td>Status</td>
								<td>:</td>
								<td>{{ val.status }}</td>
							</tr>
						</table>
					</div>
					<div class="card-footer">
						<router-link :to="{name: 'DetailPengaduan', params: {slug: val.slug}}" class="m-1 btn btn-success btn-sm">Detail</router-link>
					</div>
				</div>
			</div>
			<div v-if="pengaduanWhereStatus('proses').length < 1" class="col-md-12 col-sm-11">
				<p class="alert alert-primary">Belum ada laporan yang harus diproses</p>
			</div>
		</div>


		
		<h4 class="m-2">Pengaduan Selesai</h4>
		<hr>
		<div class="row">
			<div class="col-md-4 m-2" v-for="(val, index) in pengaduanWhereStatus('selesai')" :key="index">
				<div class="card">
					<div class="card-header">
						<h5>Appaan</h5>
					</div>
					<div class="card-body">
						<table class="table-borderless">
							<tr>
								<td>Nama Pelapor</td>
								<td>:</td>
								<td>{{ val.user.name }}</td>
							</tr>
							<tr>
								<td>Status</td>
								<td>:</td>
								<td>{{ val.status }}</td>
							</tr>
						</table>
					</div>
					<div class="card-footer">
						<!-- <button class="m-1 btn btn-danger btn-sm" @click="deleteLaporan(val.id)">Hapus</button> -->
						<router-link :to="{name: 'DetailPengaduan', params: {slug: val.slug}}" class="m-1 btn btn-success btn-sm">Detail</router-link>
					</div>
				</div>
			</div>
			<div v-if="pengaduanWhereStatus('selesai').length < 1" class="col-md-12 col-sm-11">
				<p class="alert alert-primary">Belum ada laporan selesai</p>
			</div>
		</div>


	</div>
</template>
<script>
	export default {
		data() {
			return {
				pengaduan: [],
				users: '',
			}
		},

		mounted() {
			this.loadPengaduan()
			this.countUser()
		},

		computed: {
			pengaduanWhereStatus() {
				return status => this.pengaduan.filter(val => val.status == `${status}`);
				// https://stackoverflow.com/questions/40522634/can-i-pass-parameters-in-computed-properties-in-vue-js

			},
		},

		methods: {
			loadPengaduan() {
				axios.get('/api/admin/pengaduan').then((res) => this.pengaduan = res.data)
				.catch((err) => console.log(err));
			},

			countUser() {
				axios.get('/api/admin/user-count').then(res => this.users = res.data)
				.catch((err) => console.log(err))
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
							this.loadPengaduan()
							this.notif('Pengaduan dipindahkan ke bagian proses', 'success')
						})
						.catch(err => console.log(err))
					}
				})
			},

		}
	}
</script>