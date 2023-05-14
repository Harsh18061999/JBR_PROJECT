<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Company;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use Auth;

class ReportExport implements FromCollection,WithHeadings,WithStyles,WithTitle,WithColumnWidths
{

    protected $data;
    function __construct($data) {
        $this->data = $data;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect($this->data);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 20, 
            'C' => 20,
            'D' => 20,
            'E' => 20,
            'F' => 20,  
            'G' => 20,
            'H' => 20,
            'I' => 20,
            'J' => 20,  
            'K' => 20,
            'L' => 20, 
            'M' => 20,
            'N' => 20,
            'O' => 20,
            'P' => 20,
            'Q' => 20,
            'R' => 20,
            'S' => 20,
            'T' => 20,
            'U' => 20,
            'V' => 20,
            'W' => 20,
            'X' => 20,
            'Y' => 20,
            'Z' => 20,
            'AA' => 20,
            'AB' => 20,
            'AC' => 20,
            'AD' => 20,
            'AE' => 20,
            'AF' => 20,
            'AG' => 20,
            'AH' => 20,
            'AI' => 20,
        ];
    }

    public function headings():array{
        return [
            "DATE",
            "EMPLOYEE",
            "CLIENT",
            "SUPERVISOR",
            "START TIME	",
            "BREAK TIME	",
            "END TIME",
            "OVER TIME",
            "TOTAL",
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true,'color' => array('rgb' => '#000000')]],
        ];
    }

    public function title(): string
    {
        return 'Weekly Report';
    }
}
