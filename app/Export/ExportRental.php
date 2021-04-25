<?php

namespace App\Export;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
    $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);

});

class ExportRental implements FromView, WithEvents, ShouldAutoSize, WithColumnFormatting
{
    protected $data;
    protected $attr;

    function __construct($data)
    {
        $this->data = $data->data;
        $this->count = count($data->data);
        $this->attr = $data->attr;
    }

    public function view(): View
    {
        return view('rental._export', [
            'data' => $this->data,
            'attr' => $this->attr,
        ]);
    }

    public function registerEvents() : array
    {
        return [
            AfterSheet::class => function (AfterSheet $event){
                $bottom = (int) $this->count + 5;
                $event->sheet->styleCells(
                    'A1:J3',
                    [
                        'font' => [
                            'name' => 'Calibri',
                            'size' => 12,
                            'bold' => true,
                        ],
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        ],
                    ]
                );

                $event->sheet->styleCells(
                    'A4:J4',
                    [
                        'font' => [
                            'name' => 'Calibri',
                            'size' => 12,
                            'bold' => true,
                        ],
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        ],
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['rgb' => '0a0a0a'],
                            ],
                        ],
                    ]
                );

                $event->sheet->getDelegate()->getStyle('A4:F5')->getAlignment()->setWrapText(true);
                $event->sheet->getDelegate()->getStyle('L5:W5')->getAlignment()->setWrapText(true);

                $event->sheet->styleCells(
                    'A5:J5',
                    [
                        'font' => [
                            'name' => 'Calibri',
                            'size' => 8,
                            'italic' => true,
                        ],
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        ],
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'color' => ['argb' => 'c3c8ef']
                        ]
                    ]
                );

                $event->sheet->styleCells(
                    'A6:J'.$bottom,
                    [
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['rgb' => '0a0a0a'],
                            ],
                        ],
                        'alignment' => [
                            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        ],
                    ]
                );

                $event->sheet->styleCells(
                    'A6:J' .$bottom,
                    [
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        ],
                        'font' => [
                            'name' => 'Calibri',
                            'size' => 12,
                            // 'bold' => true,
                        ],
                    ]
                );

                $event->sheet->styleCells(
                    'G6:I' . $bottom,
                    [
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                        ],
                    ]
                );

                //col A
                $event->sheet->getColumnDimension('A')->setAutoSize(false);
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(5);

                //col B
                $cols = range('B', 'C');
                foreach($cols as $col) :
                    $event->sheet->getColumnDimension($col)->setAutoSize(false);
                    $event->sheet->getDelegate()->getColumnDimension($col)->setWidth(15);
                endforeach;

                $event->sheet->getColumnDimension('D')->setAutoSize(false);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(35);

                $cols = range('E', 'F');
                foreach($cols as $col) :
                    $event->sheet->getColumnDimension($col)->setAutoSize(false);
                    $event->sheet->getDelegate()->getColumnDimension($col)->setWidth(15);
                endforeach;

                $cols = range('G', 'J');
                foreach($cols as $col) :
                    $event->sheet->getColumnDimension($col)->setAutoSize(false);
                    $event->sheet->getDelegate()->getColumnDimension($col)->setWidth(20);
                endforeach;
            }
        ];
    }

    public function columnFormats(): array
    {
        return [
            // 'B' => NumberFormat::FORMAT_NUMBER,
        ];
    }
}
