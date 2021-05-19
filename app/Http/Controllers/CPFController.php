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

        if(strlen($cpf) !== 11){
            return response()->json('Tamanho Inválido', 404);
        }

        $primeirosDigitos = str_split($cpf);
        $primeirosDigitos = array_slice($primeirosDigitos, 0, -2);
        $validado = $this->gerarNumerosDeValidacao($primeirosDigitos);

        return response()->json(implode($validado) == $cpf ? true : false, 200);
    }
}
