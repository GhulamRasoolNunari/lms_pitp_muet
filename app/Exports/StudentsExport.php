<?php

namespace App\Exports;

use App\Models\StudentRegister;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class StudentsExport implements FromQuery, ShouldAutoSize, WithChunkReading, WithColumnFormatting, WithHeadings, WithMapping
{
    use Exportable;

    public function __construct(
        public ?string $search = '',
        public ?string $course = '',
        public ?string $qualification = '',
        public ?string $gender = '',
        public ?string $dCategory = '',
        public ?int $campusId = null,
        public ?int $batchId = null,
        public ?int $courseId = null,
    ) {}

    public function query()
    {
        return StudentRegister::query()
            // search
            ->when($this->search !== '', function ($q) {
                $term = '%'.$this->search.'%';
                $q->where(fn ($q) => $q->where('full_name', 'like', $term)
                    ->orWhere('email', 'like', $term)
                    ->orWhere('cnic_number', 'like', $term)
                    ->orWhere('contact_number', 'like', $term));
            })
            // course (string choices across 4 columns)
            ->when($this->course !== '', function ($q) {
                $c = $this->course;
                $q->where(fn ($q) => $q->where('course_choice_1', $c)
                    ->orWhere('course_choice_2', $c)
                    ->orWhere('course_choice_3', $c)
                    ->orWhere('course_choice_4', $c));
            })
            // id-based filters (use if your schema has these columns)
            ->when($this->courseId, fn ($q) => $q->where('course_id', $this->courseId))
            ->when($this->campusId, fn ($q) => $q->where('campus_id', $this->campusId))
            ->when($this->batchId, fn ($q) => $q->where('batch_id', $this->batchId))
            // others
            ->when($this->qualification !== '', fn ($q) => $q->where('highest_qualification', $this->qualification))
            ->when($this->gender !== '', fn ($q) => $q->where('gender', $this->gender))
            ->when($this->dCategory !== '', fn ($q) => $q->where('domicile_category', $this->dCategory))
            ->orderByDesc('id');
    }

    public function map($student): array
    {
        return [
            $student->full_name,
            $student->father_name,
            $student->gender,
            (string) $student->cnic_number,     // keep as text
            $student->email,
            (string) $student->contact_number,  // keep as text
            $student->date_of_birth,
            $student->domicile_category,
            $student->domicile_district,
            $student->university_name,
            $student->most_recent_institution,
            $student->highest_qualification,
            $student->preferred_study_center,
            $student->preferred_time_slot,
            $student->course_choice_1,
            $student->course_choice_2,
            $student->course_choice_3,
            $student->course_choice_4,
            $student->have_disability,
            $student->monthly_household_income,
            $student->participated_previously,
            $student->course_if_participated,
            $student->phase_if_participated,
            $student->center_if_participated,
            $student->from_source,
        ];
    }

    public function headings(): array
    {
        return [
            'Full Name',
            'Father Name',
            'Gender',
            'CNIC Number',
            'Email',
            'Contact Number',
            'Date of Birth',
            'Domicile Category',
            'Domicile District',
            'University Name',
            'Most Recent Institution',
            'Highest Qualification',
            'Preferred Study Center',
            'Preferred Time Slot',
            'Course Choice 1',
            'Course Choice 2',
            'Course Choice 3',
            'Course Choice 4',
            'Have Disability',
            'Monthly Household Income',
            'Participated Previously',
            'Course If Participated',
            'Phase If Participated',
            'Center If Participated',
            'From Source',
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    // Prevent Excel from stripping leading zeros for CNIC/phone
    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_TEXT, // CNIC
            'F' => NumberFormat::FORMAT_TEXT, // Contact
        ];
    }
}
