<?php

namespace App\Exceptions;

use Exception;

class FalhaNoCadastro extends Exception
{
    protected $message = 'Não foi possivel realizar o cadastro com os dados informados';
}
