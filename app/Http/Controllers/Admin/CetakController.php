<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CetakController extends Controller
{
	public function cetakPdf($id)
	{
		$data = Pengaduan::with(['tanggapan' => fn($query) => $query->with('user'), 'user'])
		->findOrFail($id);

		$file = PDF::loadview('admin.cetak_pengaduan', ['data' => $data]);
		$file->setPaper('a4');

		$name = strtolower($data->user->name).$data->id;

		$fileName = "laporan_$name.pdf";

		return $file->download($fileName, [
			'Content-Type' => 'application/pdf', 
            'Content-Description' => 'File Transfer',
            'Content-Disposition' => "attachment; filename={$fileName}",
            'filename'=> $fileName
		]);
	}
}
