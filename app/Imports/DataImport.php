<?php

namespace App\Imports;

use App\Models\Data;
use Maatwebsite\Excel\Concerns\ToModel;

class DataImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Data([
            'family_number_id' => $row[0],
            'name' => $row[1],
            'district' => $row[2],
            'income' => $row[3],
            'spending' => $row[4],
            'job' => $row[5],
            'disability_type' => $row[6],
            'residence_condition' => $row[7],
            'electricity_capacity' => $row[8]
        ]);
    }
}
