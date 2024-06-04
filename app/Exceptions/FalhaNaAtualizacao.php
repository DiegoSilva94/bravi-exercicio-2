<?php

namespace App\Exceptions;

use Exception;

class FalhaNaAtualizacao extends Exception
{
    protected $message = 'Não foi possivel atualizar o cadastro com os dados informados';
}
