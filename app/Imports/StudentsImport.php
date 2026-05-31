<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;

class StudentsImport implements ToModel, \Maatwebsite\Excel\Concerns\WithHeadingRow
{
    public function model(array $row)
    {
        return new Student([
            'nisn'     => $row['nisn'],
            'name'     => $row['name'],
            'password' => $row['nisn'],
            'status'   => $row['status'] ?? 'DITANGGUHKAN',
        ]);
    }
}
