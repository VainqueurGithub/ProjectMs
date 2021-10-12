<?php

namespace App\Imports;

use App\Models\AyantDroit;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AyantDroitImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new AyantDroit([
            'Nom'=> $row['nom'],
            'Prenom'=> $row['prenom'],
            'Affilier'=> $row['affilier'],
            'Lien'=> $row['lien']
        ]);
    }
}
