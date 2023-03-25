<?php

namespace App\Exports;

use App\Models\Income;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class IncomesExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, Responsable
{
    
    use Exportable;
    
    protected $minDate;
    protected $maxDate;

    /** 
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Income::all('id','tanggal','nama','jumlah','deskripsi');
    }
    
    /**
    * It's required to define the fileName within
    * the export class when making use of Responsable.
    */
    private $fileName = 'RekapPemasukanSriAyu.xlsx';
    
    /**
    * Writer Type
    */
    private $writerType = Excel::XLSX;
    
    /**
    * Headings
    */
    public function headings(): array
    {
        return [
            'NO',
            'TANGGAL',
            'NAMA',
            'JUMLAH',
            'DESKRIPSI',
        ];
    }

    /**
    * Optional styles
    */
    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
}
