<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class CountryExport implements FromArray,WithEvents,WithCustomStartCell,ShouldAutoSize
{
    private $data;

    public function __construct($arrays) 
    {       $result=[];
        foreach($arrays as  $array){
         array_keys($result,$array[0]);
    
            foreach($array as $value){
                
               array_push($result,$value);
    
            }
           
            array_push($result,[""]);
               
           }
           $this->data=$result;
    }


    public function array():Array
    {
       return $this->data;
  
    }

    public function map($arrays): array
    {

    

        return [
            [
                $arrays->Caption,
                $arrays->codeCompte,
                $arrays->CodeCompteBancaire
            ],
            
        ];
        
    
    }   

    public function headings(): array
    {
        $list = DB::table('ELIT_ListeCompte')->get();
        $dates=[["debut"=>"2001-01-02","fin"=>"2022-01-02"]];
        $arrays=[$list,$dates];
        $result=[];
        
        foreach($arrays as  $array){
            array_push($result,[
                'Caption',
                'Code Compte',
                'Code Compte Bancaire'
            ]);
            foreach($array as $value){
                
              
    
            }
           
           
               
           }
        return $result;
    }
    public function startCell(): string
    {
        return 'B2';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class=>function(AfterSheet $event){

                $event->sheet->getStyle('B2:E300')->applyFromArray([
                    'font'=>[
                        'bold'=>false,
                       
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
               
                ]);
                $event->sheet->getStyle('B2:C2')->applyFromArray([
                    'font'=>[
                        'bold'=>true,
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    ],
                ]);
                
            }
        ];
    }
}