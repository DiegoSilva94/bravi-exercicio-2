<?php

namespace App\Http\Controllers;

use App\Exceptions\ContatoNaoPertenceAPessoa;
use App\Exceptions\FalhaNaAtualizacao;
use App\Exceptions\FalhaNaExclusao;
use App\Exceptions\FalhaNoCadastro;
use App\Http\Requests\StoreContatoRequest;
use App\Http\Requests\UpdateContatoRequest;
use App\Http\Resources\ContatoResource;
use App\Models\Contato;
use App\Models\Pessoa;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ContatoController extends Controller
{
    /**
     * @param Pessoa $pessoa
     * @return AnonymousResourceCollection
     */
    public function index(Pessoa $pessoa): AnonymousResourceCollection
    {
        return ContatoResource::collection($pessoa->contatos);
    }

    /**
     * @param StoreContatoRequest $request
     * @param Pessoa $pessoa
     * @return ContatoResource
     * @throws FalhaNoCadastro
     */
    public function store(StoreContatoRequest $request, Pessoa $pessoa): ContatoResource
    {
        if ($contato = $pessoa->contatos()->create($request->only(['tipo', 'informacao']))) {
            return new ContatoResource($contato);
        }
        throw new FalhaNoCadastro();
    }

    /**
     * @param Pessoa $pessoa
     * @param Contato $contato
     * @return ContatoResource
     * @throws \Throwable
     */
    public function show(Pessoa $pessoa, Contato $contato): ContatoResource
    {
        throw_if($contato->pessoa_id !== $pessoa->id, new ContatoNaoPertenceAPessoa());

        return ContatoResource::make($contato);
    }

    /**
     * @param UpdateContatoRequest $request
     * @param Pessoa $pessoa
     * @param Contato $contato
     * @return ContatoResource
     * @throws FalhaNaAtualizacao
     * @throws \Throwable
     */
    public function update(UpdateContatoRequest $request, Pessoa $pessoa, Contato $contato): ContatoResource
    {
        throw_if($contato->pessoa_id !== $pessoa->id, new ContatoNaoPertenceAPessoa());

        if ($contato->update($request->only(['informacao']))) {
            return new ContatoResource($contato);
        }
        throw new FalhaNaAtualizacao();
    }

    /**
     * @param Pessoa $pessoa
     * @param Contato $contato
     * @return JsonResponse
     * @throws FalhaNaExclusao
     * @throws \Throwable
     */
    public function destroy(Pessoa $pessoa, Contato $contato): JsonResponse
    {
        throw_if($contato->pessoa_id !== $pessoa->id, new ContatoNaoPertenceAPessoa());

        if ($contato->delete()) {
            return response()->json([
                'message' => 'Contato removida com sucesso!'
            ]);
        }
        throw new FalhaNaExclusao();
    }
}
