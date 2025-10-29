<?php
namespace App\Imports;

use App\Models\StudentRegister;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Validation\ValidationException;

class StudentsImport implements ToModel, WithHeadingRow
{
    private $requiredHeaders = [
        'full_name',
        'father_name',
        'gender',
        'cnic_number',
        'email',
        'contact_number',
        'date_of_birth',
        'domicile_district',
        'university_name',
    ];

    public function headingRow(): int
    {
        return 1;
    }

    public function model(array $row)
    {
        // Validate required headers on first row only
        static $validated = false;
        if (!$validated) {
            $missing = array_diff($this->requiredHeaders, array_keys($row));

            if (count($missing)) {
                throw ValidationException::withMessages([
                    'file' => ['Missing required columns: ' . implode(', ', $missing)],
                ]);
            }

            $validated = true;
        }

        // Proceed to import
        return new StudentRegister([
            'full_name'             => $row['full_name'],
            'father_name'           => $row['father_name'],
            'gender'                => $row['gender'],
            'cnic_number'           => $row['cnic_number'],
            'email'                 => $row['email'],
            'contact_number'        => $row['contact_number'],
            'date_of_birth'         => $row['date_of_birth'],
            'domicile_district'     => $row['domicile_district'],
            'university_name'       => $row['university_name'],
        ]);
    }
}
