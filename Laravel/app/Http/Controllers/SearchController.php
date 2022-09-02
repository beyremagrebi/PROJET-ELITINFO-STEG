<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\CountryExport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use function Symfony\Component\String\b;

class SearchController extends Controller
{
    
 
    public function export($debut,$fin,$selected,$codeb)
    {
        
        $compteA = DB::table('ELIT_LISTE_EcrituresNon_Rapproches')
        ->select('Code Autorisation as code','Montant','DateOperation')
        ->where('codeCompte',$selected)->whereBetween('DateOperation',[$debut,$fin])->orderby('DateOperation','DESC')->get()->toArray();

        $compteB=DB::table('ELIT_LISTE_EcrituresB_NonRapproches')
            ->select('Code Autorisation as code','dateOperation','montant')
            ->where('code',$codeb)->whereBetween('dateOperation',[$debut,$fin])->orderby('dateOperation','DESC')->get()->toArray();
            $start = strpos($codeb, '-') ;
            $codeCA=substr($codeb,0,$start);
            $codeCB=substr($codeb,$start+1);
            
            foreach($compteA as $item){
                $count=0;
                $index=strpos($item->DateOperation, ' ') ;
                $item->DateOperation=substr($item->DateOperation,0,$index);
                foreach($compteA as $item2){
                    if($item2->code==$item->code){
                        $count++;
                        
                        $item->analyse="Il existe ".$count." fois dans ".$codeCA;
                    }
                  
                }
            
                
                
            }

            foreach($compteB as $item){
                $count=0;
                $index=strpos($item->dateOperation, ' ') ;
                $item->dateOperation=substr($item->dateOperation,0,$index);
                
                foreach($compteB as $item2){
                    if($item2->code==$item->code){
                        $count++;
                        $item->analyse="Il existe ".$count." fois dans ".$codeCB;
                    }
                  
                }
            
                
                
            }

     
      $result=[];
      $date=[['','Date Debut','Date Fin','Rapprochement de :'],['',$debut,$fin,$codeb]];
      

        
        for($i=0;$i<count($date);$i++){
            array_push($result,$date[$i]);
        }
       $result[$i]=[""];
       $i++;
       $result[$i]=[['','','Non Rapproché '.$codeCA,'','','','','Non Rapproché '.$codeCB],['','',count($compteA),'','','','',count($compteB)]];
       $i++;
       $result[$i]=[""];
       $i++;

       $length=0;
   
        $result[$i]=['Code Autorisation','Montant','Date Operation','Analyse','','Code Autorisation','Montant','Date Operation','Analyse'];
        if (count($compteA) >= count($compteB)){ $length =count($compteA); }else $length =count($compteB) ;

        for($i=0; $i<$length;$i++){
            
        
        if(array_key_exists($i,$compteA) and array_key_exists($i,$compteB))
            array_push($result,[$compteA[$i]->code,$compteA[$i]->Montant,$compteA[$i]->DateOperation,$compteA[$i]->analyse,'',$compteB[$i]->code,$compteB[$i]->montant,$compteB[$i]->dateOperation,$compteB[$i]->analyse]);
        if(!array_key_exists($i,$compteA)and array_key_exists($i,$compteB))
            array_push($result,['','','','','',$compteB[$i]->code,$compteB[$i]->montant,$compteB[$i]->dateOperation,$compteB[$i]->analyse]);
        
        if(array_key_exists($i,$compteA)and !array_key_exists($i,$compteB))
            array_push($result,[$compteA[$i]->code,$compteA[$i]->Montant,$compteA[$i]->DateOperation,$compteA[$i]->analyse,'','','','','']);
          

        }
        
       

      
        
       return Excel::download(new CountryExport($result,count($compteA),count($compteB),$length), 'users'.date('Y-m-d').'.xlsx',\Maatwebsite\Excel\Excel::XLSX);
       
    }


    public function index(){
        $listCompte = DB::table('ELIT_ListeCompte')->get();
        
        return $listCompte;
    }

    public function search(Request $request){
        $from=$request->get('debut');
        $to=$request->get('fin');
        $ccb=$request->get('selected');

      
        if($ccb=="" || $from=="" || $to==""){
            return response()->json([
                "Error page"
            ], 404);
        }
        else{
            $list = DB::table('ELIT_LISTE_EcrituresNon_Rapproches')
            ->select('Code Autorisation as code','Montant','DateOperation')
            ->where('codeCompte',$ccb)->whereBetween('DateOperation',[$from,$to])->orderby('DateOperation','DESC')->get();
            return $list;
        }
    }
    public function searchB(Request $request){
        $from=$request->get('debut');
        $to=$request->get('fin');
        $code=$request->get('codeb');
        if($code=="" || $from=="" || $to==""){
            return response()->json([
                "Error page"
            ], 404);
        }
        else{
            $list = DB::table('ELIT_LISTE_EcrituresB_NonRapproches')
            ->select('Code Autorisation as code','dateOperation','montant')
            ->where('code',$code)->whereBetween('dateOperation',[$from,$to])->orderby('dateOperation','DESC')->get();
            return $list;
        }
    }

}
