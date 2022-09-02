<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class CountryExport implements FromArray,WithEvents,WithCustomStartCell,ShouldAutoSize
{
    private $data;
    private $sizeA;
    private $sizeB;
    private $Length;

    public function __construct($arrays,$sizeA,$sizeB,$max) 
    {      
           $this->data=$arrays;
           $this->sizeA=$sizeA;
           $this->Length=$max;
           $this->sizeB=$sizeB;
    }


    public function array():Array
    {
        
       return $this->data;
  
    } 

    public function startCell(): string
    {
        return 'B2';
    }

    public function registerEvents(): array
    {
        return [
            
            AfterSheet::class=>function(AfterSheet $event){
                $this->Length+=8;
                $event->sheet->getStyle('B2:N'.$this->Length)->applyFromArray([
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
               
                ]);
                $event->sheet->getStyle('B2:N2')->applyFromArray([
                    'font'=>[
                        'bold'=>true,
                    ],
                ]);

                $event->sheet->getStyle('D5:D6')->applyFromArray([
                    'font'=>[
                        'bold'=>true,
                        
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'rotation' => 90,
                        'startColor' => [
                            'rgb' => '66ff00',
                        ],
              
                    ]
                ]);

                
     

                $event->sheet->getStyle('I5:I6')->applyFromArray([
                    'font'=>[
                        'bold'=>true,
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'rotation' => 90,
                        'startColor' => [
                            'rgb' => '5454df',
                        ],
              
                    ]
                ]);

   

                
                $event->sheet->getStyle('B8:E8')->applyFromArray([
                    'font'=>[
                        'bold'=>true,
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'rotation' => 90,
                        'startColor' => [
                            'rgb' => '008cff',
                        ],
              
                    ],
                ]);

                $event->sheet->getStyle('G8:J8')->applyFromArray([
                    'font'=>[
                        'bold'=>true,
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'rotation' => 90,
                        'startColor' => [
                            'rgb' => '008cff',
                        ],
              
                    ],
                ]);

                $event->sheet->getStyle('C2:E3')->applyFromArray([
                    'font'=>[
                        'bold'=>true,
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'rotation' => 90,
                        'startColor' => [
                            'rgb' => 'ffff00',
                        ],
              
                    ],
                ]);
                
                $this->sizeA+=8;
                $event->sheet->getStyle('B8:E'.$this->sizeA)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                            'color' => ['argb' => '00000000'],
                        ],
                    ]
                ]);

                $this->sizeB+=8;
                $event->sheet->getStyle('G8:J'.$this->sizeB)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                            'color' => ['argb' => '00000000'],
                        ],
                    ]
                ]);


        
                
            }
        ];
    }
}