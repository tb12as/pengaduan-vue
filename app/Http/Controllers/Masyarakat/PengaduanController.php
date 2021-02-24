<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use App\Http\Requests\PengaduanStoreRequest;
use App\Http\Resources\Masyarakat\PengaduanResource;
use App\Models\Pengaduan;
use App\Service\GambarService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PengaduanController extends Controller
{
    public function index()
    {
        return Pengaduan::where('user_id', Auth::id())
        ->latest()
        ->get();
    }

    public function store(PengaduanStoreRequest $request)
    {
        $namaFile = GambarService::upload($request->file('foto') ?? null);
        Pengaduan::create([
            'user_id' => Auth::id(),
            'isi_laporan' => $request->isi_laporan,
            'foto' => $namaFile,
            'slug' => Str::slug("laporan-".Str::random(20)),
        ]);

        return response()->json(['message' => 'Laporan disimpan']);
    }

    public function show($slug)
    {
        return new PengaduanResource(Pengaduan::where([
            'slug' => $slug,
        ])
        ->with([
            'tanggapan' => fn($q) => $q->with('user'),
            'user'
        ])
        ->firstOrFail()
    );
    }

    public function update(PengaduanStoreRequest $request, $slug)
    {
        // return response()->json(['isi' => $request->all()], 500);
        $pengaduan = Pengaduan::where('slug', $slug)->firstOrFail();
        $namaFile = GambarService::updateUploaded($pengaduan->foto, $request->file('foto') ?? null);

        $pengaduan->update([
            'isi_laporan' => $request->isi_laporan,
            'foto' => $namaFile,
        ]);       
    }

    public function destroy(Pengaduan $pengaduan)
    {
        if ($pengaduan->foto) {
            \File::delete(public_path($pengaduan->foto));
        }

        $pengaduan->delete();

        return true;

    }

    public function search($query)
    {
        $data = Pengaduan::where('isi_laporan', 'like', "%$query%")
        ->orWhere('status', 'like', "%$query%")
        ->where('user_id', Auth::id())
        ->latest()
        ->get();

        // kalau data ad bnyak, mungkin bakal lemot

        return $data;
    }
}
