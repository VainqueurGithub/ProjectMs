<?php

namespace App\Imports;

use App\Models\Repportage;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RepportageImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Repportage([
           'exercice_id'=> $row['exercice'],
           'compte_id'=> $row['compte'], 
           'montant'=> $row['montant'],
           'reported_in'=>$row['reported'],
           'type_mvt'=>$row['type']
        ]);
    }
}
