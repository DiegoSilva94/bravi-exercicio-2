<?php

namespace App\Http\Controllers;

use App\Exceptions\FalhaNaAtualizacao;
use App\Exceptions\FalhaNaExclusao;
use App\Exceptions\FalhaNoCadastro;
use App\Http\Requests\StorePessoaRequest;
use App\Http\Requests\UpdatePessoaRequest;
use App\Http\Resources\PessoaResource;
use App\Models\Pessoa;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PessoaController extends Controller
{
    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return PessoaResource::collection(Pessoa::all());
    }

    /**
     * @param StorePessoaRequest $request
     * @return PessoaResource
     * @throws FalhaNoCadastro
     */
    public function store(StorePessoaRequest $request): PessoaResource
    {
        if ($pessoa = Pessoa::create($request->only(['nome']))) {
            return new PessoaResource($pessoa);
        }
        throw new FalhaNoCadastro();
    }

    /**
     * @param Pessoa $pessoa
     * @return PessoaResource
     */
    public function show(Pessoa $pessoa): PessoaResource
    {
        return new PessoaResource($pessoa);
    }

    /**
     * @param UpdatePessoaRequest $request
     * @param Pessoa $pessoa
     * @return PessoaResource
     * @throws FalhaNaAtualizacao
     */
    public function update(UpdatePessoaRequest $request, Pessoa $pessoa): PessoaResource
    {
        if ($pessoa->update($request->only(['nome']))) {
            return new PessoaResource($pessoa);
        }
        throw new FalhaNaAtualizacao();
    }

    /**
     * @param Pessoa $pessoa
     * @return JsonResponse
     * @throws FalhaNaExclusao
     */
    public function destroy(Pessoa $pessoa): JsonResponse
    {
        if ($pessoa->delete()) {
            return response()->json([
                'message' => 'Pessoa removida com sucesso!'
            ]);
        }
        throw new FalhaNaExclusao();
    }
}
