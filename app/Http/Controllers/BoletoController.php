<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Boleto;

class BoletoController extends Controller
{
    public function VerificarBoletoLectura(Request $request){
        $id_boleto = $request->id_boleto;
        // $id_boleto = 3666;
        $evento = Boleto::find($id_boleto);

        //Validar si se pudo encontrar el boleto
        if ($evento) {
            if($evento->leido){
                echo json_encode(array("estado"=> 0,"mensaje"=>"El boleto ya fue leido"));
            }else{
                echo json_encode(array("estado"=> 1,"mensaje"=>"El boleto se encuentra disponible"));
            }
        } else {
            echo json_encode(array("estado"=> 0,"mensaje"=>"Boleto no encontrado"));
        }
    }

    public function guardarLecturaBoleto(Request $request){
        $id_boleto = $request->id_boleto;
        $boleto = Boleto::find($id_boleto);
        if($boleto){
            $boleto->leido = 1;
            $boleto->save();
            if($boleto->wasChanged('leido')){
                return json_encode(array("estado"=> 1,"mensaje"=>"Se guardo la lectura"));
            }else{
                return json_encode(array("estado"=> 0,"mensaje"=>"No se guardo la lectura"));
            }
        }else{
            return json_encode(array("estado"=> 0,"mensaje"=>"Boleto no encontrado"));
        }
    }
}
