<?php

namespace App\Exports;

use App\Models\EnrollStudent;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class EnrollStudentExport implements FromQuery, ShouldAutoSize, WithChunkReading, WithColumnFormatting, WithHeadings, WithMapping
{
    use Exportable;

    // public function __construct(
    //     public ?string $search = '',
    //     public ?string $course = '',
    //     public ?string $qualification = '',
    //     public ?string $gender = '',
    //     public ?string $dCategory = '',
    //     public ?int $campusId = null,
    //     public ?int $batchId = null,
    //     public ?int $courseId = null,
    // ) {}

    public function query()
    {
        // campus showing as batches
        // batches showing as campus in frontend
        // course is course
        return EnrollStudent::query()
            ->with(['student', 'registered_student', 'enroll.time_slot'])
            ->where('cancel_enrollment', 0)
            ->orderByDesc('id');
    }

    public function map($enroll_student): array
    {
        return [
            $enroll_student->student->full_name,
            $enroll_student->father_name,
            $enroll_student->gender,
            (string) $enroll_student->cnic_number,     // keep as text
            $enroll_student->student->email,
            (string) $enroll_student->contact_number,  // keep as text
            $enroll_student->date_of_birth,
            $enroll_student->registered_student->domicile_category,
            $enroll_student->domicile_district,
            $enroll_student->university_name,
            $enroll_student->registered_student->most_recent_institution,
            $enroll_student->registered_student->highest_qualification,
            $enroll_student->registered_student->preferred_study_center,
            $enroll_student->registered_student->preferred_time_slot,
            $enroll_student->registered_student->course_choice_1,
            $enroll_student->registered_student->course_choice_2,
            $enroll_student->registered_student->course_choice_3,
            $enroll_student->registered_student->course_choice_4,
            $enroll_student->registered_student->have_disability,
            $enroll_student->registered_student->monthly_household_income,
            $enroll_student->participated_previously,
            $enroll_student->registered_student->course_if_participated,
            $enroll_student->registered_student->phase_if_participated,
            $enroll_student->registered_student->center_if_participated,
            $enroll_student->registered_student->from_source,
            $enroll_student->enroll->campus->title ?? '',
            $enroll_student->enroll->batch->title ?? '',
            $enroll_student->enroll->course->title ?? '',
            $enroll_student->enroll->time_slot->title ?? 'N/A',
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
            // batch wise campus wise-> course
            'Enrolled in batch',
            'Enrolled in campus',
            'Enrolled in course',
            'Time Slot',
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
