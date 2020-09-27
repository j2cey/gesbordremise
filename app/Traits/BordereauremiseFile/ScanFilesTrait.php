<?php


namespace App\Traits\BordereauremiseFile;


use App\BordereauremiseFile;
use Illuminate\Support\Facades\File;

trait ScanFilesTrait
{
    public function scanFiles() {

        $files_dir = config('app.bordereauremises_files');
        $raw_dir = config('app.RAW_FOLDER');
        $path = $raw_dir.'/'.$files_dir;

        $files = File::allFiles($path);
        $files_count = count($files);

        $file_max_line = 500;

        foreach ($files as $file) {

            $file_arr = file($file->getPathname());

            $parts = (array_chunk($file_arr, $file_max_line));
            $parts_count = count($parts);

            if ($parts_count > 0) {

                $i = 1;
                $nb_rows_all = 0;
                $scannedfiles_dir = config('app.bordereauremises_filesscanned');
                foreach ($parts as $line) {
                    $filename = str_replace(['-', ' ', ':'], "", gmdate('Y-m-d h:i:s')) . '_' . $i . '.csv';
                    $filename_full = $raw_dir.'/'.$scannedfiles_dir . '/' . $filename;

                    file_put_contents($filename_full, $line);
                    $i++;

                    $nb_rows_curr = intval(exec("wc -l '" . $filename_full . "'"));
                    BordereauremiseFile::create([
                        'name' => $filename,
                        'nb_rows' => $nb_rows_curr,
                        'report' => json_encode([]),
                    ]);

                    $nb_rows_all += $nb_rows_curr;
                }
            }
            //unlink($file->getPathname());
            File::delete($file->getPathname());
        }

        return $files_count;
    }
}
