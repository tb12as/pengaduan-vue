<?php 

namespace App\Service;

/**
 * return string
 */
class GambarService
{
	public static function upload($file)
	{
		return GambarService::uploadHandle($file);
	}

	public static function updateUploaded($oldFile, $fileNew)
	{
		if ($fileNew) {
			if ($oldFile) {	 
				\File::delete(public_path($oldFile));
			}
			return GambarService::uploadHandle($fileNew);
			// remember that this column is nullable
		}

		return $oldFile;
	}

	private static function uploadHandle($file)
	{
		$namaFile = null;
		if ($file) {
			$ext = $file->getClientOriginalExtension();
			$fileName = md5($file->getClientOriginalName().date('dmyhis')).".$ext";

			$file->move(public_path()."/laporan/", "$fileName");
			$namaFile = "/laporan/$fileName";
		} else {
			$namaFile = null;
		}

		return $namaFile;
	}
}

