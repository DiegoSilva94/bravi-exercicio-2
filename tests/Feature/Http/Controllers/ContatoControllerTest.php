<?php

beforeEach(function () {
    $this->pessoa = \App\Models\Pessoa::factory()
        ->create();
    $this->pessoaComContato = \App\Models\Pessoa::factory()
        ->has(\App\Models\Contato::factory()->count(3), 'contatos')
        ->create();
});

afterEach(function () {
    $this->pessoa->delete();
    $this->pessoaComContato->delete();
});

test('busca contatos da pessoa', function () {

    $responseSemContato = $this->getJson('/api/pessoa/' . $this->pessoa->id . '/contato');

    $responseSemContato->assertStatus(200);
    $responseSemContato->assertJsonPath('data', []);

    $responseComContato = $this->getJson('/api/pessoa/' . $this->pessoaComContato->id . '/contato');
    $responseComContato->assertStatus(200);
    $responseComContato->assertJsonPath('data.0.id', $this->pessoaComContato->contatos[0]->id);
    $responseComContato->assertJsonPath('data.1.id', $this->pessoaComContato->contatos[1]->id);
    $responseComContato->assertJsonPath('data.2.id', $this->pessoaComContato->contatos[2]->id);
});

test('adiciona contatos a uma pessoa', function () {
    $responseAdicionaContato1 = $this->postJson('/api/pessoa/' . $this->pessoa->id . '/contato', [
        'tipo' => 1,
        'informacao' => fake('pt_BR')->phoneNumber
    ]);
    $responseAdicionaContato1->assertStatus(201);
    $responseAdicionaContato1->assertJsonPath('data.tipo', 1);


    $responseAdicionaContato2 = $this->postJson('/api/pessoa/' . $this->pessoa->id . '/contato', [
        'tipo' => 2,
        'informacao' => fake('pt_BR')->email
    ]);
    $responseAdicionaContato2->assertStatus(201);
    $responseAdicionaContato2->assertJsonPath('data.tipo', 2);

    $responseAdicionaContato3 = $this->postJson('/api/pessoa/' . $this->pessoa->id . '/contato', [
        'tipo' => 3,
        'informacao' => fake('pt_BR')->cellphoneNumber
    ]);
    $responseAdicionaContato3->assertStatus(201);
    $responseAdicionaContato3->assertJsonPath('data.tipo', 3);
});

test('atualiza um contato a pessoa', function () {

    $updatePhone = fake('pt_BR')->phoneNumber;
    $responseAtualizaContato = $this->putJson('/api/pessoa/' . $this->pessoaComContato->id . '/contato/' . $this->pessoaComContato->contatos[0]->id, [
        'informacao' => $updatePhone
    ]);

    $responseAtualizaContato->assertStatus(200);
    $responseAtualizaContato->assertJsonPath('data.informacao', $updatePhone);
});

test('deleta um contato da pessoa', function () {
    $responseRemoveContato = $this->deleteJson('/api/pessoa/' . $this->pessoaComContato->id . '/contato/' . $this->pessoaComContato->contatos[0]->id);
    $responseRemoveContato->assertStatus(200);
    $responseRemoveContato->assertJsonPath('message', 'Contato removida com sucesso!');
});

