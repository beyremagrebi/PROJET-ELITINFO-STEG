<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\CountryExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SearchController extends Controller
{
    
 
    public function export($debut,$fin,$selected,$codeb)
    {
        
        $compteA = DB::table('ELIT_LISTE_EcrituresNon_Rapproches')
        ->select('Code Autorisation as code','Montant','DateOperation')
        ->where('codeCompte',$selected)->whereBetween('DateOperation',[$debut,$fin])->orderby('DateOperation','DESC')->get();

        $compteB=DB::table('ELIT_LISTE_EcrituresB_NonRapproches')
            ->select('Code Autorisation as code','dateOperation','montant')
            ->where('code',$codeb)->whereBetween('dateOperation',[$debut,$fin])->orderby('dateOperation','DESC')->get();

        $date=[['Date Debut'=>$debut,'Date Fin'=>$fin,'Code Compte Bancaire'=>$codeb]];
        $comptes=[];
        foreach($compteA as $value){
            array_push($comptes,$value);
        }
        foreach($compteB as $value){
            array_push($comptes,$value);
        }
       
        $arrays=[$date,$comptes];
     
       

        $result=[];
        
       return Excel::download(new CountryExport($arrays), 'users'.date('Y-m-d').'.xlsx',\Maatwebsite\Excel\Excel::XLSX);
       
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
