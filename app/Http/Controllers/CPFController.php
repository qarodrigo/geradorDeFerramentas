<?php

namespace App\Http\Controllers;

class CPFController extends Controller
{
    public function primeirosDigitos()
    {
        $primeirosDigitos = [];

        for ($i = 0; $i < 9; $i++) {
            $primeirosDigitos[$i] = rand(0, 9);
        }
        return $primeirosDigitos;
    }

    public function gerarNumerosDeValidacao($primeirosDigitos)
    {

        $total = 0;
        $base = sizeof($primeirosDigitos) == 10 ? 11 : 10;

        if (sizeof($primeirosDigitos) == 11) {
            return $primeirosDigitos;
        }

        foreach ($primeirosDigitos as $item) {
            $total += $item * $base;
            $base--;
        }

        $resto = $total % 11;
        $resto < 2 ?  $primeirosDigitos[] = 0 : $primeirosDigitos[] = 11 - $resto;

        return $this->gerarNumerosDeValidacao($primeirosDigitos);
    }

    public function geraCPF()
    {

        $primeirosDigitos = $this->primeirosDigitos();
        $cpf = $this->gerarNumerosDeValidacao($primeirosDigitos);
        return response()->json(implode($cpf), 200);
    }


    public function validaCPF($cpf)
    {

        if( strcmp($cpf, '11111111111') ||
            strcmp($cpf, '22222222222') || 
            strcmp($cpf, '33333333333') || 
            strcmp($cpf, '44444444444') || 
            strcmp($cpf, '55555555555') || 
            strcmp($cpf, '66666666666') || 
            strcmp($cpf, '77777777777') || 
            strcmp($cpf, '88888888888') || 
            strcmp($cpf, '99999999999'))

            return response()->json(false, 400);


        if(strlen($cpf) !== 11){
            return response()->json('Tamanho Inválido', 400);
        }

        $primeirosDigitos = str_split($cpf);
        $primeirosDigitos = array_slice($primeirosDigitos, 0, -2);
        $validado = $this->gerarNumerosDeValidacao($primeirosDigitos);

        if(implode($validado) == $cpf)
            return response()->json(true, 200);
        

        return response()->json(false, 400);
    }
}
