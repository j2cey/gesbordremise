<?php


namespace App\Traits\BordereauremiseFile;


use App\Bordereauremise;

trait ImportFileTrait
{
    public function import($nb_lines_to_process) {

        $pendingfiles_dir = config('app.bordereauremises_filesscanned');
        $raw_dir = config('app.RAW_FOLDER');
        $file_fullpath = $pendingfiles_dir.'/'.$this->name;

        $csvData = file_get_contents($raw_dir.'/'.$file_fullpath);
        $rows = array_map("str_getcsv", explode("\n", $csvData));

        $rows_processed = 0;
        for ($i = 1; $i < $this->nb_rows; $i++) {
            $row_current = $i + 1;
            $row = $rows[$i];

            $can_process_line = ($row_current > $this->row_last_processed);
            if ($can_process_line) {

                $this->nb_rows_processing += 1;
                $this->save();

                // récuration des paramètres de la ligne
                $row_parsed = $this->getParameters($row);

                if ($row_parsed[0]) {
                    // New Bordereauremise
                    Bordereauremise::create([
                        'date_remise' => date('Y-m-d',strtotime($row_parsed[1]['date_remise'])),
                        'numero_transaction' => $row_parsed[1]['numero_transaction'],
                        'localisation' => $row_parsed[1]['localisation'],
                        'changement_dernier_tarif' => $row_parsed[1]['changement_dernier_tarif'],
                        'classe_paiement' => $row_parsed[1]['classe_paiement'],
                        'mode_paiement' => $row_parsed[1]['mode_paiement'],
                        'montant_total' => $row_parsed[1]['montant_total'],
                    ]);
                    $this->nb_rows_success += 1;
                } else {
                    $this->nb_rows_failed += 1;
                }

                $this->nb_rows_processing -= 1;
                $this->nb_rows_processed += 1;

                $this->save();

                // MAJ du SmscampaingFile
                $this->row_last_processed = $row_current;
                $rows_processed++;
                $this->imported = ($this->nb_rows_processed === $this->nb_rows);
                if ($rows_processed === $nb_lines_to_process) {
                    break;
                }
            }
        }
        $this->nb_try += 1;
        // unmark as processing
        $this->import_processing = 0;
        $this->save();
    }

    private function getParameters($row) {
        $row_tab = $row; //explode(',', $row);
        $row_tab_fields = ['date_remise','numero_transaction','localisation','changement_dernier_tarif','classe_paiement','mode_paiement','montant_total'];
        $row_tab_values = [];
        $key = 0;
        foreach ($row_tab as $value) {
            $row_tab_values[$row_tab_fields[$key]] = trim($value);
            $key++;
        }

        return [true, $row_tab_values];
    }
}
