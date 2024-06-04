<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('pessoa/existe', [\App\Http\Controllers\PessoaController::class, 'exist']);

Route::apiResource('pessoa',\App\Http\Controllers\PessoaController::class);

Route::apiResource('pessoa/{pessoa}/contato',\App\Http\Controllers\ContatoController::class);
