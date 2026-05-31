<?php
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Facades\Excel;

class TemplateExport implements FromArray, WithHeadings
{
    public function headings(): array
    {
        return ['nisn', 'name', 'status'];
    }

    public function array(): array
    {
        return [
            ['12345678', 'Budi Santoso', 'LULUS'],
            ['87654321', 'Andi Pratama', 'DITANGGUHKAN'],
        ];
    }
}

Excel::store(new TemplateExport, 'template-siswa.xls', 'public', \Maatwebsite\Excel\Excel::XLS);
echo "File generated at storage/app/public/template-siswa.xls\n";
