<?php

namespace App\Exceptions;

use Exception;

class ContatoNaoPertenceAPessoa extends Exception
{
    protected $code = 404;

    protected $message = 'Este contato não pertence a esta pessoa';
}
