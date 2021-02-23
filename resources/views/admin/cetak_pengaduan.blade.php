<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Laporan dari {{ $data->user->name }}</title>

	<style>
		body {
			font-family: 'Nunito', sans-serif;
		}
		.w-50 {
			width: 50%;
		}
		.w-75 {
			width: 75%;
		}
		.rounded {
			border-radius: 5px;
		}
		.table {
			border-collapse: collapse;
			padding: 10px;
		}
		.table td {
			padding: 12px;
			font-size: 13px;
		}

	</style>

</head>
<body>

	<div class="container">
		<center>
			<h3>Sistem Pengaduan Masyarakat</h3>
			<p>Laporan ini diterima pada tanggal {{ date('d-m-Y, H:i:s', strtotime($data->created_at)) }}</p>
		</center>
		<div class="header">
			<table class="table w-75" border="0">
				<tr>
					<td>
						<h4>Isi Laporan</h4>
						<p style="opacity: 0.7; font-size: 13px;">{{ $data->isi_laporan }}</p>
					</td>
				</tr>

				@if ($data->foto)
				<tr>
					<td>
						<img src="{{ public_path() . $data->foto }}" class="rounded w-50" alt="">
					</td>
				</tr>
				@endif						
				
			</table>
			<hr>
		</div>

		<h4>Detail Pelapor</h4>
		<table class="table w-50" border="1">
			<tr>
				<td><strong>NIK</strong></td>
				<td>{{ $data->user->nik }}</td>
			</tr>
			<tr>
				<td><strong>Nama</strong></td>
				<td>{{ $data->user->name }}</td>
			</tr>
			<tr>
				<td><strong>Username</strong></td>
				<td>{{ $data->user->username }}</td>
			</tr>
			<tr>
				<td><strong>Email</strong></td>
				<td>{{ $data->user->email }}</td>
			</tr>
			<tr>
				<td><strong>Telpon</strong></td>
				<td>{{ $data->user->telp }}</td>
			</tr>
		</table>


		@if ($data->tanggapan)
		<hr>
		<h4>Tanggapan</h4>

		<p style="opacity: 0.7; font-size: 13px">{{ $data->tanggapan->isi_tanggapan }}</p>

		<h4>Detail Pemberi Tanggapan</h4>
		<table class="table w-50" border="1">
			<tr>
				<td><strong>Nama</strong></td>
				<td>{{ $data->tanggapan->user->name }}</td>
			</tr>
			<tr>
				<td><strong>Username</strong></td>
				<td>{{ $data->tanggapan->user->username }}</td>
			</tr>
			<tr>
				<td><strong>Email</strong></td>
				<td>{{ $data->tanggapan->user->email }}</td>
			</tr>
		</table>

		@endif

	</div>
</body>
</html> 

