<?php

namespace App\Http\Resources\Masyarakat;

use Illuminate\Http\Resources\Json\JsonResource;

class PengaduanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'pengaduan_id' => $this->id,
            'isi_laporan' => $this->isi_laporan,
            'slug' => $this->slug,
            'foto' => $this->foto,
            'status' => $this->status,
            'user' => [
                'name' => $this->user->name,
                'nik' => $this->user->nik,
                'telp' => $this->user->telp,
            ],
            'tanggapan' => $this->tanggapan === null ? null :  [
                'isi_tanggapan' => $this->tanggapan->isi_tanggapan,
                'created_at' => date('d F Y | H:i:s', strtotime($this->tanggapan->created_at)),
                'user' => [
                    'name' => $this->tanggapan->user->name,
                ],
            ],
        ];
    }
}
