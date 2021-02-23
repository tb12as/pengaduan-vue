<template>
	<div>
		<div v-if="level == 'admin' || level == 'petugas'">
			<PengaduanIndex></PengaduanIndex>
		</div>
		<div v-if="level == 'masyarakat'">
			<PengaduanMasyarakat></PengaduanMasyarakat>
		</div>
	</div>
</template>

<script>
	import PengaduanIndex from './admin/PengaduanIndex.vue'
	import PengaduanMasyarakat from './masyarakat/Pengaduan.vue'

	export default {
		components:{
			PengaduanIndex,
			PengaduanMasyarakat
		},

		data() {
			return {
				level: '',
			}
		},


		mounted() {
			axios.get('/api/user/role/').then((response) => {
				// console.log()
				this.level = response.data[0]
			})
			.catch((err) => {
				console.log(err)
			})
		}
	}
</script>