<template>
	<div class="container">
		<h1>Sistem Pengaduan Masyarakt</h1>
		<p>Lorem, ipsum, dolor sit amet consectetur adipisicing elit. Magnam dolorem facilis necessitatibus voluptatum architecto officiis repellat, alias temporibus enim nulla, iure error molestias fuga incidunt, fugit hic reprehenderit sunt tenetur. Iusto animi rerum nulla alias iure quam vitae veniam, debitis.</p>

		<router-link to="/masyarakat/pengaduan/create" class="btn btn-primary btn-sm">Buat Laporan</router-link>

		<h2>Pengaduan Anda</h2>
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
						<button class="btn btn-danger btn-sm" @click.prevent="deleteLaporan(value.id)">Delete</button>

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
				pengaduan: []
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
						})
						.catch(err => console.log(err))
					}
				})
			}

		}
	}
</script>