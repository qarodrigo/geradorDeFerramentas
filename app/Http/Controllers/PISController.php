<?php

namespace App\Http\Controllers;


class PISController extends Controller
{
    public function primeirosDigitos(){
        $primeirosDigitos = [];

        for ($i = 0; $i < 10; $i++) {
            $primeirosDigitos[$i] = rand(0, 9);
        }
        return $primeirosDigitos;
    }


    public function geraDigitoVerificador($primeirosDigitos){

        $total = 0;
        $pesos = [ 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

        for($i = 0; $i<10; $i++){
            $total += $pesos[$i] * $primeirosDigitos[$i];
        }

        $digito = 11 - ($total%11);

        if($digito == 11 || $digito == 10){
            $primeirosDigitos[] = 0;
        }else{
            $primeirosDigitos[] = $digito;
        }

        return ($primeirosDigitos);

    }

    public function geraPIS(){

        $primeirosDigitos = $this->primeirosDigitos();
        $pis = $this->geraDigitoVerificador($primeirosDigitos);
        return response()->json(implode($pis), 200);
    }

    public function validaPIS($pis){

        if(strlen($pis) !== 11){
            return response()->json('Tamanho Inválido', 404);
        }

        $primeirosDigitos = str_split($pis);
        $primeirosDigitos = array_slice($primeirosDigitos, 0, -1);
        $validado = $this->geraDigitoVerificador($primeirosDigitos);

        return response()->json(implode($validado) == $pis ? true : false, 200);


    }
}
