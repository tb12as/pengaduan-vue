<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\Tanggapan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TanggapanController extends Controller
{
    public function store(Request $request)
    {
    	$pengaduan = Pengaduan::find($request->pengaduan_id);

    	$data = $pengaduan->tanggapan()->updateOrCreate(['pengaduan_id' => $request->pengaduan_id], [
    		'user_id' => Auth::id(),
    		'isi_tanggapan' => $request->isi_tanggapan,
    	]);

    	$pengaduan->status = 'selesai';
    	$pengaduan->save();

    	return $data;
    }
}
