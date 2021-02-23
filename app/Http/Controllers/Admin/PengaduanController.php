<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    public function index()
    {
    	return Pengaduan::with('user')->get();
    }

    public function show($slug)
    {
    	return Pengaduan::where('slug', $slug)
    		->with([
    			'user', 'tanggapan'
    		])
    		->firstOrFail();
    }

    public function isValid(Pengaduan $pengaduan)
    {
        $pengaduan->status = 'proses';
        $pengaduan->save();

        return true;
    }

    public function destroy(Pengaduan $pengaduan)
    {
        $pengaduan->delete();
        return true;
    }
}
