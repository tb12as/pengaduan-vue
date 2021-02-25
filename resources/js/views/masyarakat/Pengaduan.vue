<template>
	<div class="container">
		<h3>Sistem Pengaduan Masyarakat</h3>
		<p>Lorem, ipsum, dolor sit amet consectetur adipisicing elit. Magnam dolorem facilis necessitatibus voluptatum architecto officiis repellat, alias temporibus enim nulla, iure error molestias fuga incidunt, fugit hic reprehenderit sunt tenetur. Iusto animi rerum nulla alias iure quam vitae veniam, debitis.</p>

		<router-link to="/masyarakat/pengaduan/create" class="btn btn-primary btn-sm">Buat Laporan</router-link>

		<div class="row justify-content-between align-items-center my-4">
			<div class="col-md-8">
				<h4 class="">Pengaduan Anda</h4>
			</div>
			<div class="col-md-4">
				<input type="text" class="form-control" style="max-width: 300px" placeholder="Cari Pengaduan" @keyup="search" v-model="searchValue">

				<p class="small text-muted" v-if="waiting">Menunggu Anda selesai mengetik</p>
			</div>
			
		</div>
		<table class="table table-bordered">
			<thead class="thead-dark">
				<tr>
					<th>No</th>
					<th>Status</th>
					<th>Pengaduan</th>
					<th>Aksi</th>
				</tr>
			</thead>

			<tbody>
				<tr v-for="(value, index) in pengaduan" :key="index">
					<td>{{ index+1 }}</td>
					<td>{{ value.status }}</td>
					<td>{{ value.isi_laporan.substring(0, 50)+'...' }}</td>
					<td>
						<button v-if="value.status === '0'" class="btn btn-danger btn-sm" @click.prevent="deleteLaporan(value.id)">Delete</button>

						<router-link v-if="value.status === '0'" :to="{name: 'PengaduanUpdate', params: {slug: value.slug}}" class="btn btn-warning btn-sm">Edit</router-link>
						
						<router-link :to="{name: 'PengaduanDetail', params: {slug: value.slug}}" class="btn btn-success btn-sm">Detail</router-link>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				pengaduan: [],
				searchValue: '',
				searchOutput: '',
				waiting: false,
				timeout: null,
				searchMode: false,
			}
		},


		mounted() {
			this.loadData()
		},

		methods: {
			async loadData() {
				await axios.get('/api/masyarakat/pengaduan').then(response => {
					// console.log(response.data)
					this.pengaduan = response.data
				})
				.catch((err) => {
					console.log(err)
				})
			},

			deleteLaporan(pengaduan_id) {
				this.$swal.fire({
					title: 'Hapus laporan?',
					text: "Aksi ini tidak dapat dibatalkan!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Hapus',
					cancelButtonText: 'Batal',
				}).then((result) => {
					if (result.isConfirmed) {
						axios.delete('/api/masyarakat/pengaduan/'+pengaduan_id)
						.then(res => {
							this.loadData()
							this.notif('Pengaduan dihapus', 'info')
						})
						.catch(err => console.log(err))
					}
				})
			},

			search() {
				clearInterval(this.timeout)

				this.waiting = true;

				this.timeout = setTimeout(() => {

					this.searchOutput = this.searchValue;

					this.sendSearch()

					this.waiting = false;

				}, 1000) 
			},

			sendSearch() {
				if (this.searchOutput !== '') {
					axios.get(`/api/masyarakat/pengaduan/search/${this.searchOutput}`).then(res => {
						this.pengaduan = res.data;
						this.searchMode = true;

					})
					.catch(err => console.log(err));

				} else {
					this.searchMode = false;
					this.loadData()
				}
			}

		}
	}
</script>