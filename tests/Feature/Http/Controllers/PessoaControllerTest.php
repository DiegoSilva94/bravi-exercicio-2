<?php

afterEach(function () {
    \App\Models\Pessoa::all()->map->delete();
});

test('busca pessoas', function () {
    $responseSemPessoas = $this->get('/api/pessoa');

    $responseSemPessoas->assertStatus(200);
    $responseSemPessoas->assertJsonPath('data', []);

    $pessoa = \App\Models\Pessoa::factory()->create();

    $responseComContato = $this->getJson('/api/pessoa');
    $responseComContato->assertStatus(200);
    $responseComContato->assertJsonPath('data.0.nome', $pessoa->nome);
});


test('adiciona uma pessoa', function () {
    $nome = fake()->name;
    $responseAdicionaContato1 = $this->postJson('/api/pessoa', [
        'nome' => $nome
    ]);
    $responseAdicionaContato1->assertStatus(201);
    $responseAdicionaContato1->assertJsonPath('data.nome', $nome);
});

test('atualiza uma pessoa', function () {
    $pessoa = \App\Models\Pessoa::factory()->create();

    $novoNome = fake()->name;
    $responseAtualizaContato = $this->putJson('/api/pessoa/' . $pessoa->id, [
        'nome' => $novoNome
    ]);

    $responseAtualizaContato->assertStatus(200);
    $responseAtualizaContato->assertJsonPath('data.nome', $novoNome);
});

test('deleta uma pessoa', function () {
    $pessoa = \App\Models\Pessoa::factory()->create();

    $responseRemoveContato = $this->deleteJson('/api/pessoa/' . $pessoa->id);

    $responseRemoveContato->assertStatus(200);
    $responseRemoveContato->assertJsonPath('message', 'Pessoa removida com sucesso!');
});
