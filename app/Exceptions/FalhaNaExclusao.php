<?php

namespace App\Exceptions;

use Exception;

class FalhaNaExclusao extends Exception
{
    protected $message = 'Não foi possivel remover o cadastro';
}
